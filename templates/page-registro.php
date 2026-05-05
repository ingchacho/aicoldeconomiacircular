<?php
    global $wpdb;

    $tabla = $wpdb->prefix . 'aec_aspirantes';
    $mensaje = "";

    // 🔥 GUARDAR FORMULARIO
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $wpdb->insert($tabla, [
            'nombre' => sanitize_text_field($_POST['nombre']),
            'documento' => sanitize_text_field($_POST['documento']),
            'fecha_nacimiento' => $_POST['fecha_nacimiento'],
            'departamento' => sanitize_text_field($_POST['departamento']),
            'municipio' => sanitize_text_field($_POST['municipio']),
            'vereda' => sanitize_text_field($_POST['vereda']),
            'whatsapp' => sanitize_text_field($_POST['whatsapp']),
            'email' => sanitize_email($_POST['email']),
            'estado' => 'PENDIENTE',
            'fecha' => current_time('mysql')
        ]);

        $mensaje = "✅ Tu solicitud fue enviada. Un administrador validará tu información.";
    }
?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Registro Aspirantes - AICOLD</title>

        <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700;900&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/css/landing.css">

        <style>
            .aec-wrapper {
                display: flex;
                min-height: 100vh;
            }

            .aec-left {
                flex: 1.2;
                display: flex;
            }

            .aec-left .wf-hero {
                width: 100%;
                height: 100%;
            }

            .aec-right {
                flex: 0.8;
                display: flex;
                justify-content: center;
                align-items: center;
                background: #f7f7f7;
            }

            .aec-form {
                width: 350px;
            }

            .aec-form input {
                width: 100%;
                margin-bottom: 10px;
                padding: 10px;
                border-radius: 6px;
                border: 1px solid #ccc;
            }

            .aec-form button {
                width: 100%;
                padding: 12px;
                background: #2e7d32;
                color: white;
                border: none;
                border-radius: 6px;
                cursor: pointer;
            }

            .aec-msg {
                background: #dff0d8;
                padding: 10px;
                margin-bottom: 10px;
                border-radius: 6px;
            }
        </style>
    </head>

    <body>

        <div class="canvas-area">
        <div class="device-frame desktop">
        <div class="microsite">

        <!-- HEADER -->
        <nav class="wf-nav">
            <div class="logo-area">
                <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/3.png" style="width:180px;">
            </div>
            <div class="logo-area">
                <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/5.png" style="width:150px;">
            </div>
            <div class="logo-area">
                <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/1.png" style="width:180px;">
            </div>
        </nav>

        <!-- CONTENIDO -->
        <section class="aec-wrapper">

            <!-- IZQUIERDA -->
            <div class="aec-left">
                <section class="wf-hero">
                    <div class="hero-pattern"></div>
                    <div class="hero-content">
                        <h1 class="hero-title">
                            Saberes ancestrales<br>para una <em>economía</em><br>más circular
                        </h1>
                        <p class="hero-desc">
                            Plataforma para la caracterización de organizaciones comunitarias.
                        </p>
                    </div>
                </section>
            </div>

            <!-- DERECHA -->
            <div class="aec-right">
                <div class="aec-form">

                    <h2>Registro de Aspirante</h2>

                    <?php if($mensaje): ?>
                        <div class="aec-msg"><?php echo $mensaje; ?></div>
                    <?php endif; ?>

                    <form method="POST">

                        <input type="text" name="nombre" placeholder="Nombres y apellidos" required>
                        <input type="text" name="documento" placeholder="Número de documento" required>
                        <input type="date" name="fecha_nacimiento" required>
                        <input type="text" name="departamento" placeholder="Departamento">
                        <input type="text" name="municipio" placeholder="Municipio">
                        <input type="text" name="vereda" placeholder="Vereda">
                        <input type="text" name="whatsapp" placeholder="WhatsApp">
                        <input type="email" name="email" placeholder="Correo electrónico" required>

                        <label style="font-size:12px;">
                            <input type="checkbox" required> Acepto términos y condiciones
                        </label>

                        <button type="submit">Registrarme</button>

                    </form>

                </div>
            </div>

        </section>

        </div>
        </div>
        </div>

    </body>
</html>