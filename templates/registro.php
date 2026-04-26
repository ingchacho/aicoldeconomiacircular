

<?php
if (isset($_GET['edit'])) {
    $aec_id = intval($_GET['edit']);
    $_SESSION['aec_id'] = $aec_id;
}

if (!session_id()) session_start();

global $wpdb;
$tabla = $wpdb->prefix . 'organizaciones';

// Obtener ID de sesión
$aec_id = $_SESSION['aec_id'] ?? null;

// Paso actual
$paso = isset($_GET['paso']) ? intval($_GET['paso']) : 1;

// =====================
// GUARDAR INFORMACIÓN
// =====================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = $_POST;

    // Crear registro si no existe
    if (!$aec_id) {
        $wpdb->insert($tabla, ['paso_actual' => $paso]);
        $aec_id = $wpdb->insert_id;
        $_SESSION['aec_id'] = $aec_id;
    }

    // =====================
    // PASO 1
    // =====================
    if ($paso == 1) {

        $wpdb->update($tabla, [

            'nombre' => sanitize_text_field($data['nombre']),
            'tipo_documento' => sanitize_text_field($data['tipo_documento']),
            'numero_documento' => sanitize_text_field($data['numero_documento']),
            'departamento' => sanitize_text_field($data['departamento']),
            'municipio' => sanitize_text_field($data['municipio']),
            'vereda' => sanitize_text_field($data['vereda']),
            'telefono' => sanitize_text_field($data['telefono']),
            'email' => sanitize_email($data['email']),
            'edad' => intval($data['edad']),
            'sexo' => sanitize_text_field($data['sexo']),
            'genero' => sanitize_text_field($data['genero']),
            'escolaridad' => sanitize_text_field($data['escolaridad']),
            'enfoque' => sanitize_text_field($data['enfoque']),
            'victima' => sanitize_text_field($data['victima']),
            'campesino' => sanitize_text_field($data['campesino']),
            'discapacidad' => sanitize_textarea_field($data['discapacidad']),
            'mujer_rural' => sanitize_text_field($data['mujer_rural']),
            'joven_rural' => sanitize_text_field($data['joven_rural']),
            'personas_cargo' => intval($data['personas_cargo']),
            'paso_actual' => 2

        ], ['id' => $aec_id]);
    }

    // =====================
    // PASO 2
    // =====================
    if ($paso == 2) {

        $wpdb->update($tabla, [

            'nombre_emprendimiento' => sanitize_text_field($data['nombre_emprendimiento']),
            'estado_iniciativa' => sanitize_text_field($data['estado_iniciativa']),
            'tiempo_operacion' => sanitize_text_field($data['tiempo_operacion']),
            'ubicacion_negocio' => sanitize_text_field($data['ubicacion_negocio']),
            'paso_actual' => 3

        ], ['id' => $aec_id]);
    }

    // =====================
    // PASO 3
    // =====================
    if ($paso == 3) {

        $wpdb->update($tabla, [

            'descripcion' => sanitize_textarea_field($data['descripcion']),
            'mercado' => sanitize_textarea_field($data['mercado']),
            'bienes_servicios' => sanitize_textarea_field($data['bienes_servicios']),
            'insumos' => sanitize_textarea_field($data['insumos']),
            'usa_residuos' => sanitize_text_field($data['usa_residuos']),
            'paso_actual' => 4

        ], ['id' => $aec_id]);
    }

    // =====================
    // PASO 4
    // =====================
    if ($paso == 4) {

        $wpdb->update($tabla, [

            'problema_ambiental' => sanitize_textarea_field($data['problema_ambiental']),
            'saberes' => sanitize_text_field($data['saberes']),
            'genera_empleo' => sanitize_text_field($data['genera_empleo']),
            'paso_actual' => 5

        ], ['id' => $aec_id]);
    }

    // =====================
    // PASO 5
    // =====================
    if ($paso == 5) {

        $wpdb->update($tabla, [
            'observaciones' => sanitize_textarea_field($data['observaciones']),
            'paso_actual' => 5
        ], ['id' => $aec_id]);

        // 🔥 LIMPIAR SESIÓN (CLAVE)
        unset($_SESSION['aec_id']);

        // Opcional: destruir sesión completa
        session_destroy();

        echo "<p style='color:green;'>Registro finalizado correctamente</p>";

        return; // detener flujo
    }

    // Redirección al siguiente paso
    wp_redirect('?page_id=' . get_the_ID() . '&paso=' . ($paso + 1));
    exit;
}
?>

<div class="aec-container">


    <?php
    $porcentaje = ($paso / 5) * 100;
    ?>

    <div class="aec-progress">
        <div class="aec-bar" style="width: <?= $porcentaje ?>%"></div>
    </div>

    <p>Paso <?= $paso ?> de 5</p>

<!-- ===================== -->
<!-- PASO 1 -->
<!-- ===================== -->
<?php if ($paso == 1): ?>
<form method="POST">

<h3>1. Perfil del Postulante</h3>

<input type="text" name="nombre" placeholder="Nombre completo" required>
<select name="tipo_documento">
    <option value="">Tipo documento</option>
    <option value="CC">C.C</option>
    <option value="TI">T.I</option>
</select>

<input type="text" name="numero_documento" placeholder="Número documento">
<input type="text" name="departamento" placeholder="Departamento">
<input type="text" name="municipio" placeholder="Municipio">
<input type="text" name="vereda" placeholder="Vereda">

<input type="text" name="telefono" placeholder="Teléfono">
<input type="email" name="email" placeholder="Email">

<input type="number" name="edad" placeholder="Edad">

<select name="sexo">
    <option>Sexo</option>
    <option>Masculino</option>
    <option>Femenino</option>
</select>

<input type="text" name="genero" placeholder="Identidad de género">

<select name="escolaridad">
    <option>Escolaridad</option>
    <option>Primaria</option>
    <option>Secundaria</option>
</select>

<select name="enfoque">
    <option>Enfoque</option>
    <option>Afrocolombiano</option>
    <option>Palenquero</option>
</select>

<select name="victima">
    <option>¿Víctima?</option>
    <option>SI</option>
    <option>NO</option>
</select>

<select name="campesino">
    <option>¿Campesino?</option>
    <option>SI</option>
    <option>NO</option>
</select>

<textarea name="discapacidad" placeholder="Discapacidad"></textarea>

<select name="mujer_rural">
    <option>¿Mujer rural?</option>
    <option>SI</option>
    <option>NO</option>
</select>

<select name="joven_rural">
    <option>¿Joven rural?</option>
    <option>SI</option>
    <option>NO</option>
</select>

<input type="number" name="personas_cargo" placeholder="Personas a cargo">

<button type="submit">Guardar y continuar</button>
</form>
<?php endif; ?>


<!-- ===================== -->
<!-- PASO 2 -->
<!-- ===================== -->
<?php if ($paso == 2): ?>
<form method="POST">

<h3>2. Datos del Negocio</h3>

<input type="text" name="nombre_emprendimiento" placeholder="Nombre emprendimiento">
<input type="text" name="estado_iniciativa" placeholder="Estado">
<input type="text" name="tiempo_operacion" placeholder="Tiempo operación">
<input type="text" name="ubicacion_negocio" placeholder="Ubicación">

<button type="submit">Guardar y continuar</button>
</form>
<?php endif; ?>


<!-- ===================== -->
<!-- PASO 3 -->
<!-- ===================== -->
<?php if ($paso == 3): ?>
<form method="POST">

<h3>3. Componente Técnico</h3>

<textarea name="descripcion" placeholder="Descripción"></textarea>
<textarea name="mercado" placeholder="Mercado"></textarea>
<textarea name="bienes_servicios" placeholder="Bienes o servicios"></textarea>
<textarea name="insumos" placeholder="Insumos"></textarea>

<select name="usa_residuos">
    <option>¿Usa residuos?</option>
    <option>SI</option>
    <option>NO</option>
</select>

<button type="submit">Guardar y continuar</button>
</form>
<?php endif; ?>


<!-- ===================== -->
<!-- PASO 4 -->
<!-- ===================== -->
<?php if ($paso == 4): ?>
<form method="POST">

<h3>4. Potencial Verde</h3>

<textarea name="problema_ambiental" placeholder="Problema ambiental"></textarea>

<select name="saberes">
    <option>¿Saberes ancestrales?</option>
    <option>SI</option>
    <option>NO</option>
</select>

<select name="genera_empleo">
    <option>¿Genera empleo?</option>
    <option>SI</option>
    <option>NO</option>
</select>

<button type="submit">Guardar y continuar</button>
</form>
<?php endif; ?>


<!-- ===================== -->
<!-- PASO 5 -->
<!-- ===================== -->
<?php if ($paso == 5): ?>
<form method="POST">

<h3>5. Observaciones</h3>

<textarea name="observaciones" placeholder="Información adicional"></textarea>

<button type="submit">Finalizar</button>
</form>
<?php endif; ?>

</div>