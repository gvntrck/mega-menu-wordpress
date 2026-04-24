<?php
/**
 * Plugin Name: Mega Header
 * Plugin URI:  https://projetoalfa.org
 * Description: Plugin para criar um cabeçalho fixo com Mega Menu e Carrossel (via Shortcode [mega_header]).
 * Version:     1.0.16
 * Author:      Giovani Tureck
 * Author URI:  https://projetoalfa.org
 * Text Domain: mega-header
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

// Define plugin constants
define('MEGA_HEADER_VERSION', '1.0.16');
define('MEGA_HEADER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MEGA_HEADER_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main Initialization Class
 */
class Mega_Header_Plugin
{

	private static $instance = null;

	public static function get_instance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct()
	{
		$this->load_dependencies();
		$this->init_hooks();
	}

	private function load_dependencies()
	{
		require_once MEGA_HEADER_PLUGIN_DIR . 'includes/class-mega-header-admin.php';
		require_once MEGA_HEADER_PLUGIN_DIR . 'includes/class-mega-header-frontend.php';
	}

	private function init_hooks()
	{
		// Initialize Admin
		if (is_admin()) {
			$admin = new Mega_Header_Admin();
			$admin->init();
		}

		// Initialize Frontend
		$frontend = new Mega_Header_Frontend();
		$frontend->init();
	}
}

// Run the plugin
add_action('plugins_loaded', array('Mega_Header_Plugin', 'get_instance'));
