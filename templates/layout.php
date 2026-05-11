<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $titulo ?? 'Sistema AICOLD'; ?></title>
        <link rel="stylesheet" href="<?php echo AEC_URL . 'assets/css/style.css'; ?>">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>

            /* =========================================
            SIDEBAR
            ========================================= */

            .aec-sidebar{
                width:260px;
                background:#111827;
                min-height:100vh;
                padding:20px 15px;
            }

            .aec-sidebar ul{
                list-style:none;
                margin:0;
                padding:0;
            }

            .aec-sidebar li{
                margin:0;
                padding:0;
            }

            /* LINKS */
            .aec-sidebar a{
                display:flex;
                justify-content:space-between;
                align-items:center;
                text-decoration:none;
                color:#fff;
                padding:12px 15px;
                border-radius:10px;
                margin-bottom:5px;
                transition:0.3s;
                font-size:14px;
            }

            .aec-sidebar a:hover{
                background:#1f2937;
            }

            /* =========================================
            SUBMENU
            ========================================= */

            .aec-submenu{
                display:none;
                margin-top:5px;
                padding-left:15px;
            }

            /* 🔥 ACTIVO */
            .aec-submenu.show{
                display:block;
            }

            /* HIJOS */
            .aec-submenu li a{
                background:#1f2937;
                font-size:13px;
                padding:10px 12px;
                margin-bottom:4px;
            }

            /* HOVER HIJOS */
            .aec-submenu li a:hover{
                background:#374151;
            }

            /* FLECHA */
            #aec-arrow{
                font-size:11px;
            }


            /* =========================================
            TOPBAR
            ========================================= */
            /* =========================================
            TOPBAR PREMIUM
            ========================================= */

            .aec-topbar{

                height:82px;

                background:rgba(255,255,255,.88);

                backdrop-filter:blur(14px);

                border-bottom:
                1px solid rgba(255,255,255,.4);

                display:flex;

                justify-content:space-between;

                align-items:center;

                padding:0 28px;

                box-shadow:
                0 10px 30px rgba(0,0,0,.05);

                position:sticky;

                top:0;

                z-index:999;
            }
            /* .aec-topbar{
                height:75px;
                background:#ffffff;
                border-bottom:1px solid #e5e7eb;

                display:flex;
                justify-content:space-between;
                align-items:center;

                padding:0 25px;

                box-shadow:0 2px 15px rgba(0,0,0,.05);
            } */

            /* BRAND */

            .aec-brand{

                display:flex;

                align-items:center;

                gap:20px;
            }
            /* .aec-brand{
                display:flex;
                align-items:center;
                gap:15px;
            } */

            .aec-logo{

                width:72px;

                transition:.3s;
            }

            .aec-logo:hover{

                transform:scale(1.05);
            }

            /* .aec-logo{
                width:55px;
            } */

            .aec-brand h2{
                margin:0;
                color:#166534;
                font-size:24px;
            }

            .aec-brand span{
                color:#64748b;
                font-size:13px;
            }

            /* USER AREA */

            .aec-user-area{
                display:flex;
                align-items:center;
            }

            /* USER BUTTON */

            .aec-user-trigger{
                display:flex;
                align-items:center;
                gap:12px;
                padding:10px 18px;
                border-radius:18px;
                cursor:pointer;
                transition:.3s;
                background:#f8fafc;
                border:
                1px solid rgba(0,0,0,.04);
            }

            /* .aec-user-trigger{
                display:flex;
                align-items:center;
                gap:10px;
                padding:10px 15px;
                border-radius:14px;
                cursor:pointer;
                transition:.3s;
            } */


            .aec-user-trigger:hover{
                background:#ffffff;
                transform:translateY(-2px);
                box-shadow:
                0 10px 25px rgba(0,0,0,.08);
            }

            /* .aec-user-trigger:hover{
                background:#f3f4f6;
            } */

                            
            .aec-user-trigger img{
                width:46px;
                height:46px;
                border-radius:50%;
                /* border:3px solid #22c55e; */
                object-fit:cover;
            }

            /* .aec-user-trigger img{
                width:42px;
                height:42px;
                border-radius:50%;
            } */

            /* DROPDOWN */

            .aec-user-dropdown{
                position:relative;
            }

            .aec-dropdown-menu{
                position:absolute;
                top:72px;
                right:0;
                width:340px;
                background:rgba(255,255,255,.92);
                backdrop-filter:blur(14px);
                border-radius:24px;
                padding:22px;
                box-shadow:
                0 20px 45px rgba(0,0,0,.15);
                border:
                1px solid rgba(255,255,255,.4);
                display:none;
                z-index:9999;
                animation:
                fadeDropdown .25s ease;
            }

            /* .aec-dropdown-menu{

                position:absolute;

                top:65px;
                right:0;

                width:320px;

                background:#fff;

                border-radius:18px;

                padding:20px;

                box-shadow:0 15px 35px rgba(0,0,0,.15);

                display:none;

                z-index:9999;
            } */

            .aec-dropdown-menu.show{
                display:block;
            }

            /* ITEMS */

            .aec-dropdown-menu h3{
                margin-top:10px;
                margin-bottom:10px;
            }

            .aec-dropdown-menu a{
                display:flex;
                align-items:center;
                gap:10px;
                padding:12px 14px;
                border-radius:14px;
                text-decoration:none;
                color:#334155;
                transition:.3s;
                font-size:14px;
            }

            /* .aec-dropdown-menu a{
                display:block;

                padding:10px 12px;

                border-radius:10px;

                text-decoration:none;

                color:#334155;

                transition:.3s;
            } */

            .aec-dropdown-menu a:hover{

                background:
                linear-gradient(
                    90deg,
                    #dcfce7,
                    #f0fdf4
                );

                color:#166534;

                transform:translateX(4px);
            }                
            /* .aec-dropdown-menu a:hover{
                background:#f1f5f9;
            } */

            .aec-dropdown-menu hr{
                border:none;
                border-top:1px solid #e5e7eb;
                margin:15px 0;
            }

            /* .logout{
                background:#fee2e2;
                color:#b91c1c !important;
            } */

            .logout{

                background:#fee2e2;
                color:#b91c1c !important;
                font-weight:600;
            }


            @keyframes fadeDropdown{
                from{
                    opacity:0;
                    transform:
                    translateY(-10px);
                }
                to{
                    opacity:1;
                    transform:
                    translateY(0);
                }
            }




            /* =========================================
            SIDEBAR PREMIUM
            ========================================= */

            .aec-sidebar{

                width:280px;
                min-height:100vh;

                background:linear-gradient(
                    180deg,
                    #0f172a 0%,
                    #111827 100%
                );

                padding:20px 15px;

                color:#fff;

                box-shadow:
                10px 0 30px rgba(0,0,0,.08);

                overflow-y:auto;
            }

            /* BRAND */

            .aec-sidebar-brand{

                display:flex;
                align-items:center;
                gap:15px;

                padding:10px 10px 25px;

                border-bottom:
                1px solid rgba(255,255,255,.08);

                margin-bottom:20px;
            }

            .aec-sidebar-brand img{
                width:50px;
            }

            .aec-sidebar-brand h3{
                margin:0;
                font-size:20px;
                color:#fff;
            }

            .aec-sidebar-brand span{
                font-size:12px;
                color:#94a3b8;
            }

            /* MENU */

            .aec-menu{
                list-style:none;
                padding:0;
                margin:0;
            }

            /* LINKS */

            .aec-link{

                display:flex;
                justify-content:space-between;
                align-items:center;

                padding:14px 16px;

                margin-bottom:8px;

                border-radius:14px;

                color:#e2e8f0;
                text-decoration:none;

                transition:.3s;

                font-size:14px;
            }

            /* HOVER */

            .aec-link:hover{

                background:
                linear-gradient(
                    90deg,
                    #166534,
                    #15803d
                );

                transform:translateX(4px);

                color:#fff;
            }

            /* ACTIVE */

            .aec-link.active{

                background:
                linear-gradient(
                    90deg,
                    #166534,
                    #22c55e
                );

                color:#fff;

                box-shadow:
                0 10px 20px rgba(34,197,94,.25);
            }

            /* ICONOS */

            .aec-link span{
                margin-right:10px;
            }

            /* SUBMENU */

            .aec-submenu{

                display:none;

                margin-top:5px;
                margin-left:15px;

                padding-left:10px;

                border-left:
                2px solid rgba(255,255,255,.08);
            }

            /* SHOW */

            .aec-submenu.show{
                display:block;
            }

            /* ITEMS SUBMENU */

            .aec-submenu li a{

                display:block;

                padding:10px 14px;

                margin-bottom:5px;

                border-radius:10px;

                color:#cbd5e1;

                text-decoration:none;

                font-size:13px;

                transition:.3s;
            }

            .aec-submenu li a:hover{

                background:rgba(255,255,255,.08);

                color:#fff;

                padding-left:18px;
            }

            /* FLECHA */

            #aec-arrow{
                font-size:11px;
                transition:.3s;
            }            


            /* =========================================
            BODY PREMIUM
            ========================================= */

            .aec-body{

                background:
                linear-gradient(
                    135deg,
                    #f1f5f9 0%,
                    #e2e8f0 100%
                );

                min-height:100vh;
            }

            /* =========================================
            LAYOUT
            ========================================= */

            .aec-layout{
                display:flex;
                min-height:100vh;
            }

            /* =========================================
            CONTENIDO
            ========================================= */

            .aec-content{

                flex:1;

                padding:30px;

                overflow-y:auto;
            }

            /* =========================================
            CONTENEDOR GENERAL
            ========================================= */

            .aec-container{

                background:rgba(255,255,255,.75);

                backdrop-filter:blur(10px);

                border-radius:24px;

                padding:30px;

                box-shadow:
                0 10px 30px rgba(0,0,0,.08);

                border:
                1px solid rgba(255,255,255,.4);
            }

            /* =========================================
            TÍTULOS
            ========================================= */

            .aec-container h1,
            .aec-container h2{

                margin-top:0;

                color:#0f172a;

                font-weight:700;

                margin-bottom:25px;
            }

            /* =========================================
            KPIs MODERNOS
            ========================================= */

            .kpi-modern-grid{

                display:grid;

                grid-template-columns:
                repeat(auto-fit,minmax(220px,1fr));

                gap:20px;

                margin-bottom:30px;
            }

            /* =========================================
            CARD KPI
            ========================================= */

            .kpi-card{

                position:relative;

                overflow:hidden;

                border-radius:22px;

                padding:24px;

                color:#fff;

                min-height:140px;

                box-shadow:
                0 10px 25px rgba(0,0,0,.12);

                transition:.3s;
            }

            /* HOVER */

            .kpi-card:hover{

                transform:
                translateY(-6px);

                box-shadow:
                0 20px 35px rgba(0,0,0,.18);
            }

            /* ICONO */

            .kpi-card .icon{

                font-size:42px;

                opacity:.9;

                margin-bottom:15px;
            }

            /* TÍTULO */

            .kpi-card h3{

                margin:0;

                font-size:15px;

                font-weight:600;
            }

            /* VALOR */

            .kpi-card p{

                font-size:42px;

                font-weight:bold;

                margin:15px 0 0;
            }

            /* =========================================
            COLORES KPI
            ========================================= */

            .kpi-card.green{
                background:
                linear-gradient(
                    135deg,
                    #16a34a,
                    #22c55e
                );
            }

            .kpi-card.blue{
                background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6
                );
            }

            .kpi-card.orange{
                background:
                linear-gradient(
                    135deg,
                    #ea580c,
                    #f97316
                );
            }

            .kpi-card.purple{
                background:
                linear-gradient(
                    135deg,
                    #7c3aed,
                    #8b5cf6
                );
            }

            /* =========================================
            GRÁFICOS
            ========================================= */

            .aec-chart-grid-4{

                display:grid;

                grid-template-columns:
                repeat(4,1fr);

                gap:18px;

                margin-top:20px;
            }

            /* CARD GRÁFICO */

            .aec-chart-card{

                background:#fff;

                border-radius:22px;

                padding:18px;

                box-shadow:
                0 5px 20px rgba(0,0,0,.08);

                height:320px;

                transition:.3s;
            }

            /* HOVER */

            .aec-chart-card:hover{

                transform:
                translateY(-4px);

                box-shadow:
                0 15px 30px rgba(0,0,0,.12);
            }

            /* TÍTULO */

            .aec-chart-card h3{

                margin-top:0;

                font-size:15px;

                margin-bottom:15px;

                color:#0f172a;
            }

            /* CANVAS */

            .aec-chart-card canvas{

                width:100% !important;
                height:240px !important;
            }

            /* =========================================
            TABLAS PREMIUM
            ========================================= */

            table{

                width:100%;

                border-collapse:collapse;

                background:#fff;

                border-radius:18px;

                overflow:hidden;

                box-shadow:
                0 5px 20px rgba(0,0,0,.08);
            }

            table thead{

                background:
                linear-gradient(
                    90deg,
                    #166534,
                    #15803d
                );

                color:#fff;
            }

            table th{

                padding:16px;

                text-align:left;
            }

            table td{

                padding:14px;

                border-bottom:
                1px solid #e5e7eb;
            }

            table tr:hover{

                background:#f8fafc;
            }

            /* =========================================
            BOTONES
            ========================================= */

            .aec-btn,
            .btn-primary{

                background:
                linear-gradient(
                    90deg,
                    #166534,
                    #22c55e
                );

                color:#fff;

                border:none;

                border-radius:12px;

                padding:12px 18px;

                text-decoration:none;

                font-weight:600;

                transition:.3s;

                display:inline-block;
            }

            .aec-btn:hover,
            .btn-primary:hover{

                transform:
                translateY(-2px);

                box-shadow:
                0 10px 20px rgba(34,197,94,.25);
            }

            /* =========================================
            RESPONSIVE
            ========================================= */

            @media(max-width:1200px){

                .aec-chart-grid-4{
                    grid-template-columns:repeat(2,1fr);
                }
            }

            @media(max-width:768px){

                .aec-layout{
                    flex-direction:column;
                }

                .aec-sidebar{
                    width:100%;
                    min-height:auto;
                }

                .aec-chart-grid-4{
                    grid-template-columns:1fr;
                }

                .kpi-modern-grid{
                    grid-template-columns:1fr;
                }

                .aec-content{
                    padding:15px;
                }
            }


/* =========================================
DARK MODE
========================================= */

body{
    transition:.3s;
}

/* BODY */

.dark-mode{
    background:#0f172a;
    color:#f1f5f9;
}

/* TOPBAR */

.dark-mode .aec-topbar{
    background:#111827;
    border-bottom:1px solid #1e293b;
}

/* SIDEBAR */

.dark-mode .aec-sidebar{
    background:#020617;
}

/* CONTENT */

.dark-mode .aec-content{
    background:#0f172a;
}

/* CARDS */

.dark-mode .aec-home-card,
.dark-mode .kpi-card,
.dark-mode .aec-chart-card,
.dark-mode .aec-chart-box{

    background:#111827 !important;
    color:#f1f5f9;

    box-shadow:0 10px 25px rgba(0,0,0,.4);
}

/* DROPDOWN */

.dark-mode .aec-dropdown-menu{
    background:#111827;
    color:white;
}

.dark-mode .aec-dropdown-menu a{
    color:#f1f5f9;
}

.dark-mode .aec-dropdown-menu a:hover{
    background:#1e293b;
}

/* TABLES */

.dark-mode table{
    background:#111827;
    color:white;
}

.dark-mode table th{
    background:#166534;
}

.dark-mode table td{
    border-color:#1e293b;
}

/* INPUTS */

.dark-mode input,
.dark-mode select,
.dark-mode textarea{

    background:#1e293b;
    border:1px solid #334155;
    color:white;
}

/* TITLES */

.dark-mode h1,
.dark-mode h2,
.dark-mode h3,
.dark-mode h4{
    color:white;
}

/* LINKS */

.dark-mode a{
    color:#cbd5e1;
}

/* HERO */

.dark-mode .aec-home-hero{
    background:linear-gradient(135deg,#14532d,#166534);
}

/* TRANSICIÓN */

.dark-mode *{
    transition:.25s;
}


        </style>
    </head>

    <body class="aec-body" id="aec-body">
        <?php
            // 🔥 INICIAR SESIÓN
            if (!session_id()) {
                session_start();
            }

            // 🔥 OBTENER USUARIO
            $user = $_SESSION['aec_user'] ?? null;
        ?>

        <header class="aec-topbar">
            <!-- LOGO -->
            <div class="aec-brand">
                <img src="<?php echo AEC_URL . 'assets/img/3.png'; ?>"  alt="AICOLD" class="aec-logo" style="width: 80px;">
                <img src="<?php echo AEC_URL . 'assets/img/5.png'; ?>"  alt="AICOLD" class="aec-logo" style="width: 80px;">                                
                <img src="<?php echo AEC_URL . 'assets/img/1.png'; ?>"  alt="AICOLD" class="aec-logo" style="width: 80px;">
            </div>

            <!-- USUARIO -->
            <div class="aec-user-area">
                <div class="aec-user-dropdown">
                    <!-- BOTON -->
                    <div class="aec-user-trigger" onclick="toggleUserMenu()">
                        <img 
                            src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                            alt="Usuario"
                        >
                        <span>
                            <?= $user['nombre'] ?? 'Mi cuenta' ?>
                        </span>
                    </div>

                    <!-- MENU -->
                    <div id="aec-user-menu" class="aec-dropdown-menu">

                        <h3>👤 Mi cuenta</h3>

                        <a href="?modulo=mi-perfil">
                            Ver Perfil
                        </a>

                        <a href="?modulo=editar-perfil">
                            Editar información personal
                        </a>

                        <a href="?modulo=avatar">
                            Imagen / Avatar
                        </a>

                        <hr>

                        <h3>⚙️ Configuración</h3>

                        <a href="?modulo=cambiar-password">
                            Cambiar contraseña
                        </a>

                        <a href="?modulo=configuracion">
                            Actualizar datos personales
                        </a>

                        <a href="?modulo=notificaciones">
                            Configuración de notificaciones
                        </a>
                        <hr>
                        <h3>🌗 Modo visual</h3>
                        <a href="javascript:void(0)" onclick="setTheme('light')">
                            ☀️ Modo claro
                        </a>
                        <a href="javascript:void(0)" onclick="setTheme('dark')">
                            🌙 Modo oscuro
                        </a>
                        <hr>
                        <a 
                            href="<?= admin_url('admin-ajax.php?action=aec_logout') ?>"class="logout">🚪 Cerrar sesión
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <div class="aec-layout">
            <!-- SIDEBAR -->
           <aside class="aec-sidebar">
                <!-- LOGO MINI -->
                <div class="aec-sidebar-brand">
                    <div>
                        <h3>Panel Administrativo</h3>
                        <span></span>
                    </div>
                </div>
                <!-- MENÚ -->
                <ul class="aec-menu">
                    <!-- DASHBOARD -->
                    <li>
                        <a href="<?= site_url('/dashboard') ?>" class="aec-link">
                            <span>📊</span>
                            Dashboard
                        </a>
                    </li>

                    <!-- ORGANIZACIONES -->
                    <li>
                        <a href="?modulo=organizaciones" class="aec-link">
                            <span>🏢</span>
                            Organizaciones
                        </a>
                    </li>

                    <!-- KPIs -->
                    <li class="aec-menu-parent">

                        <a 
                            href="javascript:void(0);" 
                            onclick="toggleSubmenu()" 
                            class="aec-link aec-menu-toggle"
                        >
                            <div>
                                <span>📈</span>
                                KPIs
                            </div>

                            <span id="aec-arrow">
                                ▼
                            </span>
                        </a>

                        <!-- SUBMENU -->
                        <ul id="aec-submenu" class="aec-submenu">

                            <li>
                                <a href="?modulo=kpi-ambientales">
                                    🌱 Ambientales
                                </a>
                            </li>

                            <li>
                                <a href="?modulo=kpi-sociales">
                                    👥 Sociales
                                </a>
                            </li>

                            <li>
                                <a href="?modulo=kpi-economicos">
                                    💰 Económicos
                                </a>
                            </li>

                            <li>
                                <a href="?modulo=kpi-territoriales">
                                    🗺️ Territoriales
                                </a>
                            </li>

                            <li>
                                <a href="?modulo=kpi-digitales">
                                    💻 Digitales
                                </a>
                            </li>

                            <li>
                                <a href="?modulo=kpi-estrategicos">
                                    🌍 Estratégicos
                                </a>
                            </li>

                        </ul>

                    </li>

                    <!-- ADMIN -->
                    <?php if($user && $user['rol'] == 'ADMIN'): ?>
                        <li>
                            <a href="?modulo=aspirantes" class="aec-link">
                                <span>👤</span>
                                Aspirantes
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
           </aside>      
            <!-- CONTENIDO -->
            <main class="aec-content">
                <?php echo $contenido ?? ''; ?>
            </main>
        </div>

        <script>
           function toggleSubmenu(){
                const submenu = document.getElementById('aec-submenu');
                const arrow = document.getElementById('aec-arrow');
                submenu.classList.toggle('show');

                if(submenu.classList.contains('show')){
                    arrow.style.transform = 'rotate(180deg)';
                }else{
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
        </script>

        <script>
            function toggleUserMenu(){
                const menu = document.getElementById('aec-user-menu');
                menu.classList.toggle('show');
            }
            window.addEventListener('click', function(e){
                const dropdown = document.querySelector('.aec-user-dropdown');
                if(!dropdown.contains(e.target)){
                    document.getElementById('aec-user-menu').classList.remove('show');
                }
            });
        </script>

<script>

/* =========================================
CAMBIAR TEMA
========================================= */

function setTheme(mode){

    const body = document.getElementById('aec-body');

    if(mode === 'dark'){

        body.classList.add('dark-mode');

        localStorage.setItem('aec_theme', 'dark');

    }else{

        body.classList.remove('dark-mode');

        localStorage.setItem('aec_theme', 'light');
    }
}

/* =========================================
CARGAR TEMA GUARDADO
========================================= */

document.addEventListener("DOMContentLoaded", function(){

    const theme = localStorage.getItem('aec_theme');

    if(theme === 'dark'){
        document.getElementById('aec-body')
            .classList.add('dark-mode');
    }

});

</script>


    </body>
</html>