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

        </style>

    </head>

    <body>

        <?php
            // 🔥 INICIAR SESIÓN
            if (!session_id()) {
                session_start();
            }

            // 🔥 OBTENER USUARIO
            $user = $_SESSION['aec_user'] ?? null;
        ?>

        <header class="aec-header">
            <h2>AICOLD</h2>
        </header>

        <div class="aec-layout">
            <!-- SIDEBAR -->
            <aside class="aec-sidebar">
                <ul>
                    <!-- DASHBOARD -->
                    <li>
                        <a href="<?= site_url('/dashboard') ?>">
                            📊 Dashboard
                        </a>
                    </li>

                    <!-- KPIs DESPLEGABLE -->
                    <li class="aec-menu-parent">

                        <a href="javascript:void(0);" onclick="toggleSubmenu()" class="aec-menu-toggle">
                            📈 KPIs
                            <span id="aec-arrow">▼</span>
                        </a>

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

                    <!-- SOLO ADMIN -->
                    <?php if($user && $user['rol'] == 'ADMIN'): ?>

                        <li>
                            <a href="?modulo=organizaciones">
                                🏢 Organizaciones
                            </a>
                        </li>

                        <li>
                            <a href="?modulo=aspirantes">
                                👤 Aspirantes
                            </a>
                        </li>

                    <?php endif; ?>

                    <!-- LOGOUT -->
                    <li>
                        <a href="<?= admin_url('admin-ajax.php?action=aec_logout') ?>">
                            🚪 Cerrar sesión
                        </a>
                    </li>

                </ul>

            </aside>            

            <!-- CONTENIDO -->
            <main class="aec-content">
                <?php echo $contenido ?? ''; ?>
            </main>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function(){

                const submenu = document.getElementById("aec-submenu");

                submenu.style.display = "none";

            });
            function toggleSubmenu(){
                const submenu = document.getElementById("aec-submenu");
                const arrow = document.getElementById("aec-arrow");
                if(submenu.style.display === "block"){
                    submenu.style.display = "none";
                    arrow.innerHTML = "▼";

                }else{
                    submenu.style.display = "block";
                    arrow.innerHTML = "▲";
                }
            }
        </script>
    </body>
</html>