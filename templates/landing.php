<?php
    // Seguridad básica
    if (!defined('ABSPATH')) {
        exit;
    }
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AICOLD</title>   
        <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700;900&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/css/landing.css">
    </head>

    <body>
        <div class="canvas-area">        
            <div class="microsite">
                <nav class="wf-nav">
                    <div class="logo-area">                            
                        <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/3.png" alt="Logo 3" style="width:180px;">                            
                    </div>
                    <div class="logo-area">                            
                        <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/5.png" alt="Logo 5" style="width:150px;">
                    </div>                        
                    
                    <div class="wf-nav-links">
                        <div class="wf-nav-link active">Inicio</div>
                        <div class="wf-nav-link">Indicadores</div>
                        <div class="wf-nav-link">Mapa territorial</div>
                        <div class="wf-nav-link">Contactenos</div>
                    </div>

                    <div class="logo-area">                            
                        <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/1.png" alt="Logo 1" style="width:180px;">
                    </div>                                                
                        
                    <!-- HAMBURGER -->
                    <div class="wf-hamburger" onclick="toggleMobileMenu()">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <!-- MOBILE MENU -->
                    <div id="wf-mobile-menu" class="wf-mobile-menu">
                        <a href="#">Inicio</a>
                        <a href="#">Indicadores</a>
                        <a href="#">Mapa territorial</a>
                        <a href="#">Contáctenos</a>
                    </div>
                    <!-- OVERLAY -->
                    <div id="wf-overlay" class="wf-overlay" onclick="closeMobileMenu()"></div>
                </nav>

                <!-- ══ SECCIÓN: HERO ══ -->
                <div class="wf-section-block" id="s-hero">
                    <section class="wf-hero">
                                                
                        <!-- YOUTUBE BACKGROUND -->
                        <div class="hero-video-container">                            
                            <iframe
                                class="hero-youtube-video"
                                src="https://www.youtube.com/embed/M9v9JYVS3Mc?autoplay=1&mute=1&controls=0&loop=1&playlist=M9v9JYVS3Mc&playsinline=1&modestbranding=1&rel=0&showinfo=0"
                                title="Hero Video"
                                frameborder="0"
                                allow="autoplay; fullscreen"
                                allowfullscreen>
                            </iframe>                                
                        </div>

                        <!-- OVERLAY -->
                        <div class="hero-overlay"></div>                            
                        <!-- <div class="hero-pattern"></div> -->
                        <!-- <div class="hero-circles"></div> --> 
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
                                <a class="cta-primary" href="<?php echo site_url('/login'); ?>" class="mobile-login-btn" style="text-decoration: none;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                                    Iniciar sesión
                                </a>
                                <a href="<?php echo home_url('/registro'); ?>" class="cta-secondary stat-card" style="display: inline-block;text-decoration: none;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>                                    
                                    Solicitar registro
                                </a>
                            </div>
                        </div>

                                                
                        <?php

                            global $wpdb;

                            /* TABLA REAL */
                            $tabla = 'aicold_organizaciones';

                            /* TOTAL ORGANIZACIONES */
                            $total_organizaciones = $wpdb->get_var("
                                SELECT COUNT(*) 
                                FROM $tabla
                            ");

                            /* TOTAL DEPARTAMENTOS */
                            $total_departamentos = $wpdb->get_var("
                                SELECT COUNT(DISTINCT departamento)
                                FROM $tabla
                                WHERE departamento IS NOT NULL
                                AND departamento != ''
                            ");

                            /* TOTAL PUEBLOS ÉTNICOS */
                            $total_pueblos = $wpdb->get_var("
                                SELECT COUNT(DISTINCT enfoque)
                                FROM $tabla
                                WHERE enfoque IS NOT NULL
                                AND enfoque != ''
                            ");

                            /* TOTAL INICIATIVAS */
                            $total_iniciativas = $wpdb->get_var("
                                SELECT COUNT(nombre_emprendimiento)
                                FROM $tabla
                                WHERE nombre_emprendimiento IS NOT NULL
                                AND nombre_emprendimiento != ''
                            ");

                        ?>                       
 
                        <div class="hero-stats">

                            <div class="stat-card">
                                <span class="num">
                                    <?php echo number_format($total_organizaciones); ?>
                                </span>
                                <span class="lbl">Organizaciones</span>
                            </div>

                            <div class="stat-card">
                                <span class="num">
                                    <?php echo number_format($total_departamentos); ?>
                                </span>
                                <span class="lbl">Departamentos</span>
                            </div>

                            <div class="stat-card">
                                <span class="num">
                                    <?php echo number_format($total_pueblos); ?>
                                </span>
                                <span class="lbl">Pueblos étnicos</span>
                            </div>

                            <div class="stat-card">
                                <span class="num">
                                    <?php echo number_format($total_iniciativas); ?>
                                </span>
                                <span class="lbl">Iniciativas verdes</span>
                            </div>
                            
                        </div>                      
                    </section>

                </div>            

                <!-- CARDS -->
                <div class="section">
                    <div class="grid">

                        <div class="card">
                            <iframe width="280px" height="120" src="https://www.youtube.com/embed/UlCdi-FwTCI?si=biJfkNGp9tnCW8XM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>                        
                            </iframe>
                            <h3>¿Qué es la economía circular?</h3>
                            <p>Es una forma de pensar y organizar la producción y el consumo para que los  recursos se utilicen de manera responsable y duren el mayor tiempo posible.  En lugar de usar y desechar, la economía circular propone reducir VER MÁS..... </p>
                        </div>

                        <div class="card">
                            <iframe width="280px" height="120px" src="https://www.youtube.com/embed/o8SQI5OR3F4?si=qIulTjwOhQ0G8_5t" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>                                    
                            </iframe>                                        
                            <h3>¿Que es Educación ambiental?</h3>
                            <p>Es un proceso de aprendizaje que ayuda a comprender la relación entre las personas, la naturaleza y el territorio. Su objetivo es fortalecer la conciencia ambiental, VER MAS...</p>
                        </div>

                        <div class="card">
                            <iframe width="280px" height="120px" src="https://www.youtube.com/embed/5aiu-QxHteU?si=CC005n5M5sTBbY9i" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>                                    
                            </iframe>
                            <h3>¿Que son Negocios verdes?</h3>
                            <p>Son actividades económicas que generan ingresos sin dañar el ambiente. Se basan en el uso responsable de los recursos, la materiales. VER MÁS.....</p>
                        </div>

                        <div class="card">
                            <iframe width="280px" height="120px" src="https://www.youtube.com/embed/PIXT9Se3EsM?si=Iy2SwY8Q30GEYrLz" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>                                
                            </iframe>    
                            <h3>¿Qué es BASURA CERO?</h3>
                            <p>Es un enfoque que busca reducir al máximo la cantidad de residuos que llegan a rellenos sanitarios o al ambiente. Promueve cambios en los hábitos diarios para evitar el  VER MÁS....</p>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <footer class="wf-footer">
                    <div class="footer-grid">
                        <div class="footer-brand">
                            <div class="logo-area">                            
                                <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/3.png" alt="Logo 3" style="width:100px;">                                    
                                <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/5.png" alt="Logo 5" style="width:100px;">
                                <img src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>assets/img/1.png" alt="Logo 1" style="width:100px;">
                            </div>                                
                            <p>Plataforma para la caracterización y visibilización de organizaciones étnicas colombianas que desarrollan economía circular, gestión de residuos, educación ambiental y negocios verdes con fundamento en saberes y prácticas tradicionales.</p>
                        </div>
                            
                        <div class="footer-col">
                            <h4>Organizaciones</h4>
                            <ul>
                                <li>Directorio general</li>
                                <li>Comunidades afrocolombianas</li>
                                <li>Pueblos indígenas</li>
                                <li>Comunidades raizales</li>
                                <li>Comunidades palenqueras</li>
                            </ul>
                        </div>
                        <div class="footer-col">
                            <h4>Iniciativas</h4>
                            <ul>
                                <li>Economía circular</li>
                                <li>Gestión de residuos</li>
                                <li>Educación ambiental</li>
                                <li>Negocios verdes</li>
                                <li>Mapa territorial</li>
                            </ul>
                        </div>
                        <div class="footer-col">
                            <h4>Institucional</h4>
                            <ul>
                                <li>Acerca de AICOLD</li>
                                <li>Marco normativo</li>
                                <li>Aliados estratégicos</li>
                                <li>Datos abiertos</li>
                                <li>Contacto</li>
                                <li>Política de privacidad</li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-bottom">
                        <p>© 2026 AICOLD — República de Colombia · Todos los derechos reservados</p>
                        <div class="footer-social">
                            <div class="social-btn">f</div>
                            <div class="social-btn">in</div>
                            <div class="social-btn">tw</div>
                            <div class="social-btn">yt</div>
                        </div>
                    </div>
                </footer>
            </div><!-- /microsite -->    
        </div><!-- /canvas-area -->   

        <script>
            function toggleMobileMenu(){
                document.getElementById('wf-mobile-menu').classList.toggle('active');
                document.getElementById('wf-overlay').classList.toggle('active');
            }
            function closeMobileMenu(){
                document.getElementById('wf-mobile-menu').classList.remove('active');
                document.getElementById('wf-overlay').classList.remove('active');
            }
        </script>

        <script>
            window.addEventListener('scroll', function(){
                const nav = document.querySelector('.wf-nav');
                if(window.scrollY > 40){

                    nav.classList.add('scrolled');

                }else{

                    nav.classList.remove('scrolled');
                }
            });
        </script>
    </body>
</html>