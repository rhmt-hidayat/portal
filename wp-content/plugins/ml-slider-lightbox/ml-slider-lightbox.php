<?php
/*
 * Plugin Name:	MetaSlider Lightbox
 * Plugin URI:	https://www.metaslider.com
 * Description: Adds lightbox plugin integration to MetaSlider. Requires MetaSlider and one compatible lightbox plugin to be installed and activated.
 * Version:		1.12.1
 * Author:	  	MetaSlider
 * Author URI:	https://www.metaslider.com
 * License:	 	GPL-2.0+
 * Copyright:	2020+ MetaSlider
 *
 * Text Domain: ml-slider-lightbox
 * Domain Path: /languages
 */
if (!defined('ABSPATH')) {
    die('No direct access.');
}

if (!class_exists('MetaSliderLightboxPlugin')) {
    require_once plugin_dir_path(__FILE__) . 'class-ml-slider-lightbox.php';
    add_action('after_setup_theme', array(MetaSliderLightboxPlugin::get_instance(), 'setup'), 10);
}

if (is_readable(dirname(__FILE__) . '/extendify-sdk/loader.php')) {
    require plugin_dir_path(__FILE__) . 'extendify-sdk/loader.php';
}
