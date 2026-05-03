<form id="formSolicitud">
    <input type="text" name="nombres" placeholder="Nombre completo" required>
    <input type="text" name="apellidos" placeholder="Apellidos" required>
    <select name="tipo_documento" id="tipo_documento" required>
        <option value="">Tipo de documento</option>
        <option value="CC">CC</option>
        <option value="CE">CE</option>
        <option value="PA">PA</option>
        <option value="SD">SD</option>
        <option value="PEP">PEP</option>
        <option value="PT">PT</option>
    </select>
    <input type="text" name="documento" placeholder="documento" required>
    <input type="text" name="profesion" placeholder="Profesión" required>
    <select name="departamento_asignado" id="departamento_asignado" required>
        <option value="">Departamento asignado</option>
        <option value="1">Antioquia</option>
        <option value="2">Chocó</option>
        <option value="3">Valle del Cauca</option>
    </select>
    <select name="municipio_asignado" id="municipio_asignado" required>
        <option value="">Municipio asignado</option>
        <option value="1">Acadi</option>
        <option value="2">Riosucio</option>
        <option value="3">Quibdo</option>
    </select>
    <select name="vereda_asignada" id="vereda_asignada" required>
        <option value="">Vereda asignada</option>
        <option value="1">Belalcazar</option>
        <option value="2">El Porvenir</option>
        <option value="3">Las Minas</option>
        <option value="4">Manserrey</option>
        <option value="5">Nueva Antioquia</option>
        <option value="6">Pueblo Nuevo</option>
        <option value="7">Remedios</option>
        <option value="8">Riosucio</option>
    </select>
    <input type="email" name="email" placeholder="Correo" required>
    <input type="text" name="celular" placeholder="celular">
    <button type="submit">Solicitar acceso</button>
</form>

<p id="msgSolicitud"></p>


<script>
    add_action('wp_ajax_nopriv_aec_guardar_solicitud', 'aec_guardar_solicitud');

    function aec_guardar_solicitud(){

        global $wpdb;
        $tabla = $wpdb->prefix . 'aec_solicitudes';

        $wpdb->insert($tabla, [
            'nombre' => $_POST['nombres'],
            'apellidos' => $_POST['apellidos'],
            'tipo_documento' => $_POST['tipo_documento'],
            'documento' => $_POST['documento'],
            'profesion' => $_POST['profesion'],
            'departamento_asignado' => $_POST['departamento_asignado'],
            'municipio_asignado' => $_POST['municipio_asignado'],
            'vereda_asignada' => $_POST['vereda_asignada'],
            'email' => $_POST['email'],
            'celular' => $_POST['celular'],
            'estado' => 'PENDIENTE'
        ]);

        wp_send_json(['success' => true]);
    }
</script>

<script>
    document.getElementById('formSolicitud').addEventListener('submit', function(e){
        e.preventDefault();
        const data = new FormData(this);
        data.append('action', 'aec_guardar_solicitud');
        fetch(ajaxUrl, {
            method: 'POST',
            body: data
        })
        .then(res => res.json())
        .then(res => {
            document.getElementById('msgSolicitud').innerText = "Solicitud enviada";
        });
    });
</script>