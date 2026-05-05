<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Login - AICOLD</title>
        <!-- 🔥 REUTILIZAR CSS DE LA LANDING -->
        <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700;900&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/css/landing.css">
        <!-- 🔥 LOGIN CSS -->
        <link rel="stylesheet" href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/css/login.css">
    </head>
    <body>
        <!-- 🔥 HEADER (MISMO DE LANDING) -->
        <div class="canvas-area">        
            <div class="device-frame desktop" id="deviceFrame">
                <div class="microsite">
                    <nav class="wf-nav">
                        <div class="logo-area">                            
                            <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/3.png" alt="Logo 3" style="width:180px;">                            
                        </div>
                        <div class="logo-area">                            
                            <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/5.png" alt="Logo 5" style="width:150px;">
                        </div>                        
                        <div class="logo-area">                            
                            <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/1.png" alt="Logo 1" style="width:180px;">
                        </div>                                                
                        <div class="wf-hamburger">
                            <span></span><span></span><span></span>
                        </div>
                    </nav>
                    
                    <!-- 🔥 CONTENEDOR PRINCIPAL -->
                    <section class="aec-login-wrapper">
                        <!-- IZQUIERDA (BANNER LANDING) -->
                        <div class="aec-login-left">
                            <section class="wf-hero">
                                <div class="hero-pattern"></div>
                                <div class="hero-circles"></div>
                                <div class="hero-content">
                                    <div class="hero-eyebrow">
                                        <div class="dot"></div>
                                        <span>Micrositio AICOLD · Organizaciones Étnicas</span>
                                    </div>
                                    <h1 class="hero-title">
                                        Saberes ancestrales<br>para una <em>economía</em><br>más circular
                                    </h1>
                                    <p class="hero-desc">
                                        Plataforma para la caracterización de organizaciones comunitarias afrocolombianas, indígenas, raizales y palenqueras que desarrollan emprendimientos en economía circular, gestión de residuos y negocios verdes.
                                    </p>
                                    <div class="hero-ctas">
                                        <button class="cta-secondary">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                                            Registro de aspirantes
                                        </button>
                                    </div>
                                </div>
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

                        <!-- DERECHA (LOGIN) -->
                        <div class="aec-login-right">
                            <div class="aec-login">
                                <h2>Iniciar Sesión</h2>
                                <form method="POST">
                                    <label>Email</label>
                                    <input type="email" name="email" required>

                                    <label>Contraseña</label>
                                    <input type="password" name="password" required>

                                    <button type="submit">Ingresar</button>
                                </form>
                            </div>
                            <?php include AEC_PATH . 'includes/auth/login.php'; ?>
                        </div>
                    </section>
                </div> <!--  END microsite -->
            </div> <!--  END device-frame -->
        </div> <!--  END canvas-area -->
    </body>
</html>