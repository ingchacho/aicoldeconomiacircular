<?php

function aec_saludo() {
    return "Micrositio Afro Economía Circular activo";
}


function aec_mostrar_micrositio() {
    ob_start();
    include AEC_PATH . 'templates/dashboard.php';
    return ob_get_clean();
}

add_shortcode('afro_micrositio', 'aec_mostrar_micrositio');


function aec_formulario_registro() {
    ob_start();
    include AEC_PATH . 'templates/registro.php';
    return ob_get_clean();
}

add_shortcode('afro_registro', 'aec_formulario_registro');

// Obtiene ID de registro guardado en sesión
function aec_get_registro_id() {
    if (!session_id()) {
        session_start();
    }

    if (!isset($_SESSION['aec_id'])) {
        return null;
    }

    return $_SESSION['aec_id'];
}

function aec_dashboard() {
    ob_start();
    include AEC_PATH . 'templates/dashboard.php';
    return ob_get_clean();
}

add_shortcode('afro_dashboard', 'aec_dashboard');

function aec_landing_page_shortcode() {
    ob_start();

    include AEC_PATH . 'templates/landing.php';

    return ob_get_clean();
}

add_shortcode('aec_landing', 'aec_landing_page_shortcode');



add_action('wp_ajax_aec_filtrar_kpi', 'aec_filtrar_kpi');
add_action('wp_ajax_nopriv_aec_filtrar_kpi', 'aec_filtrar_kpi');

function aec_filtrar_kpi(){

    global $wpdb;
    $tabla = $wpdb->prefix . 'organizaciones';

    $where = "WHERE 1=1";
    $params = [];

    if (!empty($_POST['municipio'])) {
        $where .= " AND municipio = %s";
        $params[] = $_POST['municipio'];
    }

    if (!empty($_POST['enfoque'])) {
        $where .= " AND enfoque = %s";
        $params[] = $_POST['enfoque'];
    }

    if (!empty($_POST['estado'])) {
        $where .= " AND estado_iniciativa = %s";
        $params[] = $_POST['estado'];
    }

    // TOTAL
    $total = $wpdb->get_var(
        $wpdb->prepare("SELECT COUNT(*) FROM $tabla $where", $params)
    );

    // MUNICIPIO
    $municipios = $wpdb->get_results(
        $wpdb->prepare("
            SELECT municipio, COUNT(*) as total 
            FROM $tabla 
            $where
            GROUP BY municipio
        ", $params)
    );

    // COMUNIDAD
    $comunidad = $wpdb->get_results(
        $wpdb->prepare("
            SELECT enfoque, COUNT(*) as total 
            FROM $tabla 
            $where
            GROUP BY enfoque
        ", $params)
    );

    // ESTADO
    $estado = $wpdb->get_results(
        $wpdb->prepare("
            SELECT estado_iniciativa, COUNT(*) as total 
            FROM $tabla 
            $where
            GROUP BY estado_iniciativa
        ", $params)
    );

    wp_send_json([
        'total' => $total,
        'municipios' => $municipios,
        'comunidad' => $comunidad,
        'estado' => $estado
    ]);
}




add_action('wp_ajax_aec_exportar_excel', 'aec_exportar_excel');
add_action('wp_ajax_nopriv_aec_exportar_excel', 'aec_exportar_excel');

function aec_exportar_excel(){

    global $wpdb;
    $tabla = $wpdb->prefix . 'organizaciones';

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=reporte.xls");

    $datos = $wpdb->get_results("SELECT * FROM $tabla");

    echo "Nombre\tMunicipio\tEnfoque\n";

    foreach($datos as $d){
        echo "{$d->nombre}\t{$d->municipio}\t{$d->enfoque}\n";
    }

    exit;
}