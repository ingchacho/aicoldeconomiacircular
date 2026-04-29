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



add_shortcode('aec_kpi', function() {
    ob_start();
    include AEC_PATH . 'templates/kpi.php';
    return ob_get_clean();
});

function aec_cargar_chartjs() {
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'aec_cargar_chartjs');


add_filter('template_include', function($template){

    // 🔥 RUTAS DEL SISTEMA
    if (is_page('kpi')) {
        return AEC_PATH . 'templates/page-kpi.php';
    }

    if (is_page('dashboard')) {
        return AEC_PATH . 'templates/page-dashboard.php';
    }

    if (is_page('login')) {
        return AEC_PATH . 'templates/page-login.php';
    }

    return $template;
});


// function aec_kpi_page_assets() {

//     if (is_page('kpi')) {
//         wp_dequeue_style('wp-block-library');
//         wp_dequeue_style('global-styles');
//         wp_dequeue_style('astra-theme-css');
//         wp_dequeue_style('hello-elementor');
//         wp_enqueue_style('aec-style', AEC_URL . 'assets/css/style.css');
//     }

// }
// add_action('wp_enqueue_scripts', 'aec_kpi_page_assets', 100);