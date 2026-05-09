<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $titulo ?? 'Sistema AICOLD'; ?></title>


        <link rel="stylesheet" href="<?php echo AEC_URL . 'assets/css/style.css'; ?>">

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

                    <li>
                        <a href="<?= site_url('/kpi') ?>">
                            📈 KPI
                        </a>
                    </li>

                    <li>
                        <a href="<?= site_url('/dashboard') ?>">
                            📊 Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="?modulo=kpi-ambientales">
                            🌱 KPI Ambientales
                        </a>
                    </li>

                    <li>
                        <a href="?modulo=kpi-sociales">
                            👥 KPI Sociales
                        </a>
                    </li>

                    <li>
                        <a href="?modulo=kpi-economicos">
                            💰 KPI Económicos
                        </a>
                    </li>

                    <li>
                        <a href="?modulo=kpi-territoriales">
                            🗺️ KPI Territoriales
                        </a>
                    </li>

                    <li>
                        <a href="?modulo=kpi-digitales">
                            💻 KPI Digitales
                        </a>
                    </li>

                    <li>
                        <a href="?modulo=kpi-estrategicos">
                            🌍 KPI Estratégicos
                        </a>
                    </li>

                    <!-- 🔥 SOLO ADMIN -->
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

    </body>
</html>