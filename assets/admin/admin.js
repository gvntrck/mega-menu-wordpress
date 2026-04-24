jQuery(document).ready(function($) {

	// 1. Media Uploader function
	function mhOpenMediaUploader(button, callback) {
		var custom_uploader = wp.media({
			title: 'Selecionar Imagem',
			button: { text: 'Usar esta imagem' },
			multiple: false
		});
		custom_uploader.on('select', function() {
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			callback(attachment);
		});
		custom_uploader.open();
	}

	// Logos Upload
	$('.mh-upload-btn').on('click', function(e) {
		e.preventDefault();
		var btn = $(this);
		var targetId = btn.data('target');
		mhOpenMediaUploader(btn, function(attachment) {
			$('#' + targetId).val(attachment.url);
			$('#' + targetId + '_preview').attr('src', attachment.url).show();
			btn.siblings('.mh-remove-btn').show();
		});
	});

	$('.mh-remove-btn').on('click', function(e) {
		e.preventDefault();
		var btn = $(this);
		var targetId = btn.data('target');
		$('#' + targetId).val('');
		$('#' + targetId + '_preview').attr('src', '').hide();
		btn.hide();
	});

	// 2. Menu Builder Logic
	var menusContainer = $('#menus_container');
	var tplMenu = $('#tpl-menu-item').html();
	var tplSubitem = $('#tpl-subitem').html();

	function refreshSortables() {
		if (!$.fn.sortable) {
			return;
		}

		if (menusContainer.data('ui-sortable')) {
			menusContainer.sortable('refresh');
		} else {
			menusContainer.sortable({
				items: '> .mh-menu-item',
				handle: '.mh-menu-sort-handle',
				cancel: 'input, textarea, select, option',
				placeholder: 'mh-sort-placeholder mh-menu-sort-placeholder',
				forcePlaceholderSize: true,
				tolerance: 'pointer',
				axis: 'y',
				start: function(event, ui) {
					ui.placeholder.height(ui.item.outerHeight());
					ui.item.addClass('is-sorting');
				},
				stop: function(event, ui) {
					ui.item.removeClass('is-sorting');
				}
			});
		}

		menusContainer.find('.mh-subitems-container').each(function() {
			var $container = $(this);

			if ($container.data('ui-sortable')) {
				$container.sortable('refresh');
				return;
			}

			$container.sortable({
				items: '> .mh-subitem',
				handle: '.mh-subitem-sort-handle',
				cancel: 'input, textarea, select, option',
				placeholder: 'mh-sort-placeholder mh-subitem-sort-placeholder',
				forcePlaceholderSize: true,
				tolerance: 'pointer',
				axis: 'y',
				start: function(event, ui) {
					ui.placeholder.height(ui.item.outerHeight());
					ui.item.addClass('is-sorting');
				},
				stop: function(event, ui) {
					ui.item.removeClass('is-sorting');
				}
			});
		});
	}

	function renderData(data) {
		// Set logos
		if (data.logo_fixed) {
			$('#logo_fixed').val(data.logo_fixed);
			$('#logo_fixed_preview').attr('src', data.logo_fixed).show();
			$('.mh-remove-btn[data-target="logo_fixed"]').show();
		}
		if (data.logo_fixed_size) {
			$('#logo_fixed_size').val(data.logo_fixed_size);
		}
		if (data.logo_scroll) {
			$('#logo_scroll').val(data.logo_scroll);
			$('#logo_scroll_preview').attr('src', data.logo_scroll).show();
			$('.mh-remove-btn[data-target="logo_scroll"]').show();
		}
		if (data.logo_scroll_size) {
			$('#logo_scroll_size').val(data.logo_scroll_size);
		}

		// Set styles
		if (data.bg_fixed_color) $('#bg_fixed_color').val(data.bg_fixed_color);
		if (data.bg_fixed_opacity) $('#bg_fixed_opacity').val(data.bg_fixed_opacity);
		if (data.bg_scroll_color) $('#bg_scroll_color').val(data.bg_scroll_color);
		if (data.bg_scroll_opacity) $('#bg_scroll_opacity').val(data.bg_scroll_opacity);
		if (data.header_max_width) $('#header_max_width').val(data.header_max_width);
		if (data.menu_font_color) $('#menu_font_color').val(data.menu_font_color);
		if (data.menu_font_hover_color) $('#menu_font_hover_color').val(data.menu_font_hover_color);
		if (data.menu_font_size) $('#menu_font_size').val(data.menu_font_size);
		if (data.header_shadow) $('#header_shadow').val(data.header_shadow);
		if (data.subitem_image_width) $('#subitem_image_width').val(data.subitem_image_width);
		if (data.subitem_image_height) $('#subitem_image_height').val(data.subitem_image_height);
		if (data.overlap_content === 'yes') {
			$('#overlap_content').prop('checked', true);
		} else {
			$('#overlap_content').prop('checked', false);
		}

		// Set menus
		menusContainer.empty();
		if (data.menus && data.menus.length > 0) {
			data.menus.forEach(function(menu, index) {
				addMenuToDom(menu, index);
			});
		}

		refreshSortables();
	}

	function addMenuToDom(menu, index) {
		var html = tplMenu
			.replace(/{index}/g, index)
			.replace(/{title}/g, menu.title || '')
			.replace(/{link}/g, menu.link || '');
		var $el = $(html);
		
		var subContainer = $el.find('.mh-subitems-container');
		if (menu.subitems && menu.subitems.length > 0) {
			menu.subitems.forEach(function(subitem, subindex) {
				addSubitemToDom(subContainer, subitem, subindex);
			});
		}
		menusContainer.append($el);
		refreshSortables();
	}

	function addSubitemToDom(container, subitem, subindex) {
		var html = tplSubitem
			.replace(/{subindex}/g, subindex)
			.replace(/{image_url}/g, subitem.image || '')
			.replace(/{display_img}/g, subitem.image ? 'block' : 'none')
			.replace(/{image_hover_url}/g, subitem.image_hover || '')
			.replace(/{display_hover_img}/g, subitem.image_hover ? 'block' : 'none')
			.replace(/{text}/g, subitem.text || '')
			.replace(/{link}/g, subitem.link || '');
		container.append(html);
		refreshSortables();
	}

	// UI Events for Builder
	$('#add_menu_btn').on('click', function() {
		addMenuToDom({title: '', link: '', subitems: []}, Date.now());
	});

	menusContainer.on('click', '.mh-add-subitem-btn', function() {
		var container = $(this).siblings('.mh-subitems-container');
		addSubitemToDom(container, {image: '', image_hover: '', text: '', link: ''}, Date.now());
	});

	menusContainer.on('click', '.mh-menu-header', function() {
		var item = $(this).closest('.mh-menu-item');
		item.toggleClass('is-open');
		$(this).siblings('.mh-menu-body').slideToggle(300);
	});

	menusContainer.on('click', '.mh-sort-handle', function(e) {
		e.preventDefault();
		e.stopPropagation();
	});

	menusContainer.on('click', '.mh-remove-menu-btn', function(e) {
		e.stopPropagation();
		if(confirm('Remover este menu principal?')) {
			$(this).closest('.mh-menu-item').remove();
		}
	});

	menusContainer.on('click', '.mh-remove-subitem-btn', function() {
		$(this).closest('.mh-subitem').remove();
	});

	menusContainer.on('keyup', '.mh-input-title', function() {
		$(this).closest('.mh-menu-item').find('.mh-menu-title-display').text($(this).val());
	});

	// Subitem Media Upload
	menusContainer.on('click', '.mh-upload-subitem-btn', function(e) {
		e.preventDefault();
		var btn = $(this);
		mhOpenMediaUploader(btn, function(attachment) {
			var subitem = btn.closest('.mh-subitem-image');
			subitem.find('.mh-subitem-image-input').val(attachment.url);
			subitem.find('.mh-subitem-preview').attr('src', attachment.url).show();
		});
	});

	menusContainer.on('click', '.mh-upload-hover-btn', function(e) {
		e.preventDefault();
		var btn = $(this);
		mhOpenMediaUploader(btn, function(attachment) {
			var subitem = btn.closest('.mh-subitem-image');
			subitem.find('.mh-subitem-hover-input').val(attachment.url);
			subitem.find('.mh-subitem-hover-preview').attr('src', attachment.url).show();
		});
	});

	// 3. Save Data
	$('#save_settings_btn').on('click', function() {
		var btn = $(this);
		var status = $('#save_status');
		btn.prop('disabled', true);
		status.text('Salvando...').css('color', '#333');

		var dataObj = {
			logo_fixed: $('#logo_fixed').val(),
			logo_fixed_size: $('#logo_fixed_size').val(),
			logo_scroll: $('#logo_scroll').val(),
			logo_scroll_size: $('#logo_scroll_size').val(),
			bg_fixed_color: $('#bg_fixed_color').val(),
			bg_fixed_opacity: $('#bg_fixed_opacity').val(),
			bg_scroll_color: $('#bg_scroll_color').val(),
			bg_scroll_opacity: $('#bg_scroll_opacity').val(),
			header_max_width: $('#header_max_width').val(),
			menu_font_color: $('#menu_font_color').val(),
			menu_font_hover_color: $('#menu_font_hover_color').val(),
			menu_font_size: $('#menu_font_size').val(),
			header_shadow: $('#header_shadow').val(),
			subitem_image_width: $('#subitem_image_width').val(),
			subitem_image_height: $('#subitem_image_height').val(),
			overlap_content: $('#overlap_content').is(':checked') ? 'yes' : 'no',
			menus: []
		};

		$('.mh-menu-item').each(function() {
			var $menu = $(this);
			var menuObj = {
				title: $menu.find('.mh-input-title').val(),
				link: $menu.find('.mh-input-link').val(),
				subitems: []
			};

			$menu.find('.mh-subitem').each(function() {
				var $sub = $(this);
				menuObj.subitems.push({
					image: $sub.find('.mh-subitem-image-input').val(),
					image_hover: $sub.find('.mh-subitem-hover-input').val(),
					text: $sub.find('.mh-subitem-text').val(),
					link: $sub.find('.mh-subitem-link').val()
				});
			});

			dataObj.menus.push(menuObj);
		});

		$.post(megaHeaderAdminVars.ajax_url, {
			action: 'mega_header_save',
			nonce: megaHeaderAdminVars.nonce,
			data: JSON.stringify(dataObj)
		}, function(response) {
			btn.prop('disabled', false);
			if(response.success) {
				status.text('Salvo!').css('color', 'green');
			} else {
				status.text('Erro: ' + response.data).css('color', 'red');
			}
			setTimeout(function(){ status.text(''); }, 3000);
		});
	});

	// Initialize
	var initialData = JSON.parse(megaHeaderAdminVars.data || '{"menus":[]}');
	renderData(initialData);

});
