<?php

if (!session_id()) session_start();

if(!isset($_SESSION['aec_user'])){
    exit;
}

global $wpdb;

$tabla = $wpdb->prefix . 'organizaciones';

$where = "WHERE 1=1";

/* =========================
FILTROS
========================= */

if (!empty($_GET['municipio'])) {
    $municipio = esc_sql($_GET['municipio']);
    $where .= " AND municipio = '$municipio'";
}

if (!empty($_GET['enfoque'])) {
    $enfoque = esc_sql($_GET['enfoque']);
    $where .= " AND enfoque = '$enfoque'";
}

if (!empty($_GET['estado'])) {
    $estadoFiltro = esc_sql($_GET['estado']);
    $where .= " AND estado_iniciativa = '$estadoFiltro'";
}

/* =========================
KPIs
========================= */

$total = $wpdb->get_var("
    SELECT COUNT(*) FROM $tabla $where
");

$uso_residuos = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla 
    $where 
    AND usa_residuos = 'SI'
");

$porcentaje_residuos = $total > 0
    ? round(($uso_residuos / $total) * 100)
    : 0;

$impacto = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla 
    $where 
    AND problema_ambiental IS NOT NULL
    AND problema_ambiental != ''
");

/* =========================
GRÁFICAS
========================= */

$por_municipio = $wpdb->get_results("
    SELECT municipio, COUNT(*) total
    FROM $tabla
    $where
    GROUP BY municipio
");

$por_comunidad = $wpdb->get_results("
    SELECT 
    CASE 
        WHEN enfoque IS NULL OR enfoque = ''
        THEN 'Sin definir'
        ELSE enfoque
    END enfoque,
    COUNT(*) total
    FROM $tabla
    $where
    GROUP BY enfoque
");

$estado = $wpdb->get_results("
    SELECT estado_iniciativa, COUNT(*) total
    FROM $tabla
    $where
    GROUP BY estado_iniciativa
");

/* =========================
DATOS JS
========================= */

$labels_municipio = [];
$data_municipio = [];

foreach ($por_municipio as $row) {
    $labels_municipio[] = $row->municipio;
    $data_municipio[] = $row->total;
}

$labels_comunidad = [];
$data_comunidad = [];

foreach ($por_comunidad as $row) {
    $labels_comunidad[] = $row->enfoque;
    $data_comunidad[] = $row->total;
}

$labels_estado = [];
$data_estado = [];

foreach ($estado as $row) {
    $labels_estado[] = $row->estado_iniciativa ?: 'Sin definir';
    $data_estado[] = $row->total;
}

?>

<div class="aec-dashboard">

    <div class="aec-topbar">

        <div>
            <h1>Dashboard KPI</h1>
            <p>Economía Circular · AICOLD</p>
        </div>

        <button onclick="exportarExcel()" class="aec-export-btn">
            Exportar Excel
        </button>

    </div>

    <!-- FILTROS -->

    <form method="GET" class="aec-filtros">

        <input type="hidden" name="modulo" value="kpi">

        <select name="municipio">

            <option value="">Todos los municipios</option>

            <?php
            $municipios = $wpdb->get_results("
                SELECT DISTINCT municipio 
                FROM $tabla
            ");

            foreach($municipios as $m):

                $selected = ($_GET['municipio'] ?? '') == $m->municipio
                    ? 'selected'
                    : '';
            ?>

                <option <?= $selected ?>>
                    <?= $m->municipio ?>
                </option>

            <?php endforeach; ?>

        </select>

        <select name="enfoque">

            <option value="">Todas las comunidades</option>

            <?php
            $enfoques = $wpdb->get_results("
                SELECT DISTINCT enfoque 
                FROM $tabla
            ");

            foreach($enfoques as $e):

                $selected = ($_GET['enfoque'] ?? '') == $e->enfoque
                    ? 'selected'
                    : '';
            ?>

                <option <?= $selected ?>>
                    <?= $e->enfoque ?>
                </option>

            <?php endforeach; ?>

        </select>

        <select name="estado">

            <option value="">Todos los estados</option>

            <?php
            $estados = $wpdb->get_results("
                SELECT DISTINCT estado_iniciativa 
                FROM $tabla
            ");

            foreach($estados as $es):

                $selected = ($_GET['estado'] ?? '') == $es->estado_iniciativa
                    ? 'selected'
                    : '';
            ?>

                <option <?= $selected ?>>
                    <?= $es->estado_iniciativa ?>
                </option>

            <?php endforeach; ?>

        </select>

    </form>

    <!-- KPI CARDS -->

    <div class="aec-kpi-grid">

        <div class="aec-kpi-card">
            <h3>Total Organizaciones</h3>
            <span><?= $total ?></span>
        </div>

        <div class="aec-kpi-card">
            <h3>Uso de residuos</h3>
            <span><?= $porcentaje_residuos ?>%</span>
        </div>

        <div class="aec-kpi-card">
            <h3>Impacto ambiental</h3>
            <span><?= $impacto ?></span>
        </div>

    </div>

    <!-- CHARTS -->

    <div class="aec-chart-grid">

        <div class="aec-chart-card">
            <h3>Organizaciones por Municipio</h3>
            <canvas id="graficoMunicipio"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>Tipo de Comunidad</h3>
            <canvas id="graficoComunidad"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>Estado del Emprendimiento</h3>
            <canvas id="graficoEstado"></canvas>
        </div>

    </div>

</div>

<style>

.aec-dashboard{
    padding:30px;
}

.aec-topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.aec-topbar h1{
    margin:0;
}

.aec-export-btn{
    background:#2e7d32;
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
}

.aec-filtros{
    display:flex;
    gap:15px;
    margin-bottom:30px;
}

.aec-filtros select{
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
}

.aec-kpi-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:30px;
}

.aec-kpi-card{
    background:white;
    border-radius:14px;
    padding:25px;
    box-shadow:0 4px 15px rgba(0,0,0,.08);
}

.aec-kpi-card h3{
    margin:0;
    color:#777;
}

.aec-kpi-card span{
    display:block;
    margin-top:15px;
    font-size:42px;
    font-weight:bold;
    color:#2e7d32;
}

.aec-chart-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.aec-chart-card{
    background:white;
    padding:25px;
    border-radius:14px;
    box-shadow:0 4px 15px rgba(0,0,0,.08);
}

.aec-chart-card:last-child{
    grid-column:1/3;
}

@media(max-width:900px){

    .aec-kpi-grid{
        grid-template-columns:1fr;
    }

    .aec-chart-grid{
        grid-template-columns:1fr;
    }

    .aec-chart-card:last-child{
        grid-column:auto;
    }

    .aec-filtros{
        flex-direction:column;
    }
}

</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function(){

    crearGrafico(
        'graficoMunicipio',
        'bar',
        <?= json_encode($labels_municipio) ?>,
        <?= json_encode($data_municipio) ?>
    );

    crearGrafico(
        'graficoComunidad',
        'pie',
        <?= json_encode($labels_comunidad) ?>,
        <?= json_encode($data_comunidad) ?>
    );

    crearGrafico(
        'graficoEstado',
        'doughnut',
        <?= json_encode($labels_estado) ?>,
        <?= json_encode($data_estado) ?>
    );

});

function crearGrafico(id, tipo, labels, data){

    new Chart(document.getElementById(id), {

        type: tipo,

        data: {

            labels: labels,

            datasets: [{
                data: data
            }]
        }
    });
}

function exportarExcel(){

    const params = new URLSearchParams(
        new FormData(document.querySelector('.aec-filtros'))
    );

    window.open(
        "<?= admin_url('admin-ajax.php') ?>?action=aec_exportar_excel&" + params
    );
}

</script>