<?php

global $wpdb;

$tabla = $wpdb->prefix . 'organizaciones';

/* =========================================
KPIs ECONÓMICOS
========================================= */

// Total emprendimientos
$total_emprendimientos = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
");

// Emprendimientos activos
$activos = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
    WHERE estado_iniciativa IS NOT NULL
    AND estado_iniciativa != ''
");

// Generan empleo
$empleo = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
    WHERE genera_empleo = 'SI'
");

// Economía circular
$circulares = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
    WHERE usa_residuos = 'SI'
");

/* =========================================
ESTADO INICIATIVA
========================================= */

$estado = $wpdb->get_results("
    SELECT estado_iniciativa, COUNT(*) total
    FROM $tabla
    GROUP BY estado_iniciativa
");

$labels_estado = [];
$data_estado = [];

foreach($estado as $e){
    $labels_estado[] = $e->estado_iniciativa ?: 'Sin definir';
    $data_estado[] = $e->total;
}

/* =========================================
TIEMPO OPERACIÓN
========================================= */

$tiempo = $wpdb->get_results("
    SELECT tiempo_operacion, COUNT(*) total
    FROM $tabla
    GROUP BY tiempo_operacion
");

$labels_tiempo = [];
$data_tiempo = [];

foreach($tiempo as $t){
    $labels_tiempo[] = $t->tiempo_operacion ?: 'Sin definir';
    $data_tiempo[] = $t->total;
}

?>

<link rel="stylesheet" href="<?php echo AEC_URL . 'assets/css/kpis.css'; ?>">

<div class="aec-container">

    <h2>💰 KPI Económicos</h2>

    <!-- KPI CARDS -->
    <div class="kpi-modern-grid">

        <div class="kpi-card green">
            <div class="icon">🏢</div>
            <h3>Emprendimientos</h3>
            <p><?= $total_emprendimientos ?></p>
        </div>

        <div class="kpi-card blue">
            <div class="icon">📈</div>
            <h3>Iniciativas Activas</h3>
            <p><?= $activos ?></p>
        </div>

        <div class="kpi-card orange">
            <div class="icon">👷</div>
            <h3>Generan Empleo</h3>
            <p><?= $empleo ?></p>
        </div>

        <div class="kpi-card purple">
            <div class="icon">♻️</div>
            <h3>Economía Circular</h3>
            <p><?= $circulares ?></p>
        </div>

    </div>

    <!-- GRÁFICAS -->
    <div class="aec-chart-grid-4">

        <div class="aec-chart-card">
            <h3>📈 Estado de Iniciativas</h3>
            <canvas id="chartEstado"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>⏳ Tiempo de Operación</h3>
            <canvas id="chartTiempo"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>👷 Generación de Empleo</h3>
            <canvas id="chartEmpleo"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>♻️ Economía Circular</h3>
            <canvas id="chartCircular"></canvas>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function(){

    // ESTADO
    new Chart(document.getElementById('chartEstado'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels_estado) ?>,
            datasets: [{
                label:'Iniciativas',
                data: <?= json_encode($data_estado) ?>,
                borderWidth:1
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    });

    // TIEMPO
    new Chart(document.getElementById('chartTiempo'), {
        type: 'polarArea',
        data: {
            labels: <?= json_encode($labels_tiempo) ?>,
            datasets: [{
                data: <?= json_encode($data_tiempo) ?>
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    });

    // EMPLEO
    new Chart(document.getElementById('chartEmpleo'), {
        type: 'doughnut',
        data: {
            labels: ['Generan empleo', 'No generan'],
            datasets: [{
                data: [
                    <?= $empleo ?>,
                    <?= max(0, $total_emprendimientos - $empleo) ?>
                ]
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    });

    // CIRCULAR
    new Chart(document.getElementById('chartCircular'), {
        type: 'pie',
        data: {
            labels: ['Economía circular', 'Tradicional'],
            datasets: [{
                data: [
                    <?= $circulares ?>,
                    <?= max(0, $total_emprendimientos - $circulares) ?>
                ]
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    });

});

</script>