<?php

function aec_crear_tabla() {
    global $wpdb;

    $tabla = $wpdb->prefix . 'organizaciones';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $tabla (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(255),
        territorio VARCHAR(150),
        comunidad VARCHAR(100),
        actividad TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
