<?php
if (!session_id()) session_start();

$user = $_SESSION['aec_user'] ?? null;

if (!$user) {
    echo "<p style='color:red;'>No autorizado</p>";
    return;
}

global $wpdb;
$tabla = $wpdb->prefix . 'organizaciones';

// =====================
// RESET
// =====================
if (isset($_GET['reset'])) {
    unset($_SESSION['aec_id']);
}

// =====================
// EDITAR
// =====================
if (isset($_GET['edit'])) {
    $_SESSION['aec_id'] = intval($_GET['edit']);
}

$aec_id = $_SESSION['aec_id'] ?? null;
$paso = isset($_GET['paso']) ? intval($_GET['paso']) : 1;

// =====================
// CARGAR REGISTRO
// =====================
$registro = null;

if ($aec_id) {
    $registro = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $tabla WHERE id = %d", $aec_id)
    );

    // 🔒 Seguridad
    if ($registro && $user['rol'] == 'LIM' && $registro->creado_por != $user['id']) {
        echo "<p style='color:red;'>No tienes permiso</p>";
        return;
    }

    if ($registro && !isset($_GET['paso'])) {
        $paso = $registro->paso_actual;
    }
}

// =====================
// FUNCIÓN GUARDAR
// =====================
function aec_guardar($tabla, $data, $id) {
    global $wpdb;

    $update = $wpdb->update($tabla, $data, ['id' => $id]);

    if ($update === false) {
        echo "<p style='color:red;'>❌ Error SQL: {$wpdb->last_error}</p>";
        return false;
    }

    return true; // incluso si es 0
}

// =====================
// GUARDAR
// =====================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = $_POST;

    // =====================
    // CREAR REGISTRO
    // =====================
    if (!$aec_id) {

        $insert = $wpdb->insert($tabla, [
            'paso_actual' => $paso,
            'creado_por' => $user['id']
        ]);

        if ($insert === false) {
            echo "<p style='color:red;'>❌ Error INSERT: {$wpdb->last_error}</p>";
            return;
        }

        $aec_id = $wpdb->insert_id;
        $_SESSION['aec_id'] = $aec_id;
    }

    // =====================
    // PASO 1
    // =====================
    if ($paso == 1) {

        $ok = aec_guardar($tabla, [
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
        ], $aec_id);

        if (!$ok) return;

        wp_redirect('?page_id=' . get_the_ID() . '&edit=' . $aec_id . '&paso=2');
        exit;
    }

    // =====================
    // PASO 2
    // =====================
    if ($paso == 2) {

        $ok = aec_guardar($tabla, [
            'nombre_emprendimiento' => sanitize_text_field($data['nombre_emprendimiento']),
            'estado_iniciativa' => sanitize_text_field($data['estado_iniciativa']),
            'tiempo_operacion' => sanitize_text_field($data['tiempo_operacion']),
            'ubicacion_negocio' => sanitize_text_field($data['ubicacion_negocio']),
            'paso_actual' => 3
        ], $aec_id);

        if (!$ok) return;

        wp_redirect('?page_id=' . get_the_ID() . '&edit=' . $aec_id . '&paso=3');
        exit;
    }

    // =====================
    // PASO 3
    // =====================
    if ($paso == 3) {

        $ok = aec_guardar($tabla, [
            'descripcion' => sanitize_textarea_field($data['descripcion']),
            'mercado' => sanitize_textarea_field($data['mercado']),
            'bienes_servicios' => sanitize_textarea_field($data['bienes_servicios']),
            'insumos' => sanitize_textarea_field($data['insumos']),
            'usa_residuos' => sanitize_text_field($data['usa_residuos']),
            'paso_actual' => 4
        ], $aec_id);

        if (!$ok) return;

        wp_redirect('?page_id=' . get_the_ID() . '&edit=' . $aec_id . '&paso=4');
        exit;
    }

    // =====================
    // PASO 4
    // =====================
    if ($paso == 4) {

        $ok = aec_guardar($tabla, [
            'problema_ambiental' => sanitize_textarea_field($data['problema_ambiental']),
            'saberes' => sanitize_text_field($data['saberes']),
            'genera_empleo' => sanitize_text_field($data['genera_empleo']),
            'paso_actual' => 5
        ], $aec_id);

        if (!$ok) return;

        wp_redirect('?page_id=' . get_the_ID() . '&edit=' . $aec_id . '&paso=5');
        exit;
    }

    // =====================
    // PASO 5
    // =====================
    if ($paso == 5) {

        $ok = aec_guardar($tabla, [
            'observaciones' => sanitize_textarea_field($data['observaciones']),
            'paso_actual' => 5
        ], $aec_id);

        if (!$ok) return;

        unset($_SESSION['aec_id']);

        echo "<h3 style='color:green;'>✅ Registro finalizado correctamente</h3>";
        return;
    }
}

$porcentaje = ($paso / 5) * 100;
?>

<div class="aec-container">

    <h3>Paso <?= $paso ?> de 5</h3>

    <div style="background:#eee;height:10px;">
        <div style="width:<?= $porcentaje ?>%;background:green;height:10px;"></div>
    </div>

    <!-- ===================== PASO 1 ===================== -->
    <?php if ($paso == 1): ?>
        <form method="POST">

            <input name="nombre" placeholder="Nombre completo" value="<?= $registro->nombre ?? '' ?>" required>
            <input name="tipo_documento" placeholder="Tipo documento" value="<?= $registro->tipo_documento ?? '' ?>">
            <input name="numero_documento" placeholder="Documento" value="<?= $registro->numero_documento ?? '' ?>">

            <input name="departamento" placeholder="Departamento" value="<?= $registro->departamento ?? '' ?>">
            <input name="municipio" placeholder="Municipio" value="<?= $registro->municipio ?? '' ?>">
            <input name="vereda" placeholder="Vereda" value="<?= $registro->vereda ?? '' ?>">

            <input name="telefono" placeholder="Teléfono" value="<?= $registro->telefono ?? '' ?>">
            <input name="email" placeholder="Email" value="<?= $registro->email ?? '' ?>">

            <input type="number" name="edad" placeholder="Edad" value="<?= $registro->edad ?? '' ?>">

            <input name="sexo" placeholder="Sexo" value="<?= $registro->sexo ?? '' ?>">
            <input name="genero" placeholder="Género" value="<?= $registro->genero ?? '' ?>">

            <input name="escolaridad" placeholder="Escolaridad" value="<?= $registro->escolaridad ?? '' ?>">
            <input name="enfoque" placeholder="Enfoque" value="<?= $registro->enfoque ?? '' ?>">

            <input name="victima" placeholder="Víctima" value="<?= $registro->victima ?? '' ?>">
            <input name="campesino" placeholder="Campesino" value="<?= $registro->campesino ?? '' ?>">

            <textarea name="discapacidad"><?= $registro->discapacidad ?? '' ?></textarea>

            <input name="mujer_rural" placeholder="Mujer rural" value="<?= $registro->mujer_rural ?? '' ?>">
            <input name="joven_rural" placeholder="Joven rural" value="<?= $registro->joven_rural ?? '' ?>">

            <input name="personas_cargo" placeholder="Personas a cargo" value="<?= $registro->personas_cargo ?? '' ?>">

            <button type="submit">Guardar y continuar</button>

        </form>
    <?php endif; ?>


    <!-- ===================== PASO 2 ===================== -->
    <?php if ($paso == 2): ?>
        <form method="POST">

            <h3>2. Datos del Negocio</h3>

            <label>Nombre del emprendimiento</label>
            <input name="nombre_emprendimiento" 
            value="<?= $registro->nombre_emprendimiento ?? '' ?>" 
            placeholder="Ej: Eco Café Rural">

            <label>Estado de la iniciativa</label>
            <select name="estado_iniciativa">
                <option value="">Seleccione</option>
                <option value="Idea" <?= ($registro->estado_iniciativa ?? '') == 'Idea' ? 'selected' : '' ?>>Idea</option>
                <option value="En desarrollo" <?= ($registro->estado_iniciativa ?? '') == 'En desarrollo' ? 'selected' : '' ?>>En desarrollo</option>
                <option value="En operación" <?= ($registro->estado_iniciativa ?? '') == 'En operación' ? 'selected' : '' ?>>En operación</option>
            </select>

            <label>Tiempo de operación</label>
            <input name="tiempo_operacion" 
            value="<?= $registro->tiempo_operacion ?? '' ?>" 
            placeholder="Ej: 6 meses, 2 años">

            <label>Ubicación del negocio</label>
            <input name="ubicacion_negocio" 
            value="<?= $registro->ubicacion_negocio ?? '' ?>" 
            placeholder="Vereda / Municipio">

            <button type="submit">Guardar y continuar</button>

        </form>
    <?php endif; ?>

        <!-- ===================== PASO 3 ===================== -->
    <?php if ($paso == 3): ?>
        <form method="POST">
            <h3>3. Componente Técnico</h3>

            <label>Descripción del negocio</label>
            <textarea name="descripcion"><?= $registro->descripcion ?? '' ?></textarea>

            <label>Mercado objetivo</label>
            <textarea name="mercado"><?= $registro->mercado ?? '' ?></textarea>

            <label>Bienes o servicios</label>
            <textarea name="bienes_servicios"><?= $registro->bienes_servicios ?? '' ?></textarea>

            <label>Insumos utilizados</label>
            <textarea name="insumos"><?= $registro->insumos ?? '' ?></textarea>

            <label>¿Usa residuos?</label>
            <select name="usa_residuos">
                <option value="">Seleccione</option>
                <option value="SI" <?= ($registro->usa_residuos ?? '') == 'SI' ? 'selected' : '' ?>>SI</option>
                <option value="NO" <?= ($registro->usa_residuos ?? '') == 'NO' ? 'selected' : '' ?>>NO</option>
            </select>

            <button type="submit">Guardar y continuar</button>
        </form>
    <?php endif; ?>

    <!-- ===================== PASO 4 ===================== -->
    <?php if ($paso == 4): ?>
        <form method="POST">
            <h3>4. Potencial Verde</h3>

            <label>Problema ambiental que resuelve</label>
            <textarea name="problema_ambiental"><?= $registro->problema_ambiental ?? '' ?></textarea>

            <label>¿Incluye saberes ancestrales?</label>
            <select name="saberes">
                <option value="">Seleccione</option>
                <option value="SI" <?= ($registro->saberes ?? '') == 'SI' ? 'selected' : '' ?>>SI</option>
                <option value="NO" <?= ($registro->saberes ?? '') == 'NO' ? 'selected' : '' ?>>NO</option>
            </select>

            <label>¿Genera empleo?</label>
            <select name="genera_empleo">
                <option value="">Seleccione</option>
                <option value="SI" <?= ($registro->genera_empleo ?? '') == 'SI' ? 'selected' : '' ?>>SI</option>
                <option value="NO" <?= ($registro->genera_empleo ?? '') == 'NO' ? 'selected' : '' ?>>NO</option>
            </select>

            <button type="submit">Guardar y continuar</button>
        </form>
    <?php endif; ?>

    <!-- ===================== PASO 5 ===================== -->
    <?php if ($paso == 5): ?>
        <form method="POST">
            <h3>5. Observaciones finales</h3>
            <label>Observaciones</label>
            <textarea name="observaciones"><?= $registro->observaciones ?? '' ?></textarea>
            <button type="submit">Finalizar registro</button>
        </form>
    <?php endif; ?>
    
</div>