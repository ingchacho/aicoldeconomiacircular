<?php
global $wpdb;

$tabla = $wpdb->prefix . 'aec_aspirantes';
$mensaje = "";

/* =========================================
GUARDAR FORMULARIO
========================================= */

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

    $mensaje = "✅ Tu solicitud fue enviada correctamente.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Registro Aspirantes - AICOLD</title>

    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700;900&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    <!-- LANDING -->
    <link rel="stylesheet" href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/css/landing.css">

    <!-- LOGIN / REGISTER CSS -->
    <link rel="stylesheet" href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/css/registro.css">


   

</head>

<body>

<div class="canvas-area">

<div class="device-frame desktop">

<div class="microsite">

<!-- =========================================
REGISTER LAYOUT
========================================= -->

<section class="aec-login-wrapper">

    <!-- =========================================
    LEFT HERO
    ========================================= -->

    <div class="aec-login-left">

        <section class="wf-hero">

            <!-- VIDEO -->

            <div class="hero-video-container">

                <iframe
                    class="hero-youtube-video"
                    src="https://www.youtube.com/embed/M9v9JYVS3Mc?autoplay=1&mute=1&controls=0&loop=1&playlist=M9v9JYVS3Mc&playsinline=1&modestbranding=1&rel=0"
                    frameborder="0"
                    allow="autoplay; fullscreen"
                    allowfullscreen>
                </iframe>

            </div>

            <!-- OVERLAY -->

            <div class="hero-overlay"></div>

            <div class="hero-pattern"></div>

            <div class="hero-circles"></div>

            <!-- CONTENT -->

            <div class="hero-content">

                <div class="hero-eyebrow">

                    <div class="dot"></div>

                    <span>
                        Micrositio AICOLD · Registro Delegados
                    </span>

                </div>

                <h1 class="hero-title">
                    Saberes ancestrales<br>
                    para una <em>economía</em><br>
                    más circular
                </h1>

                <p class="hero-desc">
                    Plataforma para la caracterización de organizaciones comunitarias afrocolombianas, indígenas, raizales y palenqueras que desarrollan emprendimientos en economía circular, gestión de residuos y negocios verdes.
                </p>

                <div class="hero-ctas">

                    <button class="cta-secondary">

                        <svg width="16" height="16" viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">

                            <circle cx="12" cy="12" r="10"/>

                            <path d="M12 8v4M12 16h.01"/>

                        </svg>

                        Registro de aspirantes

                    </button>

                </div>

            </div>

            <!-- STATS -->

            <div class="hero-stats">

                <div class="stat-card">

                    <span class="num">28</span>

                    <span class="lbl">Departamentos</span>

                </div>

                <div class="stat-card">

                    <span class="num">4</span>

                    <span class="lbl">Pueblos étnicos</span>

                </div>

                <div class="stat-card">

                    <span class="num">187</span>

                    <span class="lbl">Iniciativas verdes</span>

                </div>

            </div>

        </section>

    </div>

    <!-- =========================================
    RIGHT FORM
    ========================================= -->

    <div class="aec-login-right">

        <!-- LOGOS -->

        <div class="aec-login-brand">

            <div class="logo-area">

                <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/3.png">

            </div>

            <div class="logo-area">

                <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/5.png">

            </div>

            <div class="logo-area">

                <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/1.png">

            </div>

        </div>

        <!-- FORM -->

        <div class="aec-login">

            <h2>Registro Delegados</h2> 
            <p>
                Completa el formulario para solicitar acceso al micrositio AICOLD.
            </p>

            <?php if($mensaje): ?>

                <div class="aec-msg">

                    <?php echo $mensaje; ?>

                </div>

            <?php endif; ?>
            <br>

            <form method="POST" class="aec-register-form">

                <div class="form-grid">

                    <div class="form-group">
                        <label>Nombres y apellidos</label>
                        <input type="text" name="nombre" required>
                    </div>

                    <div class="form-group">
                        <label>Número de documento</label>
                        <input type="text" name="documento" required>
                    </div>

                    <div class="form-group">
                        <label>Fecha nacimiento</label>
                        <input type="date" name="fecha_nacimiento" required>
                    </div>

                    <div class="form-group">
                        <label>Departamento asignado</label>
                        <input type="text" name="departamento">
                    </div>

                    <div class="form-group">
                        <label>Municipio asignado</label>
                        <input type="text" name="municipio">
                    </div>

                    <div class="form-group">
                        <label>Vereda asignada</label>
                        <input type="text" name="vereda">
                    </div>

                    <div class="form-group">
                        <label>WhatsApp</label>
                        <input type="text" name="whatsapp">
                    </div>

                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" name="email" required>
                    </div>

                </div>

                <label class="terms-check">

                    <input type="checkbox" required>

                    <span>
                        Acepto términos y condiciones
                    </span>

                </label>

                <button type="submit">

                    Registrarme

                </button>

            </form>

        </div>

    </div>

</section>

</div>
</div>
</div>

</body>
</html>