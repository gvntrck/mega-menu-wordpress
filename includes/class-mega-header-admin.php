<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mega_Header_Admin {

	public function init() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'wp_ajax_mega_header_save', array( $this, 'ajax_save_settings' ) );
	}

	public function add_admin_menu() {
		add_menu_page(
			'Mega Header',
			'Mega Header',
			'manage_options',
			'mega-header',
			array( $this, 'render_admin_page' ),
			'dashicons-menu-alt3',
			80
		);
	}

	public function enqueue_admin_scripts( $hook ) {
		if ( 'toplevel_page_mega-header' !== $hook ) {
			return;
		}

		wp_enqueue_media();

		wp_enqueue_style(
			'mega-header-admin-css',
			MEGA_HEADER_PLUGIN_URL . 'assets/admin/admin.css',
			array(),
			MEGA_HEADER_VERSION
		);

		wp_enqueue_script(
			'mega-header-admin-js',
			MEGA_HEADER_PLUGIN_URL . 'assets/admin/admin.js',
			array( 'jquery', 'jquery-ui-sortable' ),
			MEGA_HEADER_VERSION,
			true
		);

		wp_localize_script( 'mega-header-admin-js', 'megaHeaderAdminVars', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'mega_header_nonce' ),
			'data'     => get_option( 'mega_header_data', '{"logo_fixed":"", "logo_scroll":"", "menus":[]}' )
		) );
	}

	public function render_admin_page() {
		require_once MEGA_HEADER_PLUGIN_DIR . 'views/admin-page.php';
	}

	public function ajax_save_settings() {
		check_ajax_referer( 'mega_header_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'Permission denied.' );
		}

		$data = isset( $_POST['data'] ) ? wp_unslash( $_POST['data'] ) : '';
		
		if ( ! empty( $data ) ) {
			// Save the JSON string
			update_option( 'mega_header_data', $data );
			wp_send_json_success( 'Configurações salvas com sucesso!' );
		}

		wp_send_json_error( 'Nenhum dado recebido.' );
	}
}
