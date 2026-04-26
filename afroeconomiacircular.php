<?php
/*
Plugin Name: Afro Economía Circular
Description: Micrositio para caracterización de organizaciones afro, indígenas, raizales y palenqueras.
Version: 1.0
Author: Yavasoft
*/

if (!defined('ABSPATH')) {
    exit; // Segurida
}

// Definir constantes
define('AEC_PATH', plugin_dir_path(__FILE__));
define('AEC_URL', plugin_dir_url(__FILE__));

// Incluir archivos necesarios
require_once AEC_PATH . 'includes/functions.php';
require_once AEC_PATH . 'includes/db.php';

// Cargar estilos y scripts
function aec_enqueue_assets() {
    wp_enqueue_style('aec-style', AEC_URL . 'assets/css/style.css');
    wp_enqueue_script('aec-script', AEC_URL . 'assets/js/app.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'aec_enqueue_assets');

// Hook al activar plugin
register_activation_hook(__FILE__, 'aec_crear_tabla');
