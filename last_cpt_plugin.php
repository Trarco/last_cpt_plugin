<?php
/*
Plugin Name: Last CPT Plugin
Description: Last CPT Plugin is a WordPress plugin that allows you to display the latest posts of a custom post type.
Version: 1.3.0
Author: Marco Traina
*/

// Impedisce l'accesso diretto al file
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Definisci il percorso del plugin
define('LAST_CPT_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Includi i file necessari
require_once LAST_CPT_PLUGIN_PATH . 'includes/functions.php';
require_once LAST_CPT_PLUGIN_PATH . 'includes/settings.php';
require_once LAST_CPT_PLUGIN_PATH . 'includes/widget.php';
require_once LAST_CPT_PLUGIN_PATH . 'includes/block.php';
