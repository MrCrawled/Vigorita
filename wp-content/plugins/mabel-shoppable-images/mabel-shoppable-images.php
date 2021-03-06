<?php
/*
 * Plugin Name: Shoppable Images
 * Plugin URI: https://studiowombat.com/plugin/shoppable-images/
 * Description: Easily add shoppable images to your website or Woocommerce store.
 * Version: 1.3.0
 * Author: StudioWombat
 * Author URI: https://studiowombat.com/
 * Text Domain: mabel-shoppable-images
 * WC requires at least: 3.2.0
 * WC tested up to: 4.6
*/

if(!defined('ABSPATH')){die;}

/**
 * Auto loader for Plugin classes
 *
 * @param string $class_name Name of the class that shall be loaded
 */
function MABEL_SI_auto_loader ($class_name) {
	// Not loading a class from our plugin.
	if ( !is_int(strpos( $class_name, 'MABEL_SI')) )
		return;
	// Remove root namespace as we don't have that as a folder.
	$class_name = str_replace('MABEL_SI\\','',$class_name);
	$class_name = str_replace('\\','/',strtolower($class_name)) .'.php';
	// Get only the file name.
	$pos =  strrpos($class_name, '/');
	$file_name = is_int($pos) ? substr($class_name, $pos + 1) : $class_name;
	// Get only the path.
	$path = str_replace($file_name,'',$class_name);
	// Append 'class-' to the file name and replace _ with -
	$new_file_name = 'class-'.str_replace('_','-',$file_name);
	// Construct file path.
	$file_path = plugin_dir_path(__FILE__)  . str_replace('\\', DIRECTORY_SEPARATOR, $path . strtolower($new_file_name));

	if (file_exists($file_path))
		require_once($file_path);
}

spl_autoload_register('MABEL_SI_auto_loader');

function run_MABEL_SI()
{
	$plugin = new \MABEL_SI\Shoppable_Images(
		plugin_dir_path( __FILE__ ),
		plugin_dir_url( __FILE__ ),
		plugin_basename( __FILE__ ),
		'Shoppable Images',
		'1.3.0',
		'mb-si-settings'
	);
	$plugin->run();
}

run_MABEL_SI();