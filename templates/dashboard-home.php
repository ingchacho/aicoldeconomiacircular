<?php

if (!session_id()) {
    session_start();
}

$user = $_SESSION['aec_user'] ?? null;

global $wpdb;

$tabla = $wpdb->prefix . 'organizaciones';

/* =========================================
KPIs EJECUTIVOS
========================================= */

$total_org = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
");

$total_residuos = $wpdb->get_var("
    SELECT COUNT(*)
    FROM $tabla
    WHERE usa_residuos = 'SI'
");

$total_mujeres = $wpdb->get_var("
    SELECT COUNT(*)
    FROM $tabla
    WHERE sexo = 'FEMENINO'
");

$total_jovenes = $wpdb->get_var("
    SELECT COUNT(*)
    FROM $tabla
    WHERE joven_rural = 'SI'
");

?>

<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . '../assets/css/style.css'; ?>">

            
<div class="aec-home">

    <!-- HERO -->
    <div class="aec-hero">

        <div>
            <h1>
                🌍 Plataforma de Economía Circular
            </h1>

            <p>
                Bienvenido 
                <strong>
                    <?= $user['nombre'] ?? 'Usuario' ?>
                </strong>
            </p>

            <span>
                Sistema de caracterización territorial,
                sostenibilidad e impacto estratégico.
            </span>
        </div>

        <div class="aec-hero-badge">
            ♻️ AICOLD
        </div>

    </div>

    <!-- KPI CARDS -->
    <div class="aec-home-grid">

        <div class="aec-home-card green">
            <h3>🏢 Organizaciones</h3>
            <p><?= $total_org ?></p>
        </div>

        <div class="aec-home-card blue">
            <h3>♻️ Uso de Residuos</h3>
            <p><?= $total_residuos ?></p>
        </div>

        <div class="aec-home-card orange">
            <h3>👩 Participación Mujeres</h3>
            <p><?= $total_mujeres ?></p>
        </div>

        <div class="aec-home-card purple">
            <h3>🧑 Jóvenes Rurales</h3>
            <p><?= $total_jovenes ?></p>
        </div>

    </div>

    <!-- ACCESOS RÁPIDOS -->
    <div class="aec-shortcuts">

        <a href="?modulo=kpi-ambientales">
            🌱 KPI Ambientales
        </a>

        <a href="?modulo=kpi-sociales">
            👥 KPI Sociales
        </a>

        <a href="?modulo=kpi-economicos">
            💰 KPI Económicos
        </a>

        <a href="?modulo=kpi-territoriales">
            🗺️ KPI Territoriales
        </a>

    </div>

    <!-- PANEL EJECUTIVO -->
    <div class="aec-executive-grid">

        <!-- ACTIVIDAD -->
        <div class="aec-panel">

            <h3>
                📈 Actividad reciente
            </h3>

            <ul class="aec-activity">

                <li>
                    ✅ Nuevas organizaciones registradas
                </li>

                <li>
                    ♻️ Iniciativas ambientales activas
                </li>

                <li>
                    👥 Comunidades caracterizadas
                </li>

                <li>
                    🌍 Indicadores estratégicos actualizados
                </li>

            </ul>

        </div>

        <!-- RESUMEN -->
        <div class="aec-panel">

            <h3>
                🌎 Resumen institucional
            </h3>

            <p>
                La plataforma integra información
                ambiental, social, territorial y económica
                de organizaciones de economía circular
                y negocios verdes.
            </p>

        </div>

    </div>

</div>