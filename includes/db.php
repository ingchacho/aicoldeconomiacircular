<?php

function aec_crear_tabla() {
    global $wpdb;

    $tabla = $wpdb->prefix . 'organizaciones';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $tabla (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(255),
        territorio VARCHAR(100),
        comunidad VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

register_activation_hook(__FILE__, 'aec_crear_tabla');