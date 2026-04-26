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

