<?php
/*
Author: Luis del Cid
Author URI: https://luisdelcid.com
Description: A collection of useful functions for your WordPress theme's functions.php.
Domain Path:
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Network:
Plugin Name: LDC Custom Code
Plugin URI: https://github.com/luisdelcid/ldc-custom-code
Text Domain: ldc-custom-code
Version: 2020.9.5
*/

defined('ABSPATH') or die("Hi there! I'm just a plugin, not much I can do when called directly.");
define('LDC_Custom_Code', __FILE__);
require_once(plugin_dir_path(LDC_Custom_Code) . 'class-ldc-custom-code.php');
require_once(plugin_dir_path(LDC_Custom_Code) . 'plugin-update-checker-4.9/plugin-update-checker.php');
Puc_v4_Factory::buildUpdateChecker('https://github.com/luisdelcid/ldc-custom-code', LDC_Custom_Code, 'ldc-custom-code');
add_action('admin_enqueue_scripts', ['LDC_Custom_Code', 'admin_enqueue_scripts']);
add_action('admin_notices', ['LDC_Custom_Code', 'admin_notices']);
add_action('admin_print_footer_scripts', ['LDC_Custom_Code', 'admin_print_footer_scripts']);
add_action('init', ['LDC_Custom_Code', 'init']);
add_action('rwmb_meta_boxes', ['LDC_Custom_Code', 'rwmb_meta_boxes']);
// 999 should be enough for themes
add_action('wp_enqueue_scripts', ['LDC_Custom_Code', 'wp_enqueue_scripts'], 1000);
add_action('wp_head', ['LDC_Custom_Code', 'wp_head'], 1000);
add_action('wp_print_footer_scripts', ['LDC_Custom_Code', 'wp_print_footer_scripts'], 1000);
