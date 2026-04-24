<div class="wrap mega-header-admin">
	<h1>Configurações do Mega Header</h1>

	<div class="notice notice-info" style="margin-top: 20px;">
		<p><strong>Como usar:</strong> Para exibir o cabeçalho no seu site, cole o shortcode <code>[mega_header]</code> no topo do seu tema, na sua página ou no Elementor/Construtor de Páginas que estiver utilizando.</p>
	</div>
	
	<div class="mh-card">
		<h2>Logos</h2>
		<table class="form-table">
			<tr>
				<th scope="row"><label>Logo Fixa (Topo)</label></th>
				<td>
					<div class="mh-image-upload" id="logo_fixed_wrap">
						<img id="logo_fixed_preview" src="" style="max-height: 80px; display: none; margin-bottom: 10px;" />
						<br>
						<input type="hidden" id="logo_fixed" value="" />
						<button type="button" class="button mh-upload-btn" data-target="logo_fixed">Selecionar Imagem</button>
						<button type="button" class="button mh-remove-btn" data-target="logo_fixed" style="display: none;">Remover</button>
					</div>
					<p class="description" style="margin-top: 10px;">Altura máxima da logo no topo (ex: 50): <input type="number" id="logo_fixed_size" style="width: 70px;" value="" placeholder="50" /> px</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Logo ao Rolar (Sticky)</label></th>
				<td>
					<div class="mh-image-upload" id="logo_scroll_wrap">
						<img id="logo_scroll_preview" src="" style="max-height: 80px; display: none; margin-bottom: 10px;" />
						<br>
						<input type="hidden" id="logo_scroll" value="" />
						<button type="button" class="button mh-upload-btn" data-target="logo_scroll">Selecionar Imagem</button>
						<button type="button" class="button mh-remove-btn" data-target="logo_scroll" style="display: none;">Remover</button>
					</div>
					<p class="description" style="margin-top: 10px;">Altura máxima da logo ao rolar a página (ex: 40): <input type="number" id="logo_scroll_size" style="width: 70px;" value="" placeholder="40" /> px</p>
				</td>
			</tr>
		</table>
	</div>

	<div class="mh-card">
		<h2>Estilos e Cores</h2>
		<table class="form-table">
			<tr>
				<th scope="row"><label>Cores do Fundo (Topo)</label></th>
				<td>
					Cor: <input type="color" id="bg_fixed_color" value="#ffffff" />
					<span style="margin-left: 15px;">Opacidade:</span> <input type="number" id="bg_fixed_opacity" style="width: 70px;" min="0" max="1" step="0.01" value="1" placeholder="1" />
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Cores do Fundo (Ao Rolar)</label></th>
				<td>
					Cor: <input type="color" id="bg_scroll_color" value="#ffffff" />
					<span style="margin-left: 15px;">Opacidade:</span> <input type="number" id="bg_scroll_opacity" style="width: 70px;" min="0" max="1" step="0.01" value="0.98" placeholder="0.98" />
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Largura Máxima do Cabeçalho</label></th>
				<td>
					<input type="number" id="header_max_width" style="width: 80px;" value="" placeholder="1200" /> px
					<p class="description">Defina a largura limite do seu cabeçalho (ex: 1200, 1400, 1600). Deixe em branco para usar o padrão (1200px).</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Fonte dos Menus</label></th>
				<td>
					Cor da Fonte: <input type="color" id="menu_font_color" value="#333333" />
					<span style="margin-left: 15px;">Cor ao passar o mouse (Hover):</span> <input type="color" id="menu_font_hover_color" value="#007bff" />
					<br><br>
					Tamanho da fonte: <input type="number" id="menu_font_size" style="width: 70px;" value="14" placeholder="14" /> px
					<br><br>
					<label for="menu_font_family" style="display:inline-block; min-width: 160px;">Família da Fonte (Google Fonts):</label>
					<select id="menu_font_family" style="min-width: 220px;">
						<option value="">— Padrão do tema —</option>
						<?php
						$google_fonts = array(
							'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Poppins', 'Inter',
							'Raleway', 'Oswald', 'Nunito', 'Nunito Sans', 'Merriweather',
							'Playfair Display', 'Ubuntu', 'Work Sans', 'Mulish', 'Rubik',
							'PT Sans', 'PT Serif', 'Source Sans 3', 'Source Serif 4',
							'Noto Sans', 'Noto Serif', 'Quicksand', 'Barlow', 'Karla',
							'DM Sans', 'DM Serif Display', 'Manrope', 'Fira Sans', 'Cabin',
							'Heebo', 'Titillium Web', 'Bebas Neue', 'Archivo', 'Josefin Sans',
							'Libre Franklin', 'Libre Baskerville', 'Hind', 'Anton', 'Dosis',
							'Teko', 'Exo 2', 'Cairo', 'Arimo', 'Bitter', 'Crimson Text',
							'Lora', 'EB Garamond', 'Zilla Slab', 'Space Grotesk', 'Space Mono',
							'Figtree', 'Outfit', 'Plus Jakarta Sans', 'Urbanist', 'Be Vietnam Pro'
						);
						sort( $google_fonts );
						foreach ( $google_fonts as $gf ) {
							echo '<option value="' . esc_attr( $gf ) . '">' . esc_html( $gf ) . '</option>';
						}
						?>
					</select>
					<br><br>
					<label for="menu_font_weight" style="display:inline-block; min-width: 160px;">Peso da Fonte:</label>
					<select id="menu_font_weight" style="min-width: 120px;">
						<option value="">Padrão</option>
						<option value="100">100 - Thin</option>
						<option value="200">200 - Extra Light</option>
						<option value="300">300 - Light</option>
						<option value="400">400 - Regular</option>
						<option value="500">500 - Medium</option>
						<option value="600">600 - Semi Bold</option>
						<option value="700">700 - Bold</option>
						<option value="800">800 - Extra Bold</option>
						<option value="900">900 - Black</option>
					</select>
					<br><br>
					<label for="menu_line_height" style="display:inline-block; min-width: 160px;">Altura da Linha (Line Height):</label>
					<input type="number" id="menu_line_height" style="width: 90px;" min="0" step="0.1" value="" placeholder="1.5" />
					<p class="description">Valor sem unidade (ex: 1.2, 1.5, 1.75). Deixe em branco para usar o padrão.</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Texto dos Itens do Mega Menu</label></th>
				<td>
					<p class="description" style="margin-top:0;">Estilo do texto que aparece abaixo da imagem em cada item do Mega Menu.</p>
					Cor da Fonte: <input type="color" id="subitem_font_color" value="#333333" />
					<span style="margin-left: 15px;">Cor ao passar o mouse (Hover):</span> <input type="color" id="subitem_font_hover_color" value="#007bff" />
					<br><br>
					Tamanho da fonte: <input type="number" id="subitem_font_size" style="width: 70px;" value="" placeholder="14" /> px
					<br><br>
					<label for="subitem_font_family" style="display:inline-block; min-width: 160px;">Família da Fonte (Google Fonts):</label>
					<select id="subitem_font_family" style="min-width: 220px;">
						<option value="">— Padrão do tema —</option>
						<?php
						foreach ( $google_fonts as $gf ) {
							echo '<option value="' . esc_attr( $gf ) . '">' . esc_html( $gf ) . '</option>';
						}
						?>
					</select>
					<br><br>
					<label for="subitem_font_weight" style="display:inline-block; min-width: 160px;">Peso da Fonte:</label>
					<select id="subitem_font_weight" style="min-width: 120px;">
						<option value="">Padrão</option>
						<option value="100">100 - Thin</option>
						<option value="200">200 - Extra Light</option>
						<option value="300">300 - Light</option>
						<option value="400">400 - Regular</option>
						<option value="500">500 - Medium</option>
						<option value="600">600 - Semi Bold</option>
						<option value="700">700 - Bold</option>
						<option value="800">800 - Extra Bold</option>
						<option value="900">900 - Black</option>
					</select>
					<br><br>
					<label for="subitem_line_height" style="display:inline-block; min-width: 160px;">Altura da Linha (Line Height):</label>
					<input type="number" id="subitem_line_height" style="width: 90px;" min="0" step="0.1" value="" placeholder="1.5" />
					<p class="description">Valor sem unidade (ex: 1.2, 1.5, 1.75). Deixe em branco para usar o padrão.</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Sombra do Cabeçalho</label></th>
				<td>
					<select id="header_shadow">
						<option value="none">Sem Sombra (Clean)</option>
						<option value="light" selected>Leve (Padrão)</option>
						<option value="medium">Média</option>
						<option value="heavy">Forte</option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Tamanho das Imagens (Mega Menu)</label></th>
				<td>
					Largura máxima (ex: 200): <input type="number" id="subitem_image_width" style="width: 70px;" value="" placeholder="200" /> px
					<br><br>
					Altura fixa do quadro (ex: 150): <input type="number" id="subitem_image_height" style="width: 70px;" value="" placeholder="150" /> px
					<p class="description">Definir uma <strong>altura fixa</strong> garante que os textos fiquem perfeitamente alinhados horizontalmente, mesmo que as imagens tenham formatos ou tamanhos diferentes. Recomendado usar valores entre 150 e 250.</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label>Comportamento na Página</label></th>
				<td>
					<label>
						<input type="checkbox" id="overlap_content" value="yes" />
						Sobrepor o conteúdo do site (Desativar espaçador invisível)
					</label>
					<p class="description">Marque esta opção se você quiser que o cabeçalho fique transparente e flutuando "em cima" da sua primeira seção (ex: um banner). Se estiver desmarcado, o cabeçalho empurrará o site para baixo para não esconder o conteúdo.</p>
				</td>
			</tr>
		</table>
	</div>

	<div class="mh-card">
		<h2>Menus Principais e Mega Menus</h2>
		<p class="description">Adicione os itens do menu principal. Para cada item, você pode adicionar sub-itens que aparecerão no Mega Menu (com foto, texto e link). Arraste pela alça para reordenar menus e itens.</p>
		
		<div id="menus_container" class="mh-menus-list"></div>
		
		<p>
			<button type="button" class="button button-secondary" id="add_menu_btn">+ Adicionar Menu Principal</button>
		</p>
	</div>

	<div class="mh-actions" style="margin-top: 20px;">
		<button type="button" class="button button-primary button-large" id="save_settings_btn">Salvar Configurações</button>
		<span id="save_status" style="margin-left: 10px; font-weight: bold;"></span>
	</div>
</div>

<template id="tpl-menu-item">
	<div class="mh-menu-item" data-index="{index}">
		<div class="mh-menu-header">
			<div class="mh-menu-header-main">
				<button type="button" class="mh-sort-handle mh-menu-sort-handle" aria-label="Arrastar para ordenar menu">
					<span class="dashicons dashicons-move" aria-hidden="true"></span>
				</button>
				<h3><span class="dashicons dashicons-arrow-right-alt2 mh-accordion-icon"></span> Menu: <span class="mh-menu-title-display">{title}</span></h3>
			</div>
			<button type="button" class="button mh-remove-menu-btn" style="color: red;">Remover Menu</button>
		</div>
		<div class="mh-menu-body" style="display: none;">
			<table class="form-table">
				<tr>
					<th><label>Título do Menu Pai</label></th>
					<td><input type="text" class="regular-text mh-input-title" value="{title}" placeholder="Ex: Drones" /></td>
				</tr>
				<tr>
					<th><label>Link do Menu Pai</label></th>
					<td><input type="text" class="regular-text mh-input-link" value="{link}" placeholder="Ex: # ou https://..." /></td>
				</tr>
			</table>

			<h4>Itens do Mega Menu</h4>
			<div class="mh-subitems-container"></div>
			<button type="button" class="button button-small mh-add-subitem-btn">+ Adicionar Item ao Mega Menu</button>
		</div>
	</div>
</template>

<template id="tpl-subitem">
	<div class="mh-subitem" data-subindex="{subindex}">
		<button type="button" class="mh-sort-handle mh-subitem-sort-handle" aria-label="Arrastar para ordenar item do mega menu">
			<span class="dashicons dashicons-move" aria-hidden="true"></span>
		</button>
		<div class="mh-subitem-image" title="Foto Principal">
			<span style="font-size: 10px; color: #666;">Foto Principal</span>
			<img src="{image_url}" class="mh-subitem-preview" style="display: {display_img}; max-width: 80px; max-height: 50px;" />
			<input type="hidden" class="mh-subitem-image-input" value="{image_url}" />
			<button type="button" class="button button-small mh-upload-subitem-btn">Mídia</button>
		</div>
		<div class="mh-subitem-image" title="Foto ao passar o mouse">
			<span style="font-size: 10px; color: #666;">Foto Hover (Opcional)</span>
			<img src="{image_hover_url}" class="mh-subitem-hover-preview" style="display: {display_hover_img}; max-width: 80px; max-height: 50px;" />
			<input type="hidden" class="mh-subitem-hover-input" value="{image_hover_url}" />
			<button type="button" class="button button-small mh-upload-hover-btn">Mídia Hover</button>
		</div>
		<div class="mh-subitem-fields">
			<input type="text" class="mh-subitem-text" value="{text}" placeholder="Texto abaixo da foto (Ex: Mavic 3)" />
			<input type="text" class="mh-subitem-link" value="{link}" placeholder="Link do produto" />
		</div>
		<div class="mh-subitem-actions">
			<button type="button" class="button button-small mh-remove-subitem-btn" style="color: red;">X</button>
		</div>
	</div>
</template>
