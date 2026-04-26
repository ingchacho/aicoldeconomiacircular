<?php
function aec_crear_tabla() {
    global $wpdb;

    $tabla = $wpdb->prefix . 'organizaciones';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $tabla (
        id INT AUTO_INCREMENT PRIMARY KEY,

        -- CONTROL
        usuario_id INT NULL,
        paso_actual INT DEFAULT 1,

        -- 1. PERFIL
        nombre VARCHAR(255),
        tipo_documento VARCHAR(20),
        numero_documento VARCHAR(50),
        departamento VARCHAR(100),
        municipio VARCHAR(100),
        vereda VARCHAR(100),
        telefono VARCHAR(50),
        email VARCHAR(100),
        edad INT,
        sexo VARCHAR(20),
        genero VARCHAR(50),
        escolaridad VARCHAR(100),
        enfoque VARCHAR(100),
        victima VARCHAR(10),
        campesino VARCHAR(10),
        discapacidad TEXT,
        mujer_rural VARCHAR(10),
        joven_rural VARCHAR(10),
        personas_cargo INT,

        -- 2. NEGOCIO
        nombre_emprendimiento VARCHAR(255),
        estado_iniciativa VARCHAR(100),
        tiempo_operacion VARCHAR(50),
        ubicacion_negocio VARCHAR(150),

        -- 3. TECNICO
        descripcion TEXT,
        mercado TEXT,
        bienes_servicios TEXT,
        insumos TEXT,
        usa_residuos VARCHAR(10),

        -- 4. VERDE
        problema_ambiental TEXT,
        saberes VARCHAR(10),
        genera_empleo VARCHAR(10),

        -- 5. OBS
        observaciones TEXT,

        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
