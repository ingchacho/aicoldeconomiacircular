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