<?php
/**
 * @package image-to-postlist
 * @version 1.6
 */
/*
Plugin Name: image to postlist
Plugin URI: http://plugins.funsite.eu/image-to-postlist/
Description: This plugin adds the featured image icon to the posts- and pageslists.
Author: Gerhard Hoogterp
Version: 1.6
Author URI: http://plugins.funsite.eu/image-to-postlist/
Text Domain: image-to-postlist
Domain Path: /languages
*/
if ( ! defined( 'ABSPATH' ) ) exit;

if (!class_exists('basic_plugin_class')):
	require(plugin_dir_path(__FILE__).'basics/basic_plugin.class');
endif;

include_once('image-to-postlist-plugin.php');
$image_to_postlist = new image_to_postlist_class();
$image_to_postlist->currentPlugin = __FILE__; // bit of a hack to find the plugin info in getPlugins
?>