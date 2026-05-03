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