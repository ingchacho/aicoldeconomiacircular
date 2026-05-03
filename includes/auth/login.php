<?php
if (!session_id()) session_start();

global $wpdb;
$tabla = $wpdb->prefix . 'aec_usuarios';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];

    $user = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $tabla WHERE email = %s", $email)
    );

    if($user){

        if($user->estado != 'ACTIVO'){
            echo "<p style='color:red;'>Usuario pendiente de aprobación</p>";
            return;
        }

        if(password_verify($password, $user->password)){

            $_SESSION['aec_user'] = [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'rol' => $user->rol
            ];

            header("Location: ?page_id=10"); // dashboard
            exit;

        } else {
            echo "<p style='color:red;'>Contraseña incorrecta</p>";
        }

    } else {
        echo "<p style='color:red;'>Usuario no encontrado</p>";
    }
}
?>