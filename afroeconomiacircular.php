<?php
/*
Plugin Name: Afro Economía Circular
Description: Micrositio para caracterización de organizaciones afro, indígenas, raizales y palenqueras.
Version: 1.0
Author: Yavasoft
*/

if (!defined('ABSPATH')) {
    exit; // Seguridad
}

// ===============================
// 🔧 CONSTANTES
// ===============================
define('AEC_PATH', plugin_dir_path(__FILE__));
define('AEC_URL', plugin_dir_url(__FILE__));

// ===============================
// 📦 INCLUDES
// ===============================
require_once AEC_PATH . 'includes/functions.php';
require_once AEC_PATH . 'includes/db.php';

// ===============================
// 🎨 ESTILOS Y JS
// ===============================
function aec_enqueue_assets() {
    wp_enqueue_style('aec-style', AEC_URL . 'assets/css/style.css');
    wp_enqueue_script('aec-script', AEC_URL . 'assets/js/app.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'aec_enqueue_assets');

// Chart.js
function aec_cargar_chartjs() {
    wp_enqueue_script('chartjs', 'https://cdn.jsdelivr.net/npm/chart.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'aec_cargar_chartjs');

// ===============================
// 🧠 SESIONES
// ===============================
add_action('init', function(){
    if (!session_id()) {
        session_start();
    }
});

// ===============================
// 🗄️ ACTIVACIÓN PLUGIN
// ===============================
register_activation_hook(__FILE__, 'aec_crear_tabla');
register_activation_hook(__FILE__, 'aec_crear_tabla_usuarios');

// ===============================
// 👥 TABLA USUARIOS
// ===============================
function aec_crear_tabla_usuarios(){
    global $wpdb;

    $tabla = $wpdb->prefix . 'aec_usuarios';

    $sql = "CREATE TABLE IF NOT EXISTS $tabla (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100),
        email VARCHAR(100) UNIQUE,
        password VARCHAR(255),
        rol ENUM('ADMIN','LIM') DEFAULT 'LIM',
        estado ENUM('PENDIENTE','ACTIVO') DEFAULT 'PENDIENTE',
        fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// ===============================
// 🔗 SHORTCODE KPI
// ===============================
add_shortcode('aec_kpi', function() {
    ob_start();
    include AEC_PATH . 'templates/kpi.php';
    return ob_get_clean();
});

// ===============================
// 🔐 SHORTCODE LOGIN
// ===============================
add_shortcode('aec_login', function(){

    if (!session_id()) session_start();

    global $wpdb;
    $tabla = $wpdb->prefix . 'aec_usuarios';

    // ======================
    // PROCESAR LOGIN
    // ======================
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $usuario = sanitize_text_field($_POST['usuario']);
        $password = $_POST['password'];

        $user = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $tabla WHERE email = %s", $usuario)
        );

        if ($user && $user->estado == 'ACTIVO' && password_verify($password, $user->password)) {

            $_SESSION['aec_user'] = [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'rol' => $user->rol
            ];

            echo "<script>window.location.href='".site_url('/dashboard')."';</script>";
            return;

        } else {
            echo "<p style='color:red;'>❌ Usuario, contraseña o estado inválido</p>";
        }
    }

    // ======================
    // FORMULARIO
    // ======================
    ob_start();
    ?>

    <div class="aec-container">
        <h2>Iniciar Sesión</h2>

        <form method="POST" class="aec-form">

            <label>Email</label>
            <input type="text" name="usuario" required>

            <label>Contraseña</label>
            <input type="password" name="password" required>

            <button type="submit">Ingresar</button>

        </form>
    </div>

    <?php
    return ob_get_clean();
});

// ===============================
// 🔁 ENRUTADOR DE PÁGINAS
// ===============================
add_filter('template_include', function($template){

    // LOGIN
    if (is_page('login')) {
        return AEC_PATH . 'templates/page-login.php';
    }

    // DASHBOARD
    if (is_page('dashboard')) {
        return AEC_PATH . 'templates/page-dashboard.php';
    }

    // KPI
    if (is_page('kpi')) {
        return AEC_PATH . 'templates/page-kpi.php';
    }

    return $template;
});


// LOGOUT
add_action('wp_ajax_aec_logout', 'aec_logout');
add_action('wp_ajax_nopriv_aec_logout', 'aec_logout');

function aec_logout() {
    if (!session_id()) session_start();
    session_destroy();
    wp_redirect(home_url('/login'));
    exit;
}


add_action('wp_ajax_aec_guardar_ajax', 'aec_guardar_ajax');
add_action('wp_ajax_nopriv_aec_guardar_ajax', 'aec_guardar_ajax');

function aec_guardar_ajax() {

    if (!session_id()) session_start();

    if (!isset($_SESSION['aec_user'])) {
        wp_send_json_error('No autorizado');
    }

    global $wpdb;
    $tabla = $wpdb->prefix . 'organizaciones';

    $user = $_SESSION['aec_user'];
    $step = intval($_POST['step']);

    // =========================
    // CREAR REGISTRO SI NO EXISTE
    // =========================
    if (!isset($_SESSION['aec_id'])) {

        $insert = $wpdb->insert($tabla, [
            'paso_actual' => 1,
            'creado_por' => $user['id']
        ]);

        if ($insert === false) {
            wp_send_json_error($wpdb->last_error);
        }

        $_SESSION['aec_id'] = $wpdb->insert_id;
    }

    $id = $_SESSION['aec_id'];

    // =========================
    // DATOS SEGÚN PASO
    // =========================
    $data = [];

    if ($step == 1) {
        $data = [
            'nombre' => sanitize_text_field($_POST['nombre']),
            'tipo_documento' => sanitize_text_field($_POST['tipo_documento']),
            'numero_documento' => sanitize_text_field($_POST['numero_documento']),
            'departamento' => sanitize_text_field($_POST['departamento']),
            'municipio' => sanitize_text_field($_POST['municipio']),
            'vereda' => sanitize_text_field($_POST['vereda']),
            'telefono' => sanitize_text_field($_POST['telefono']),
            'email' => sanitize_email($_POST['email']),
            'edad' => intval($_POST['edad']),
            'sexo' => sanitize_text_field($_POST['sexo']),
            'genero' => sanitize_text_field($_POST['genero']),
            'escolaridad' => sanitize_text_field($_POST['escolaridad']),
            'enfoque' => sanitize_text_field($_POST['enfoque']),
            'victima' => sanitize_text_field($_POST['victima']),
            'campesino' => sanitize_text_field($_POST['campesino']),
            'discapacidad' => sanitize_textarea_field($_POST['discapacidad']),
            'mujer_rural' => sanitize_text_field($_POST['mujer_rural']),
            'joven_rural' => sanitize_text_field($_POST['joven_rural']),
            'personas_cargo' => intval($_POST['personas_cargo']),
            'paso_actual' => 2
        ];
    }

    if ($step == 2) {
        $data = [
            'nombre_emprendimiento' => sanitize_text_field($_POST['nombre_emprendimiento']),
            'estado_iniciativa' => sanitize_text_field($_POST['estado_iniciativa']),
            'tiempo_operacion' => sanitize_text_field($_POST['tiempo_operacion']),
            'ubicacion_negocio' => sanitize_text_field($_POST['ubicacion_negocio']),
            'paso_actual' => 3
        ];
    }

    if ($step == 3) {
        $data = [
            'descripcion' => sanitize_textarea_field($_POST['descripcion']),
            'mercado' => sanitize_textarea_field($_POST['mercado']),
            'bienes_servicios' => sanitize_textarea_field($_POST['bienes_servicios']),
            'insumos' => sanitize_textarea_field($_POST['insumos']),
            'usa_residuos' => sanitize_text_field($_POST['usa_residuos']),
            'paso_actual' => 4
        ];
    }

    if ($step == 4) {
        $data = [
            'problema_ambiental' => sanitize_textarea_field($_POST['problema_ambiental']),
            'saberes' => sanitize_text_field($_POST['saberes']),
            'genera_empleo' => sanitize_text_field($_POST['genera_empleo']),
            'paso_actual' => 5
        ];
    }

    if ($step == 5) {
        $data = [
            'observaciones' => sanitize_textarea_field($_POST['observaciones']),
            'paso_actual' => 5
        ];
    }

    // =========================
    // GUARDAR
    // =========================
    $update = $wpdb->update($tabla, $data, ['id' => $id]);

    if ($update === false) {
        wp_send_json_error($wpdb->last_error);
    }

    wp_send_json_success([
        'step' => $step,
        'id' => $id
    ]);
}