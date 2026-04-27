<?php
if (!session_id()) session_start();

global $wpdb;
$tabla = $wpdb->prefix . 'organizaciones';

// =====================
// RESET MANUAL
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

// =====================
// ID ACTUAL
// =====================
$aec_id = $_SESSION['aec_id'] ?? null;

// =====================
// PASO
// =====================
$paso = isset($_GET['paso']) ? intval($_GET['paso']) : 1;

// =====================
// CARGAR REGISTRO
// =====================
$registro = null;

if ($aec_id) {
    $registro = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $tabla WHERE id = %d", $aec_id)
    );

    if ($registro && !isset($_GET['paso'])) {
        $paso = $registro->paso_actual;
    }
}

// =====================
// GUARDAR
// =====================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = $_POST;

    if (!$aec_id) {
        $wpdb->insert($tabla, ['paso_actual' => $paso]);
        $aec_id = $wpdb->insert_id;
        $_SESSION['aec_id'] = $aec_id;
    }

    // ===== PASO 1 =====
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

    // ===== PASO 2 =====
    if ($paso == 2) {
        $wpdb->update($tabla, [
            'nombre_emprendimiento' => sanitize_text_field($data['nombre_emprendimiento']),
            'estado_iniciativa' => sanitize_text_field($data['estado_iniciativa']),
            'tiempo_operacion' => sanitize_text_field($data['tiempo_operacion']),
            'ubicacion_negocio' => sanitize_text_field($data['ubicacion_negocio']),
            'paso_actual' => 3
        ], ['id' => $aec_id]);
    }

    // ===== PASO 3 =====
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

    // ===== PASO 4 =====
    if ($paso == 4) {
        $wpdb->update($tabla, [
            'problema_ambiental' => sanitize_textarea_field($data['problema_ambiental']),
            'saberes' => sanitize_text_field($data['saberes']),
            'genera_empleo' => sanitize_text_field($data['genera_empleo']),
            'paso_actual' => 5
        ], ['id' => $aec_id]);
    }

    // ===== PASO 5 =====
    if ($paso == 5) {

        $wpdb->update($tabla, [
            'observaciones' => sanitize_textarea_field($data['observaciones']),
            'paso_actual' => 5
        ], ['id' => $aec_id]);

        // 🔥 RESET SESIÓN
        unset($_SESSION['aec_id']);

        echo "
            <div style='text-align:center; padding:20px;'>

            <h3 style='color:green;'>✅ Registro finalizado correctamente</h3>

            <p>Serás redirigido al dashboard...</p>

            <a href='?page_id=10'>Ir ahora</a>

            </div>

            <script>
            setTimeout(function(){
                window.location.href='?page_id=10';
            }, 2000);
            </script>
            ";
        return;
    }

    wp_redirect('?page_id=' . get_the_ID() . '&edit=' . $aec_id . '&paso=' . ($paso + 1));
    exit;    
}

// =====================
// PROGRESO
// =====================
$porcentaje = ($paso / 5) * 100;
?>

<div class="aec-container">

<div class="aec-progress">
    <div class="aec-bar" style="width: <?= $porcentaje ?>%"></div>
</div>

<p>Paso <?= $paso ?> de 5</p>

<!-- ===================== -->
<!-- PASO 1 -->
<!-- ===================== -->
<?php if ($paso == 1): ?>
<form method="POST" class="aec-form">

<h3>1. Perfil del Postulante</h3>

<!-- Nombre -->
<label>Nombre completo</label>
<input type="text" name="nombre"
value="<?= esc_attr($registro->nombre ?? '') ?>" required>

<!-- Tipo documento -->
<label>Tipo de documento</label>
<select name="tipo_documento">
    <option value="">Seleccione</option>
    <option value="CC" <?= ($registro->tipo_documento ?? '') == 'CC' ? 'selected' : '' ?>>C.C</option>
    <option value="TI" <?= ($registro->tipo_documento ?? '') == 'TI' ? 'selected' : '' ?>>T.I</option>
</select>

<label>Número de documento</label>
<input type="text" name="numero_documento"
value="<?= esc_attr($registro->numero_documento ?? '') ?>">

<!-- Ubicación -->
<label>Departamento</label>
<input type="text" name="departamento"
value="<?= esc_attr($registro->departamento ?? '') ?>">

<label>Municipio</label>
<input type="text" name="municipio"
value="<?= esc_attr($registro->municipio ?? '') ?>">

<label>Vereda / Corregimiento</label>
<input type="text" name="vereda"
value="<?= esc_attr($registro->vereda ?? '') ?>">

<!-- Contacto -->
<label>Teléfono / WhatsApp</label>
<input type="text" name="telefono"
value="<?= esc_attr($registro->telefono ?? '') ?>">

<label>Email</label>
<input type="email" name="email"
value="<?= esc_attr($registro->email ?? '') ?>">

<!-- Datos personales -->
<label>Edad</label>
<input type="number" name="edad"
value="<?= esc_attr($registro->edad ?? '') ?>">

<label>Sexo</label>
<select name="sexo">
    <option value="">Seleccione</option>
    <option value="Masculino" <?= ($registro->sexo ?? '') == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
    <option value="Femenino" <?= ($registro->sexo ?? '') == 'Femenino' ? 'selected' : '' ?>>Femenino</option>
</select>

<label>Identidad de género</label>
<input type="text" name="genero"
value="<?= esc_attr($registro->genero ?? '') ?>">

<label>Nivel de escolaridad</label>
<select name="escolaridad">
    <option value="">Seleccione</option>
    <option value="Primaria" <?= ($registro->escolaridad ?? '') == 'Primaria' ? 'selected' : '' ?>>Primaria</option>
    <option value="Secundaria" <?= ($registro->escolaridad ?? '') == 'Secundaria' ? 'selected' : '' ?>>Secundaria</option>
    <option value="Técnico" <?= ($registro->escolaridad ?? '') == 'Técnico' ? 'selected' : '' ?>>Técnico</option>
    <option value="Tecnólogo" <?= ($registro->escolaridad ?? '') == 'Tecnólogo' ? 'selected' : '' ?>>Tecnólogo</option>
    <option value="Universitario" <?= ($registro->escolaridad ?? '') == 'Universitario' ? 'selected' : '' ?>>Universitario</option>
</select>

<!-- Enfoque -->
<label>Enfoque diferencial</label>
<select name="enfoque">
    <option value="">Seleccione</option>
    <option value="Afrocolombiano" <?= ($registro->enfoque ?? '') == 'Afrocolombiano' ? 'selected' : '' ?>>Afrocolombiano</option>
    <option value="Afrodescendiente" <?= ($registro->enfoque ?? '') == 'Afrodescendiente' ? 'selected' : '' ?>>Afrodescendiente</option>
    <option value="Comunidad Negra" <?= ($registro->enfoque ?? '') == 'Comunidad Negra' ? 'selected' : '' ?>>Comunidad Negra</option>
    <option value="Palenquera" <?= ($registro->enfoque ?? '') == 'Palenquera' ? 'selected' : '' ?>>Palenquera</option>
    <option value="Raizal" <?= ($registro->enfoque ?? '') == 'Raizal' ? 'selected' : '' ?>>Raizal</option>
</select>

<!-- Condiciones -->
<label>¿Es víctima?</label>
<select name="victima">
    <option value="">Seleccione</option>
    <option value="SI" <?= ($registro->victima ?? '') == 'SI' ? 'selected' : '' ?>>SI</option>
    <option value="NO" <?= ($registro->victima ?? '') == 'NO' ? 'selected' : '' ?>>NO</option>
</select>

<label>¿Es campesino?</label>
<select name="campesino">
    <option value="">Seleccione</option>
    <option value="SI" <?= ($registro->campesino ?? '') == 'SI' ? 'selected' : '' ?>>SI</option>
    <option value="NO" <?= ($registro->campesino ?? '') == 'NO' ? 'selected' : '' ?>>NO</option>
</select>

<!-- Discapacidad -->
<label>Discapacidad</label>
<textarea name="discapacidad"><?= esc_textarea($registro->discapacidad ?? '') ?></textarea>

<!-- Enfoques adicionales -->
<label>¿Mujer rural?</label>
<select name="mujer_rural">
    <option value="">Seleccione</option>
    <option value="SI" <?= ($registro->mujer_rural ?? '') == 'SI' ? 'selected' : '' ?>>SI</option>
    <option value="NO" <?= ($registro->mujer_rural ?? '') == 'NO' ? 'selected' : '' ?>>NO</option>
</select>

<label>¿Joven rural?</label>
<select name="joven_rural">
    <option value="">Seleccione</option>
    <option value="SI" <?= ($registro->joven_rural ?? '') == 'SI' ? 'selected' : '' ?>>SI</option>
    <option value="NO" <?= ($registro->joven_rural ?? '') == 'NO' ? 'selected' : '' ?>>NO</option>
</select>

<!-- Personas a cargo -->
<label>No. personas a cargo</label>
<input type="number" name="personas_cargo"
value="<?= esc_attr($registro->personas_cargo ?? '') ?>">

<button type="submit">Guardar y continuar</button>

</form>
<?php endif; ?>

<!-- ===================== -->
<!-- PASO 2 -->
<!-- ===================== -->
<?php if ($paso == 2): ?>
<form method="POST" class="aec-form">

<h3>2. Datos del Negocio</h3>

<label>Nombre del emprendimiento / idea</label>
<input type="text" name="nombre_emprendimiento"
value="<?= esc_attr($registro->nombre_emprendimiento ?? '') ?>">

<label>Estado de la iniciativa</label>
<select name="estado_iniciativa">
    <option value="">Seleccione</option>
    <option value="Idea" <?= ($registro->estado_iniciativa ?? '') == 'Idea' ? 'selected' : '' ?>>Idea</option>
    <option value="En desarrollo" <?= ($registro->estado_iniciativa ?? '') == 'En desarrollo' ? 'selected' : '' ?>>En desarrollo</option>
    <option value="En operación" <?= ($registro->estado_iniciativa ?? '') == 'En operación' ? 'selected' : '' ?>>En operación</option>
</select>

<label>Tiempo de operación</label>
<input type="text" name="tiempo_operacion"
value="<?= esc_attr($registro->tiempo_operacion ?? '') ?>">

<label>Ubicación del negocio (Vereda / Municipio)</label>
<input type="text" name="ubicacion_negocio"
value="<?= esc_attr($registro->ubicacion_negocio ?? '') ?>">

<button type="submit">Guardar y continuar</button>

</form>
<?php endif; ?>

<!-- ===================== -->
<!-- PASO 3 -->
<!-- ===================== -->
<?php if ($paso == 3): ?>
<form method="POST" class="aec-form">

<h3>3. Componente Técnico</h3>

<label>Descripción de la idea o negocio</label>
<textarea name="descripcion"><?= esc_textarea($registro->descripcion ?? '') ?></textarea>

<label>¿A qué mercado está orientado?</label>
<textarea name="mercado"><?= esc_textarea($registro->mercado ?? '') ?></textarea>

<label>Bienes o servicios que genera</label>
<textarea name="bienes_servicios"><?= esc_textarea($registro->bienes_servicios ?? '') ?></textarea>

<label>Tipos de insumos utilizados</label>
<textarea name="insumos"><?= esc_textarea($registro->insumos ?? '') ?></textarea>

<label>¿Usa residuos en su proceso?</label>
<select name="usa_residuos">
    <option value="">Seleccione</option>
    <option value="SI" <?= ($registro->usa_residuos ?? '') == 'SI' ? 'selected' : '' ?>>SI</option>
    <option value="NO" <?= ($registro->usa_residuos ?? '') == 'NO' ? 'selected' : '' ?>>NO</option>
</select>

<button type="submit">Guardar y continuar</button>

</form>
<?php endif; ?>

<!-- ===================== -->
<!-- PASO 4 -->
<!-- ===================== -->
<?php if ($paso == 4): ?>
<form method="POST" class="aec-form">

<h3>4. Potencial Verde</h3>

<label>¿Qué problema ambiental resuelve?</label>
<textarea name="problema_ambiental"><?= esc_textarea($registro->problema_ambiental ?? '') ?></textarea>

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

<!-- ===================== -->
<!-- PASO 5 -->
<!-- ===================== -->
<?php if ($paso == 5): ?>
<form method="POST">

<textarea name="observaciones"><?= esc_textarea($registro->observaciones ?? '') ?></textarea>

<button type="submit">Finalizar</button>
</form>
<?php endif; ?>

</div>