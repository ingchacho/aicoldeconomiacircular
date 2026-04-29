<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>AICOLD – Saberes ancestrales para una economía más circular</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;1,400&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet"/>
 
    <style>
        :root {
        --verde:      #4a7c2f;
        --verde-btn:  #5cb85c;
        --verde-dark: #2d5a1b;
        --azul:       #1a3a6b;
        --texto:      #222;
        --gris-suave: #f5f5f5;
        --borde:      #ccc;
        }
    
        * { box-sizing: border-box; }
    
        body {
        font-family: 'Open Sans', sans-serif;
        color: var(--texto);
        margin: 0;
        }
    
        /* ───── NAVBAR ───── */
        .navbar-top {
        border-bottom: 1px solid var(--borde);
        padding: 14px 32px;
        }
    
        .navbar-top .logos {
        display: flex;
        align-items: center;
        gap: 24px;
        }
    
        .logo-ambiente {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--verde);
        letter-spacing: .5px;
        }
    
        .logo-fondo img,
        .logo-aicold img {
        height: 52px;
        object-fit: contain;
        }
    
        /* SVG placeholder logos */
        .logo-svg {
        height: 52px;
        display: flex;
        align-items: center;
        }
    
        .nav-links {
        display: flex;
        align-items: center;
        gap: 6px;
        }
    
        .nav-links a {
        padding: 5px 14px;
        border: 1px solid var(--borde);
        border-radius: 4px;
        text-decoration: none;
        color: var(--texto);
        font-size: .85rem;
        transition: background .2s;
        }
        .nav-links a:hover { background: var(--gris-suave); }
    
        .btn-iniciar {
        background: var(--verde-btn);
        color: #fff !important;
        border: none !important;
        padding: 7px 20px !important;
        font-weight: 600 !important;
        border-radius: 4px !important;
        }
        .btn-iniciar:hover { background: var(--verde-dark) !important; }
    
        /* ───── MODAL LOGIN ───── */
        .modal-header { border-bottom: 2px solid var(--verde); }
        .modal-title { color: var(--azul); font-weight: 700; }
        .btn-login-submit {
        background: var(--verde-btn);
        border: none;
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        font-weight: 600;
        border-radius: 4px;
        color: #fff;
        transition: background .2s;
        }
        .btn-login-submit:hover { background: var(--verde-dark); }
        .form-label { font-weight: 600; font-size: .9rem; }
    
        /* ───── HERO / SLIDER ───── */
        .hero-section {
        position: relative;
        min-height: 340px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid var(--borde);
        padding: 40px 0;
        overflow: hidden;
        }
    
        .hero-section .slide-content { max-width: 520px; }
    
        .hero-section h1 {
        font-family: 'Merriweather', serif;
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.3;
        color: var(--texto);
        margin-bottom: 18px;
        }
        .hero-section h1 em {
        font-style: italic;
        color: var(--verde-dark);
        }
    
        .hero-section p {
        font-size: .95rem;
        color: #444;
        line-height: 1.7;
        max-width: 420px;
        }
    
        .carousel-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        font-size: 2rem;
        color: #555;
        cursor: pointer;
        z-index: 10;
        padding: 0 10px;
        transition: color .2s;
        }
        .carousel-arrow:hover { color: var(--verde); }
        .carousel-arrow.left  { left: 0; }
        .carousel-arrow.right { right: 0; }
    
        /* ───── STAT CARDS ───── */
        .stats-row {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding: 28px 0 8px;
        }
    
        .stat-card {
        border: 1.5px solid var(--borde);
        border-radius: 8px;
        padding: 14px 22px;
        text-align: center;
        min-width: 110px;
        }
    
        .stat-card .number {
        font-weight: 700;
        font-size: 1.2rem;
        color: var(--azul);
        }
    
        .stat-card .label {
        font-size: .78rem;
        color: #555;
        }
    
        /* ───── INFO SECTIONS ───── */
        .info-section {
        padding: 60px 0;
        border-bottom: 1px solid #eee;
        }
    
        .info-section:nth-child(odd) { background: #fff; }
        .info-section:nth-child(even) { background: var(--gris-suave); }
    
        .info-section h2 {
        font-family: 'Open Sans', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--azul);
        margin-bottom: 18px;
        }
    
        .info-section p {
        font-size: .92rem;
        color: #444;
        line-height: 1.8;
        }
    
        .ver-mas {
        color: var(--verde-dark);
        font-weight: 700;
        text-decoration: none;
        font-size: .88rem;
        }
        .ver-mas:hover { text-decoration: underline; }
    
        /* Image placeholder */
        .img-placeholder {
        width: 100%;
        height: 200px;
        border: 1.5px solid var(--borde);
        border-radius: 10px;
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #bbb;
        font-size: 2.5rem;
        }
    
        /* ───── FOOTER ───── */
        footer {
        background: var(--gris-suave);
        border-top: 2px solid var(--verde);
        text-align: center;
        padding: 50px 20px;
        font-size: .88rem;
        color: #555;
        }
    
        footer strong { color: var(--azul); }
    
        /* ───── RESPONSIVE ───── */
        @media (max-width: 768px) {
        .navbar-top { padding: 12px 16px; flex-wrap: wrap; gap: 12px; }
        .hero-section h1 { font-size: 1.5rem; }
        .stats-row { justify-content: center; flex-wrap: wrap; }
        }
    </style>
</head>
<body>
 
<!-- ═══════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════ -->
<nav class="navbar-top d-flex justify-content-between align-items-center flex-wrap gap-3">
 
  <!-- Logos izquierda -->
    <div class="logos">
        <!-- Ambiente -->
    <div class="logo-ambiente">
        <svg width="90" height="52" viewBox="0 0 90 52">
            <!-- Escudo Colombia simplificado -->
            <rect x="0" y="8" width="40" height="36" rx="4" fill="#fff" stroke="#ddd" stroke-width="1"/>
            <rect x="0" y="8" width="40" height="12" rx="4" fill="#FCD116"/>
            <rect x="0" y="20" width="40" height="12" fill="#003893"/>
            <rect x="0" y="32" width="40" height="12" rx="4" fill="#CE1126"/>
            <text x="46" y="28" font-family="Open Sans,sans-serif" font-size="13" font-weight="700" fill="#4a7c2f">Ambiente</text>
            <line x1="46" y1="32" x2="86" y2="32" stroke="#FCD116" stroke-width="2.5"/>
            <line x1="46" y1="35" x2="86" y2="35" stroke="#003893" stroke-width="2.5"/>
            <line x1="46" y1="38" x2="86" y2="38" stroke="#CE1126" stroke-width="2.5"/>
        </svg>
    </div>
 
    <!-- Fondo para la Vida -->
    <div class="logo-svg">
        <svg width="110" height="52" viewBox="0 0 110 52">
            <ellipse cx="30" cy="26" rx="26" ry="22" fill="#e8f5e9"/>
            <text x="30" y="18" text-anchor="middle" font-size="18">🌿</text>
            <text x="62" y="18" font-family="Open Sans,sans-serif" font-size="8" font-weight="700" fill="#2d5a1b">Fondo</text>
            <text x="62" y="28" font-family="Open Sans,sans-serif" font-size="8" font-weight="700" fill="#2d5a1b">para la Vida</text>
            <text x="62" y="38" font-family="Open Sans,sans-serif" font-size="7" fill="#555">y la Biodiversidad</text>
        </svg>
    </div>
  </div>
 
  <!-- Nav links centro -->
    <div class="nav-links">
        <a href="#">Inicio</a>
        <a href="#">indicadores</a>
        <a href="#">Mapa territorial</a>
        <a href="#">contáctenos</a>
    </div>
 
  <!-- Logo AICOLD derecha + botón -->
    <div class="d-flex align-items-center gap-3">
        <svg width="110" height="52" viewBox="0 0 110 52">
        <text x="0" y="36" font-family="Open Sans,sans-serif" font-size="32" font-weight="900" fill="#1a3a6b" letter-spacing="-1">AIC</text>
        <circle cx="76" cy="26" r="14" fill="#4a7c2f"/>
        <text x="76" y="31" text-anchor="middle" font-size="13" fill="#fff">☯</text>
        <text x="92" y="36" font-family="Open Sans,sans-serif" font-size="32" font-weight="900" fill="#1a3a6b">LD</text>
        <text x="2" y="48" font-family="Open Sans,sans-serif" font-size="7.5" fill="#555">Asociación Intercultural Colombia Diversa</text>
        </svg>
 
        <!-- Botón Iniciar sesión → abre modal -->
        <button class="btn-iniciar nav-links a" data-bs-toggle="modal"      data-bs-target="#loginModal"
                    style="cursor:pointer; border-radius:4px; padding:7px 20px; font-weight:600; font-size:.85rem;">
            Iniciar sesión
        </button>
    </div>
</nav>
 
<!-- ═══════════════════════════════════════════
     MODAL INICIAR SESIÓN
═══════════════════════════════════════════ -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel"      aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
    
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">
                <i class="bi bi-person-circle me-2"></i>Iniciar sesión
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
    
         <div class="modal-body px-4 py-4">
    
            <!-- Logo dentro del modal -->
            <div class="text-center mb-4">
                <svg width="100" height="46" viewBox="0 0 110 52">
                    <text x="0" y="36" font-family="Open Sans,sans-serif" font-size="30" font-weight="900" fill="#1a3a6b" letter-spacing="-1">AIC</text>
                    <circle cx="70" cy="24" r="13" fill="#4a7c2f"/>
                    <text x="70" y="29" text-anchor="middle" font-size="12" fill="#fff">☯</text>
                    <text x="85" y="36" font-family="Open Sans,sans-serif" font-size="30" font-weight="900" fill="#1a3a6b">LD</text>
                </svg>
                <p class="text-muted mt-1" style="font-size:.82rem;">Plataforma de organizaciones étnicas</p>
            </div>
    
            <div class="mb-3">
                <label class="form-label" for="loginEmail">Correo electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="loginEmail" placeholder="correo@ejemplo.com"/>
                </div>
            </div>
    
            <div class="mb-4">
                <label class="form-label" for="loginPassword">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="loginPassword" placeholder="••••••••"/>
                    <button class="btn btn-outline-secondary" type="button" id="togglePwd">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
    
            <button class="btn-login-submit" type="button">Ingresar</button>
    
            <div class="text-center mt-3">
            <a href="#" style="font-size:.85rem; color:var(--verde-dark);">¿Olvidaste tu contraseña?</a>
            </div>
            <hr/>
            <div class="text-center" style="font-size:.82rem; color:#666;">
            ¿No tienes cuenta? <a href="#" style="color:var(--azul); font-weight:600;">Regístrate</a>
            </div>
        </div>
        </div>
    </div>
</div>
 
<!-- ═══════════════════════════════════════════
     HERO – SLIDER
═══════════════════════════════════════════ -->
<section class="container-fluid px-0" style="position:relative; border-bottom:1px solid #ddd;">
  <div class="container hero-section">
 
    <button class="carousel-arrow left" aria-label="Anterior">&#8249;</button>
 
    <div class="slide-content">
       <h1>Saberes ancestrales<br>para una <em>economía mas circular</em></h1>
        <p>Plataforma para la caracterización de organizaciones comunitarias
        afrocolombianas, indígenas, raizales y palenqueras que desarrollan
        emprendimientos en economía circular, gestión de residuos y negocios verdes.</p>
    </div>
 
    <button class="carousel-arrow right" aria-label="Siguiente">&#8250;</button>
  </div>
 
  <!-- Stats -->
    <div class="container">
        <div class="stats-row">
            <div class="stat-card">
                <div class="number">342</div>
                <div class="label">Organizaciones</div>
            </div>
            <div class="stat-card">
                <div class="number">7</div>
                <div class="label">Departamentos</div>
            </div>
            <div class="stat-card">
                <div class="number">10</div>
                <div class="label">Pueblos étnicos</div>
            </div>
            <div class="stat-card">
                <div class="number">187</div>
                <div class="label">Iniciativas verdes</div>
            </div>
        </div>
    </div>
</section>
 
<!-- ═══════════════════════════════════════════
     SECCIÓN 1 – ECONOMÍA CIRCULAR
═══════════════════════════════════════════ -->
<section class="info-section">
    <div class="container">
        <div class="row align-items-center g-5">
        
            <div class="col-md-5">
                <div class="img-placeholder">
                <i class="bi bi-recycle"></i>
                </div>
            </div>
    
            <div class="col-md-7">
                <h2>¿Qué es la ECONOMIA CIRCULAR?</h2>
                <p>La economía circular es una forma de pensar y organizar la producción y el
                consumo para que los recursos se utilicen de manera responsable y duren el
                mayor tiempo posible. En lugar de usar y desechar, la economía circular propone
                reparar, reutilizar y reciclar para minimizar los residuos y el impacto ambiental.</p>
                <a href="#" class="ver-mas">VER MÁS →</a>
            </div>
    
        </div>
    </div>
</section>
 
<!-- ═══════════════════════════════════════════
     SECCIÓN 2 – EDUCACIÓN AMBIENTAL
═══════════════════════════════════════════ -->
<section class="info-section">
    <div class="container">
        <div class="row align-items-center g-5">
    
            <div class="col-md-7">
                <h2>¿Qué es la EDUCACIÓN AMBIENTAL?</h2>
                <p>La educación ambiental es un proceso de aprendizaje que ayuda a comprender la
                relación entre las personas, la naturaleza y el territorio. Su objetivo es
                fortalecer la conciencia ambiental.</p>
                <a href="#" class="ver-mas">VER MÁS… →</a>
            </div>
        
            <div class="col-md-5">
                <div class="img-placeholder">
                <i class="bi bi-tree"></i>
                </div>
            </div>
        
        </div>
    </div>
</section>
 
<!-- ═══════════════════════════════════════════
     SECCIÓN 3 – NEGOCIOS VERDES
═══════════════════════════════════════════ -->
<section class="info-section">
    <div class="container">
        <div class="row align-items-center g-5">
    
            <div class="col-md-5">
                <div class="img-placeholder">
                <i class="bi bi-shop-window"></i>
                </div>
            </div>
        
            <div class="col-md-7">
                <h2>¿Qué es son NEGOCIOS VERDES?</h2>
                <p>Los negocios verdes son actividades económicas que generan ingresos sin dañar
                el ambiente. Se basan en el uso responsable de los recursos, la innovación y
                la sostenibilidad de los materiales.</p>
                <a href="#" class="ver-mas">VER MÁS… →</a>
            </div>
    
        </div>
    </div>
</section>
 
<!-- ═══════════════════════════════════════════
     SECCIÓN 4 – BASURA CERO
═══════════════════════════════════════════ -->
<section class="info-section">
    <div class="container">
        <div class="row align-items-center g-5">
    
            <div class="col-md-7">
                <h2>¿Qué es BASURA CERO?</h2>
                <p>Basura cero es un enfoque que busca reducir al máximo la cantidad de residuos
                que llegan a rellenos sanitarios o al ambiente. Promueve cambios en los hábitos
                diarios para evitar el desperdicio y fomentar el reciclaje y la reutilización.</p>
                <a href="#" class="ver-mas">VER MÁS… →</a>
            </div>
        
            <div class="col-md-5">
                <div class="img-placeholder">
                <i class="bi bi-trash2"></i>
                </div>
            </div>
 
        </div>
    </div>
</section>
 
<footer>
  <strong>AICOLD</strong> – Asociación Intercultural Colombia Diversa<br>
  <span>Plataforma apoyada por el Ministerio de Ambiente y el Fondo para la Vida y la Biodiversidad</span><br><br>
  <small>© 2025 AICOLD · Todos los derechos reservados</small>
</footer>
 
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 
<script>
  // Toggle mostrar/ocultar contraseña
  document.getElementById('togglePwd').addEventListener('click', function () {
    const pwd  = document.getElementById('loginPassword');
    const icon = document.getElementById('eyeIcon');
    if (pwd.type === 'password') {
      pwd.type = 'text';
      icon.className = 'bi bi-eye-slash';
    } else {
      pwd.type = 'password';
      icon.className = 'bi bi-eye';
    }
  });
</script>
 </body>
</html>