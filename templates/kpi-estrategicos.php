<?php

global $wpdb;

$tabla = $wpdb->prefix . 'organizaciones';

/* =========================================
KPIs ESTRATÉGICOS
========================================= */

// Total organizaciones
$total = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
");

// Impacto ambiental
$impacto = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
    WHERE problema_ambiental IS NOT NULL
    AND problema_ambiental != ''
");

// Economía circular
$circulares = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
    WHERE usa_residuos = 'SI'
");

// Generación empleo
$empleo = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
    WHERE genera_empleo = 'SI'
");

// Mujeres rurales
$mujeres = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
    WHERE mujer_rural = 'SI'
");

// Jóvenes rurales
$jovenes = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
    WHERE joven_rural = 'SI'
");

// Cobertura territorial
$territorios = $wpdb->get_var("
    SELECT COUNT(DISTINCT municipio)
    FROM $tabla
");

/* =========================================
COMUNIDADES
========================================= */

$comunidades = $wpdb->get_results("
    SELECT enfoque, COUNT(*) total
    FROM $tabla
    GROUP BY enfoque
");

$labels_comunidad = [];
$data_comunidad = [];

foreach($comunidades as $c){
    $labels_comunidad[] = $c->enfoque ?: 'Sin definir';
    $data_comunidad[] = $c->total;
}

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

?>

<link rel="stylesheet" href="<?php echo AEC_URL . 'assets/css/kpis.css'; ?>">

<div class="aec-container">

    <h2>🌍 KPI Estratégicos</h2>

    <!-- KPI CARDS -->
    <div class="kpi-modern-grid">

        <div class="kpi-card green">
            <div class="icon">♻️</div>
            <h3>Economía Circular</h3>
            <p><?= $circulares ?></p>
        </div>

        <div class="kpi-card blue">
            <div class="icon">🌎</div>
            <h3>Impacto Ambiental</h3>
            <p><?= $impacto ?></p>
        </div>

        <div class="kpi-card orange">
            <div class="icon">👷</div>
            <h3>Generación Empleo</h3>
            <p><?= $empleo ?></p>
        </div>

        <div class="kpi-card purple">
            <div class="icon">🗺️</div>
            <h3>Cobertura Territorial</h3>
            <p><?= $territorios ?></p>
        </div>

    </div>

    <!-- SEGUNDA FILA -->
    <div class="kpi-modern-grid">

        <div class="kpi-card red">
            <div class="icon">👩</div>
            <h3>Mujer Rural</h3>
            <p><?= $mujeres ?></p>
        </div>

        <div class="kpi-card green">
            <div class="icon">🧑</div>
            <h3>Joven Rural</h3>
            <p><?= $jovenes ?></p>
        </div>

        <div class="kpi-card blue">
            <div class="icon">🏢</div>
            <h3>Organizaciones</h3>
            <p><?= $total ?></p>
        </div>

        <div class="kpi-card orange">
            <div class="icon">🤝</div>
            <h3>Impacto Estratégico</h3>
            <p><?= $impacto + $circulares + $empleo ?></p>
        </div>

    </div>

    <!-- GRÁFICOS -->
    <div class="aec-chart-grid-4">

        <div class="aec-chart-card">
            <h3>🌍 Comunidades</h3>
            <canvas id="chartComunidad"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>📈 Estado Iniciativas</h3>
            <canvas id="chartEstado"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>👩 Inclusión Rural</h3>
            <canvas id="chartRural"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>♻️ Impacto Estratégico</h3>
            <canvas id="chartImpacto"></canvas>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function(){

    // COMUNIDADES
    new Chart(document.getElementById('chartComunidad'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($labels_comunidad) ?>,
            datasets: [{
                data: <?= json_encode($data_comunidad) ?>
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    });

    // ESTADO
    new Chart(document.getElementById('chartEstado'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels_estado) ?>,
            datasets: [{
                data: <?= json_encode($data_estado) ?>
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    });

    // INCLUSIÓN
    new Chart(document.getElementById('chartRural'), {
        type: 'pie',
        data: {
            labels: ['Mujer Rural', 'Joven Rural'],
            datasets: [{
                data: [
                    <?= $mujeres ?>,
                    <?= $jovenes ?>
                ]
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    });

    // IMPACTO
    new Chart(document.getElementById('chartImpacto'), {
        type: 'radar',
        data: {
            labels: [
                'Ambiental',
                'Circular',
                'Empleo',
                'Cobertura'
            ],
            datasets: [{
                data: [
                    <?= $impacto ?>,
                    <?= $circulares ?>,
                    <?= $empleo ?>,
                    <?= $territorios ?>
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