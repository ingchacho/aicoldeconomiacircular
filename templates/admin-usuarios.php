<?php
    $solicitudes = $wpdb->get_results("
        SELECT * FROM {$wpdb->prefix}aec_solicitudes
        WHERE estado = 'PENDIENTE'
    ");


    foreach($solicitudes as $s){
        echo "
        <div>
            {$s->nombre} - {$s->email}
            <button onclick='aprobar({$s->id})'>Aprobar</button>
            <button onclick='rechazar({$s->id})'>Rechazar</button>
        </div>";
    }

    add_action('wp_ajax_aec_aprobar_usuario', 'aec_aprobar_usuario');

    function aec_aprobar_usuario(){

        global $wpdb;

        $id = $_POST['id'];

        $tabla_sol = $wpdb->prefix . 'aec_solicitudes';
        $tabla_usr = $wpdb->prefix . 'aec_usuarios';

        $sol = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $tabla_sol WHERE id = %d", $id)
        );

        if(!$sol) return;

        $password = wp_generate_password(8);

        $wpdb->insert($tabla_usr, [
            'nombre' => $sol->nombre,
            'email' => $sol->email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'rol' => 'LIM',
            'estado' => 'ACTIVO'
        ]);

        $wpdb->update($tabla_sol,
            ['estado' => 'APROBADO'],
            ['id' => $id]
        );

        // Aquí puedes enviar correo después

        wp_send_json([
            'success' => true,
            'password' => $password
        ]);
    }

?>