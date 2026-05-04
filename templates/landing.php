<?php
/*
Template Name: Landing Limpia
*/
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>AICOLD</title>


        <?php wp_head(); ?>

        <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700;900&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,700;0,9..144,900;1,9..144,300&family=DM+Sans:wght@300;400;500;600&display=swap');
            :root {
                --tierra: #8B4513;
                --verde-selva: #2D5016;
                --verde-medio: #4A7C23;
                --verde-claro: #7AB648;
                --ocre: #C8851A;
                --arena: #F5E6C8;
                --crema: #FAF6EF;
                --negro: #1A1008;
                --gris-calido: #6B5B4E;
                --blanco: #FFFFFF;
                --acento: #E8531A;
                --agua: #2A7090;
                --wireframe-bg: #F0EBE0;
                --wireframe-border: #C8B89A;
                --wireframe-dark: #3D2E1E;
                --wireframe-mid: #8B7355;
                --wireframe-light: #D4C4A8;
                --wireframe-accent: #8B4513;
                --wireframe-green: #4A7C23;
                --wireframe-blue: #2A7090;
            }

            * { margin: 0; padding: 0; box-sizing: border-box; }

             header, .site-header, .site-footer {
                display: none !important;
            }


            body {
                font-family: 'DM Sans', sans-serif;
                background: #E8E0D0;
                color: var(--wireframe-dark);
                min-height: 100vh;
            }


            /* ══════════════════════════════════════
                CANVAS PRINCIPAL
            ══════════════════════════════════════ */
            .canvas-area {
                padding-top: 10px;
                display: flex;
                justify-content: center;
                align-items: flex-start;
                min-height: 100vh;
                padding-bottom: 60px;
            }


            .device-frame {
                background: #D4CAB8;
                border-radius: 8px;
                overflow: hidden;
                transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
                box-shadow: 0 20px 60px rgba(0,0,0,0.3), 0 4px 12px rgba(0,0,0,0.2);
                position: relative;
            }

            .device-frame.desktop { width: 1280px; max-width: 98vw; }
            .device-frame.tablet { width: 768px; max-width: 95vw; }
            .device-frame.mobile { width: 375px; max-width: 92vw; }

            /* Device chrome */
            .device-chrome {
                background: #2A2218;
                padding: 8px;
                display: flex;
                align-items: center;
                gap: 6px;
            }
            .chrome-dot { width: 8px; height: 8px; border-radius: 50%; }
            .chrome-dot:nth-child(1) { background: #FF5F57; }
            .chrome-dot:nth-child(2) { background: #FEBC2E; }
            .chrome-dot:nth-child(3) { background: #28C840; }
            .chrome-url {
                flex: 1;
                background: #3D2E1E;
                border-radius: 3px;
                padding: 3px 10px;
                font-size: 10px;
                color: #8B7355;
                font-family: monospace;
            }

            /* ══════════════════════════════════════
            WIREFRAME: MICROSITIO
            ══════════════════════════════════════ */
            .microsite {
                background: var(--wireframe-bg);
                width: 100%;
            }

            /* --- NAV FIJO --- */
            .wf-nav {
                /* background: var(--wireframe-dark); */
                padding: 0 32px;
                display: flex;
                align-items: center;
                height: 110px;
                gap: 24px;
                position: sticky;
                top: 0;
                z-index: 100;
                border-bottom: 3px solid var(--wireframe-accent);
                /* background-color: aliceblue; */
            }

            .wf-nav .logo-area {
                display: block;
                align-items: center;
                gap: 10px;
                flex-shrink: 0;
            }

            .wf-nav-links {
                display: flex;
                gap: 4px;
                align-items: center;
                flex: 1;
            }

            .wf-nav-link {
                /* color: var(--wireframe-light); */
                color:#3D2E1E;
                font-size: 12px;
                padding: 6px 12px;
                border-radius: 3px;
                cursor: pointer;
                transition: all 0.2s;
                white-space: nowrap;
            }
            .wf-nav-link:hover, .wf-nav-link.active {
                background: rgba(255,255,255,0.08);
                color: var(--verde-claro);
            }

            .wf-nav-actions {
                display: flex;
                gap: 8px;
                align-items: center;
                margin-left: auto;
                flex-shrink: 0;
            }

            .wf-btn-outline {
                border: 1.5px solid var(--wireframe-mid);
                color: var(--wireframe-light);
                padding: 7px 14px;
                font-size: 11px;
                font-family: 'DM Sans', sans-serif;
                border-radius: 3px;
                cursor: pointer;
                background: #28C840;
                transition: all 0.2s;
                white-space: nowrap;
            }
            .wf-btn-primary {
                border: none;
                background: var(--wireframe-accent);
                color: white;
                padding: 7px 16px;
                font-size: 11px;
                font-family: 'DM Sans', sans-serif;
                border-radius: 3px;
                cursor: pointer;
                transition: all 0.2s;
                white-space: nowrap;
                font-weight: 600;
            }
            .wf-btn-primary:hover { background: #A03010; }

            .wf-hamburger {
                display: none;
                flex-direction: column;
                gap: 4px;
                cursor: pointer;
                margin-left: auto;
            }
            .wf-hamburger span { display: block; width: 22px; height: 2px; background: var(--wireframe-light); border-radius: 1px; }

            /* --- HERO --- */
            .wf-hero {
                background: linear-gradient(135deg, #1A2E0A 0%, #2D5016 40%, #3D6820 70%, #8B4513 100%);
                padding: 80px 32px;
                position: relative;
                overflow: hidden;
                min-height: 520px;
                display: flex;
                align-items: center;
            }

            .hero-pattern {
                position: absolute; inset: 0;
                background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255,255,255,0.02) 20px, rgba(255,255,255,0.02) 40px),
                repeating-linear-gradient(-45deg, transparent, transparent 20px, rgba(255,255,255,0.015) 20px, rgba(255,255,255,0.015) 40px);
            }

            .hero-circles {
                position: absolute;
                right: -60px; top: -60px;
                width: 420px; height: 420px;
                border-radius: 50%;
                border: 40px solid rgba(122, 182, 72, 0.08);
                box-shadow: 0 0 0 80px rgba(122,182,72,0.04);
            }

            .hero-content {
                position: relative;
                max-width: 680px;
                z-index: 2;
            }

            .hero-eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: rgba(122,182,72,0.15);
                border: 1px solid rgba(122,182,72,0.3);
                border-radius: 2px;
                padding: 5px 12px;
                margin-bottom: 24px;
            }
            .hero-eyebrow .dot { width: 6px; height: 6px; background: var(--verde-claro); border-radius: 50%; }
            .hero-eyebrow span { color: var(--verde-claro); font-size: 11px; letter-spacing: 0.12em; text-transform: uppercase; font-weight: 500; }

            .hero-title {
                font-family: 'Fraunces', serif;
                color: var(--arena);
                font-size: clamp(28px, 4vw, 52px);
                font-weight: 900;
                line-height: 1.05;
                margin-bottom: 20px;
                letter-spacing: -0.02em;
            }
            .hero-title em {
                font-style: italic;
                color: var(--verde-claro);
            }

            .hero-desc {
                color: rgba(245,230,200,0.7);
                font-size: 15px;
                line-height: 1.7;
                margin-bottom: 36px;
                max-width: 520px;
            }

            .hero-ctas {
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
            }

            .cta-primary {
                background: var(--wireframe-accent);
                color: white;
                padding: 14px 28px;
                font-size: 13px;
                font-weight: 600;
                border: none;
                border-radius: 3px;
                cursor: pointer;
                display: flex; align-items: center; gap: 8px;
                letter-spacing: 0.02em;
            }
            .cta-secondary {
                background: transparent;
                color: var(--arena);
                padding: 14px 28px;
                font-size: 13px;
                font-weight: 500;
                border: 1.5px solid rgba(245,230,200,0.4);
                border-radius: 3px;
                cursor: pointer;
                display: flex; align-items: center; gap: 8px;
            }

            .hero-stats {
                position: absolute;
                right: 32px;
                bottom: 40px;
                display: flex;
                gap: 2px;
                z-index: 2;
            }

            .stat-card {
                background: rgba(26,16,8,0.6);
                backdrop-filter: blur(8px);
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 4px;
                padding: 16px 20px;
                text-align: center;
                min-width: 110px;
            }
            .stat-card .num {
                font-family: 'Fraunces', serif;
                color: var(--verde-claro);
                font-size: 26px;
                font-weight: 900;
                line-height: 1;
                display: block;
            }
            .stat-card .lbl {
                color: rgba(245,230,200,0.6);
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                margin-top: 4px;
                display: block;
            }

                /* Scroll hint */
            .scroll-hint {
                position: absolute;
                bottom: 20px; left: 50%; transform: translateX(-50%);
                background: rgba(0,0,0,0.4);
                color: white;
                padding: 6px 14px; border-radius: 20px;
                font-size: 10px;
                display: flex; align-items: center; gap: 6px;
                animation: bounce 2s infinite;
                pointer-events: none;
                z-index: 10;
            }


            /* --- SECCIONES PRINCIPALES --- */
            .wf-section {
                padding: 56px 32px;
            }
            .wf-section.alt-bg {
                background: rgba(45,80,22,0.04);
            }
            .wf-section.dark-bg {
                background: var(--wireframe-dark);
            }

            .section-header {
                display: flex;
                align-items: flex-end;
                justify-content: space-between;
                margin-bottom: 36px;
                gap: 20px;
                flex-wrap: wrap;
            }

            .section-label {
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 0.14em;
                font-weight: 600;
                margin-bottom: 6px;
            }
            .section-label.green { color: var(--wireframe-green); }
            .section-label.earth { color: var(--wireframe-accent); }
            .section-label.blue { color: var(--wireframe-blue); }

            .section-title {
                font-family: 'Fraunces', serif;
                font-size: clamp(22px, 3vw, 36px);
                font-weight: 700;
                color: var(--wireframe-dark);
                line-height: 1.15;
                letter-spacing: -0.02em;
            }
            .section-title.light { color: var(--arena); }

            .section-desc {
                color: var(--wireframe-mid);
                font-size: 14px;
                line-height: 1.65;
                max-width: 460px;
                margin-top: 8px;
            }
            .section-desc.light { color: rgba(245,230,200,0.65); }

            .view-all {
                color: var(--wireframe-green);
                font-size: 12px;
                font-weight: 600;
                cursor: pointer;
                display: flex; align-items: center; gap: 5px;
                white-space: nowrap;
                border: 1px solid rgba(74,124,35,0.3);
                padding: 8px 16px;
                border-radius: 3px;
            }


            /* GRID */
            .section {
             padding: 40px;
            }

            .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            }

            /* CARD */
            .card {
            background: white;
            border: 1px solid #D4C4A8;
            padding: 16px;
            width: 300px;
            }

            .card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            margin-bottom: 10px;
            }

            .card h3 {
            font-family: 'Fraunces', serif;
            font-size: 14px;
            margin-bottom: 8px;
            }

            .card p {
            font-size: 12px;
            color: #6B5B4E;
            }

            /* --- FOOTER --- */
            .wf-footer {
                background: #0D0804;
                border-top: 3px solid var(--wireframe-accent);
                padding: 48px 32px 24px;
            }

            .footer-grid {
                display: grid;
                grid-template-columns: 2fr 1fr 1fr 1fr;
                gap: 40px;
                margin-bottom: 40px;
            }

            .footer-brand .logo-area {
                display: flex; align-items: center; gap: 10px; margin-bottom: 16px;
            }
            .footer-brand p { font-size: 12px; color: rgba(245,230,200,0.5); line-height: 1.65; max-width: 300px; }

            .footer-col h4 {
                font-family: 'Fraunces', serif;
                color: var(--arena);
                font-size: 14px; font-weight: 700;
                margin-bottom: 14px;
            }
            .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 8px; }
            .footer-col ul li { font-size: 12px; color: rgba(245,230,200,0.45); cursor: pointer; }
            .footer-col ul li:hover { color: var(--verde-claro); }

            .footer-bottom {
                border-top: 1px solid rgba(255,255,255,0.06);
                padding-top: 20px;
                display: flex; justify-content: space-between; align-items: center;
                flex-wrap: wrap; gap: 12px;
            }
            .footer-bottom p { font-size: 11px; color: rgba(245,230,200,0.3); }
            .footer-social { display: flex; gap: 8px; }
            .social-btn {
                width: 30px; height: 30px;
                background: rgba(255,255,255,0.05);
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 3px;
                display: flex; align-items: center; justify-content: center;
                cursor: pointer; color: rgba(245,230,200,0.4);
                font-size: 11px;
                transition: all 0.2s;
            }
            .social-btn:hover { background: var(--wireframe-accent); border-color: var(--wireframe-accent); color: white; }

            .accessibility-bar {
                border-top: 1px solid rgba(255,255,255,0.04);
                padding-top: 16px;
                margin-top: 16px;
                display: flex;
                align-items: center;
                gap: 16px;
                flex-wrap: wrap;
            }
            .a11y-label { font-size: 10px; color: rgba(245,230,200,0.25); letter-spacing: 0.1em; text-transform: uppercase; }
            .a11y-btns { display: flex; gap: 6px; }
            .a11y-btn {
                padding: 4px 10px;
                font-size: 10px;
                background: transparent;
                border: 1px solid rgba(255,255,255,0.1);
                color: rgba(245,230,200,0.35);
                border-radius: 2px;
                cursor: pointer;
            }
            .a11y-btn:hover { border-color: var(--wireframe-green); color: var(--verde-claro); }

        </style>
    </head>

    <body>
        <div class="canvas-area">        
            <div class="device-frame desktop" id="deviceFrame">
                <div class="microsite">
                    <nav class="wf-nav">
                        <div class="logo-area">
                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/3.png" style="width:120px;">
                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/5.png" style="width:120px;">
                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/1.png" style="width:120px;">
      
                        </div>                        
                        <div class="wf-nav-links">
                        <div class="wf-nav-link active">Inicio</div>
                        <div class="wf-nav-link">Indicadores</div>
                        <div class="wf-nav-link">Mapa territorial</div>
                        <div class="wf-nav-link">Contactenos</div>
                        </div>
                        
                        <div class="wf-nav-actions">            
                            <a href="/aicold/wordpress-6.9.4/wordpress/login/" class="wf-btn-outline">
                                Iniciar Sesión
                            </a>
                        </div>
                        <div class="wf-hamburger">
                        <span></span><span></span><span></span>
                        </div>
                    </nav>

                    <!-- ══ SECCIÓN: HERO ══ -->
                    <div class="wf-section-block" id="s-hero">
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
                                <button class="cta-primary">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                                    Explorar organizaciones
                                </button>
                                <button class="cta-secondary">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                                    Registrar mi organización
                                </button>
                                </div>
                            </div>
                    
                            <div class="hero-stats">
                                <div class="stat-card">
                                <span class="num">342</span>
                                <span class="lbl">Organizaciones</span>
                                </div>
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

                            <div class="scroll-hint">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                                Deslizar para explorar
                            </div>
                        </section>
                    </div>            

                    <!-- CARDS -->
                    <div class="section">
                        <div class="grid">

                            <div class="card">
                                <img src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6">
                                <h3>¿Qué es la economía circular?</h3>
                                <p>Modelo que busca reducir residuos y reutilizar recursos.</p>
                            </div>

                            <div class="card">
                                <img src="2.png">
                                <h3>Educación ambiental</h3>
                                <p>Programas de formación en sostenibilidad.</p>
                            </div>

                            <div class="card">
                                <img src="https://infoamazonia.org/wp-content/uploads/2018/01/20160823150843-verde.jpeg">
                                <h3>Negocios verdes</h3>
                                <p>Iniciativas sostenibles con impacto positivo.</p>
                            </div>

                            <div class="card">
                                <img src="https://flaviomontes.wordpress.com/2013/01/14/definicion-de-basura-cero/">
                                <h3>Industria circular</h3>
                                <p>Procesos productivos responsables.</p>
                            </div>

                        </div>
                    </div>

                    <!-- FOOTER -->
                    <footer class="wf-footer">
                        <div class="footer-grid">
                        <div class="footer-brand">
                            <div class="logo-area">
                            <img src="/wp-content/plugins/aicoldeconomiacircular/assets/images/logos/logo-aicold-3.png" style="width:100px;">        
                            <img src="/wp-content/plugins/aicoldeconomiacircular/assets/images/logos/logo-aicold-5.png" style="width:100px;">
                            <img src="/wp-content/plugins/aicoldeconomiacircular/assets/images/logos/logo-aicold-1.png" style="width:100px;">
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
            </div><!-- /device-frame -->    
        </div><!-- /canvas-area -->    
    </body>
</html>