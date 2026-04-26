<div class="aec-container">
    <h2>Registro de Organización</h2>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            global $wpdb;

            $tabla = $wpdb->prefix . 'organizaciones';

            $nombre = sanitize_text_field($_POST['nombre']);
            $territorio = sanitize_text_field($_POST['territorio']);
            $comunidad = sanitize_text_field($_POST['comunidad']);
            $actividad = sanitize_textarea_field($_POST['actividad']);

            $wpdb->insert($tabla, [
                'nombre' => $nombre,
                'territorio' => $territorio,
                'comunidad' => $comunidad,
                'actividad' => $actividad
            ]);

            echo "<p style='color:green;'>Registro guardado correctamente</p>";
        }
    ?>

    <form method="POST">

        <label>Nombre de la organización</label>
        <input type="text" name="nombre" required>

        <label>Territorio</label>
        <input type="text" name="territorio" required>

        <label>Tipo de comunidad</label>
        <select name="comunidad">
            <option value="Afrocolombiana">Afrocolombiana</option>
            <option value="Indígena">Indígena</option>
            <option value="Raizal">Raizal</option>
            <option value="Palenquera">Palenquera</option>
        </select>

        <label>Actividad ambiental</label>
        <textarea name="actividad"></textarea>

        <button type="submit">Registrar</button>

    </form>
</div>