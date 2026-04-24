<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mega_Header_Frontend {

	public function init() {
		add_shortcode( 'mega_header', array( $this, 'render_shortcode' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	public function enqueue_scripts() {
		// Swiper CSS
		wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0' );
		
		// Plugin CSS
		wp_enqueue_style( 'mega-header-css', MEGA_HEADER_PLUGIN_URL . 'assets/frontend/header.css', array(), MEGA_HEADER_VERSION );

		// Swiper JS
		wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true );

		// Plugin JS
		wp_enqueue_script( 'mega-header-js', MEGA_HEADER_PLUGIN_URL . 'assets/frontend/header.js', array( 'jquery', 'swiper-js' ), MEGA_HEADER_VERSION, true );
	}

	public function render_shortcode( $atts ) {
		$data_json = get_option( 'mega_header_data', '{"menus":[]}' );
		$data = json_decode( $data_json, true );

		if ( ! is_array( $data ) ) {
			return '';
		}

		$logo_fixed = ! empty( $data['logo_fixed'] ) ? esc_url( $data['logo_fixed'] ) : '';
		$logo_scroll = ! empty( $data['logo_scroll'] ) ? esc_url( $data['logo_scroll'] ) : $logo_fixed;
		$logo_fixed_size = ! empty( $data['logo_fixed_size'] ) ? intval( $data['logo_fixed_size'] ) : 50;
		$logo_scroll_size = ! empty( $data['logo_scroll_size'] ) ? intval( $data['logo_scroll_size'] ) : 40;
		$menus = ! empty( $data['menus'] ) ? $data['menus'] : array();

		// Styles
		$bg_fixed_color = ! empty( $data['bg_fixed_color'] ) ? sanitize_hex_color( $data['bg_fixed_color'] ) : '#ffffff';
		$bg_fixed_opacity = isset( $data['bg_fixed_opacity'] ) && $data['bg_fixed_opacity'] !== '' ? floatval( $data['bg_fixed_opacity'] ) : 1;
		$bg_scroll_color = ! empty( $data['bg_scroll_color'] ) ? sanitize_hex_color( $data['bg_scroll_color'] ) : '#ffffff';
		$bg_scroll_opacity = isset( $data['bg_scroll_opacity'] ) && $data['bg_scroll_opacity'] !== '' ? floatval( $data['bg_scroll_opacity'] ) : 0.98;
		$menu_font_color = ! empty( $data['menu_font_color'] ) ? sanitize_hex_color( $data['menu_font_color'] ) : '#333333';
		$menu_font_hover_color = ! empty( $data['menu_font_hover_color'] ) ? sanitize_hex_color( $data['menu_font_hover_color'] ) : '#007bff';
		$menu_font_size = ! empty( $data['menu_font_size'] ) ? intval( $data['menu_font_size'] ) : 14;
		$menu_font_family = ! empty( $data['menu_font_family'] ) ? sanitize_text_field( $data['menu_font_family'] ) : '';
		$menu_font_weight = ! empty( $data['menu_font_weight'] ) ? preg_replace( '/[^0-9]/', '', $data['menu_font_weight'] ) : '';
		$menu_line_height = isset( $data['menu_line_height'] ) && $data['menu_line_height'] !== '' ? floatval( $data['menu_line_height'] ) : '';

		// Subitem (mega menu item text) typography
		$subitem_font_color = ! empty( $data['subitem_font_color'] ) ? sanitize_hex_color( $data['subitem_font_color'] ) : '';
		$subitem_font_hover_color = ! empty( $data['subitem_font_hover_color'] ) ? sanitize_hex_color( $data['subitem_font_hover_color'] ) : '';
		$subitem_font_size = ! empty( $data['subitem_font_size'] ) ? intval( $data['subitem_font_size'] ) : '';
		$subitem_font_family = ! empty( $data['subitem_font_family'] ) ? sanitize_text_field( $data['subitem_font_family'] ) : '';
		$subitem_font_weight = ! empty( $data['subitem_font_weight'] ) ? preg_replace( '/[^0-9]/', '', $data['subitem_font_weight'] ) : '';
		$subitem_line_height = isset( $data['subitem_line_height'] ) && $data['subitem_line_height'] !== '' ? floatval( $data['subitem_line_height'] ) : '';

		// Build Google Fonts URL combining both families (menu + subitem)
		$font_families = array();
		if ( $menu_font_family ) {
			$font_families[ $menu_font_family ] = $menu_font_weight ? $menu_font_weight : '400;500;600;700';
		}
		if ( $subitem_font_family ) {
			if ( isset( $font_families[ $subitem_font_family ] ) ) {
				// Merge weights
				$existing = explode( ';', $font_families[ $subitem_font_family ] );
				if ( $subitem_font_weight ) {
					$existing[] = $subitem_font_weight;
				}
				$existing = array_unique( array_filter( $existing ) );
				sort( $existing );
				$font_families[ $subitem_font_family ] = implode( ';', $existing );
			} else {
				$font_families[ $subitem_font_family ] = $subitem_font_weight ? $subitem_font_weight : '400;500;600;700';
			}
		}

		$google_font_url = '';
		if ( ! empty( $font_families ) ) {
			$parts = array();
			foreach ( $font_families as $family => $weights ) {
				$parts[] = 'family=' . str_replace( ' ', '+', $family ) . ':wght@' . $weights;
			}
			$google_font_url = 'https://fonts.googleapis.com/css2?' . implode( '&', $parts ) . '&display=swap';
		}
		$header_shadow = ! empty( $data['header_shadow'] ) ? sanitize_text_field( $data['header_shadow'] ) : 'light';
		$header_max_width = ! empty( $data['header_max_width'] ) ? intval( $data['header_max_width'] ) : '';
		$subitem_image_width = ! empty( $data['subitem_image_width'] ) ? intval( $data['subitem_image_width'] ) : '';
		$subitem_image_height = ! empty( $data['subitem_image_height'] ) ? intval( $data['subitem_image_height'] ) : '';
		$overlap_content = isset( $data['overlap_content'] ) ? $data['overlap_content'] : 'no';

		// Shadow logic
		$box_shadow = '0 4px 20px rgba(0,0,0,0.05)'; // default light
		if ( $header_shadow === 'none' ) {
			$box_shadow = 'none';
		} elseif ( $header_shadow === 'medium' ) {
			$box_shadow = '0 5px 25px rgba(0,0,0,0.15)';
		} elseif ( $header_shadow === 'heavy' ) {
			$box_shadow = '0 8px 30px rgba(0,0,0,0.3)';
		}

		// Hex to RGBA inline converter
		$hex2rgba = function($color, $opacity) {
			if (empty($color) || $color[0] !== '#') return 'rgba(255,255,255,1)';
			$color = substr($color, 1);
			$hex = (strlen($color) === 3) ? array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]) : array($color[0].$color[1], $color[2].$color[3], $color[4].$color[5]);
			$rgb = array_map('hexdec', $hex);
			return 'rgba('.implode(",", $rgb).','.$opacity.')';
		};

		ob_start();
		?>
		<?php if ( $google_font_url ) : ?>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link rel="stylesheet" href="<?php echo esc_url( $google_font_url ); ?>">
		<?php endif; ?>
		<style>
			:root {
				--mh-height-fixed: <?php echo ( $logo_fixed_size + 40 ); ?>px;
				--mh-height-scrolled: <?php echo ( $logo_scroll_size + 30 ); ?>px;
				--mh-shadow: <?php echo $box_shadow; ?>;
			}
			.mh-header {
				background: <?php echo $hex2rgba($bg_fixed_color, $bg_fixed_opacity); ?> !important;
			}
			<?php if ( $header_max_width ) : ?>
			.mh-container, .mh-swiper {
				max-width: <?php echo $header_max_width; ?>px !important;
			}
			<?php endif; ?>
			.mh-header.is-scrolled {
				background: <?php echo $hex2rgba($bg_scroll_color, $bg_scroll_opacity); ?> !important;
			}
			.mh-menu-link {
				color: <?php echo $menu_font_color; ?> !important;
				font-size: <?php echo $menu_font_size; ?>px !important;
				<?php if ( $menu_font_family ) : ?>
				font-family: "<?php echo esc_attr( $menu_font_family ); ?>", sans-serif !important;
				<?php endif; ?>
				<?php if ( $menu_font_weight ) : ?>
				font-weight: <?php echo intval( $menu_font_weight ); ?> !important;
				<?php endif; ?>
				<?php if ( $menu_line_height !== '' ) : ?>
				line-height: <?php echo $menu_line_height; ?> !important;
				<?php endif; ?>
			}
			.mh-menu-link:hover {
				color: <?php echo $menu_font_hover_color; ?> !important;
			}
			.mh-product-title {
				<?php if ( $subitem_font_color ) : ?>
				color: <?php echo $subitem_font_color; ?> !important;
				<?php endif; ?>
				<?php if ( $subitem_font_size ) : ?>
				font-size: <?php echo $subitem_font_size; ?>px !important;
				<?php endif; ?>
				<?php if ( $subitem_font_family ) : ?>
				font-family: "<?php echo esc_attr( $subitem_font_family ); ?>", sans-serif !important;
				<?php endif; ?>
				<?php if ( $subitem_font_weight ) : ?>
				font-weight: <?php echo intval( $subitem_font_weight ); ?> !important;
				<?php endif; ?>
				<?php if ( $subitem_line_height !== '' ) : ?>
				line-height: <?php echo $subitem_line_height; ?> !important;
				<?php endif; ?>
			}
			<?php if ( $subitem_font_hover_color ) : ?>
			.mh-product-card a:hover .mh-product-title,
			.swiper-slide.mh-product-card:hover .mh-product-title {
				color: <?php echo $subitem_font_hover_color; ?> !important;
			}
			<?php endif; ?>
			<?php if ( $subitem_image_width || $subitem_image_height ) : ?>
			.mh-img-wrapper {
				<?php if ( $subitem_image_height ) : ?>
				height: <?php echo $subitem_image_height; ?>px !important;
				<?php else: ?>
				height: auto !important;
				<?php endif; ?>
			}
			.mh-img-wrapper img {
				<?php if ( $subitem_image_width ) : ?>
				max-width: <?php echo $subitem_image_width; ?>px !important;
				<?php endif; ?>
				<?php if ( $subitem_image_height ) : ?>
				max-height: 100% !important;
				<?php else: ?>
				height: auto !important;
				<?php endif; ?>
				object-fit: contain;
			}
			<?php endif; ?>
			.mh-header .mh-logo-img {
				max-height: <?php echo $logo_fixed_size; ?>px;
				width: auto;
			}
			.mh-header.is-scrolled .mh-logo-img {
				max-height: <?php echo $logo_scroll_size; ?>px;
				width: auto;
			}
		</style>
		<header class="mh-header" id="mh-header">
			<div class="mh-container">
				
				<div class="mh-logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php if ( $logo_fixed ) : ?>
							<img src="<?php echo $logo_fixed; ?>" alt="Logo" class="mh-logo-img" data-fixed="<?php echo $logo_fixed; ?>" data-scroll="<?php echo $logo_scroll; ?>" />
						<?php else: ?>
							<h2><?php echo get_bloginfo( 'name' ); ?></h2>
						<?php endif; ?>
					</a>
				</div>

				<div class="mh-mobile-toggle" id="mh-mobile-toggle">
					<span></span>
					<span></span>
					<span></span>
				</div>

				<nav class="mh-nav" id="mh-nav">
					<ul class="mh-menu">
						<?php foreach ( $menus as $menu ) : 
							$has_sub = ! empty( $menu['subitems'] ) && count( $menu['subitems'] ) > 0;
							$link = ! empty( $menu['link'] ) ? esc_url( $menu['link'] ) : '#';
							$title = ! empty( $menu['title'] ) ? esc_html( $menu['title'] ) : '';
						?>
							<li class="mh-menu-item <?php echo $has_sub ? 'mh-has-dropdown' : ''; ?>">
								<a href="<?php echo $link; ?>" class="mh-menu-link">
									<?php echo $title; ?> 
									<?php if ( $has_sub ) : ?><span class="mh-arrow"></span><?php endif; ?>
								</a>
								
								<?php if ( $has_sub ) : ?>
									<div class="mh-mega-menu">
										<div class="swiper mh-swiper">
											<div class="swiper-wrapper">
												<?php foreach ( $menu['subitems'] as $sub ) : 
													$sub_link = ! empty( $sub['link'] ) ? esc_url( $sub['link'] ) : '#';
													$sub_img = ! empty( $sub['image'] ) ? esc_url( $sub['image'] ) : '';
													$sub_img_hover = ! empty( $sub['image_hover'] ) ? esc_url( $sub['image_hover'] ) : '';
													$sub_text = ! empty( $sub['text'] ) ? esc_html( $sub['text'] ) : '';
												?>
													<div class="swiper-slide mh-product-card">
														<a href="<?php echo $sub_link; ?>">
															<?php if ( $sub_img ) : ?>
																<div class="mh-img-wrapper <?php echo $sub_img_hover ? 'mh-has-hover' : ''; ?>">
																	<img src="<?php echo $sub_img; ?>" alt="<?php echo esc_attr( $sub_text ); ?>" class="mh-img-main" />
																	<?php if ( $sub_img_hover ) : ?>
																		<img src="<?php echo $sub_img_hover; ?>" alt="<?php echo esc_attr( $sub_text ); ?> Hover" class="mh-img-hover" />
																	<?php endif; ?>
																</div>
															<?php endif; ?>
															<?php if ( $sub_text ) : ?>
																<span class="mh-product-title"><?php echo $sub_text; ?></span>
															<?php endif; ?>
														</a>
													</div>
												<?php endforeach; ?>
											</div>
											<!-- Navigation -->
											<div class="swiper-button-next mh-swiper-next"></div>
											<div class="swiper-button-prev mh-swiper-prev"></div>
										</div>
									</div>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			</div>
		</header>
		<?php if ( $overlap_content !== 'yes' ) : ?>
		<!-- Spacer to prevent content jump since header is fixed -->
		<div class="mh-header-spacer"></div>
		<?php endif; ?>
		<?php
		return ob_get_clean();
	}
}
