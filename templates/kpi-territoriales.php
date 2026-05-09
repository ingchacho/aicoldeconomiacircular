<?php

global $wpdb;

$tabla = $wpdb->prefix . 'organizaciones';

/* =========================================
KPIs TERRITORIALES
========================================= */

// Total departamentos
$total_departamentos = $wpdb->get_var("
    SELECT COUNT(DISTINCT departamento)
    FROM $tabla
");

// Total municipios
$total_municipios = $wpdb->get_var("
    SELECT COUNT(DISTINCT municipio)
    FROM $tabla
");

// Total veredas
$total_veredas = $wpdb->get_var("
    SELECT COUNT(DISTINCT vereda)
    FROM $tabla
");

// Total comunidades
$total_comunidades = $wpdb->get_var("
    SELECT COUNT(DISTINCT enfoque)
    FROM $tabla
");

/* =========================================
DEPARTAMENTOS
========================================= */

$departamentos = $wpdb->get_results("
    SELECT departamento, COUNT(*) total
    FROM $tabla
    GROUP BY departamento
");

$labels_departamentos = [];
$data_departamentos = [];

foreach($departamentos as $d){
    $labels_departamentos[] = $d->departamento ?: 'Sin definir';
    $data_departamentos[] = $d->total;
}

/* =========================================
MUNICIPIOS
========================================= */

$municipios = $wpdb->get_results("
    SELECT municipio, COUNT(*) total
    FROM $tabla
    GROUP BY municipio
");

$labels_municipios = [];
$data_municipios = [];

foreach($municipios as $m){
    $labels_municipios[] = $m->municipio ?: 'Sin definir';
    $data_municipios[] = $m->total;
}

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
VEREDAS
========================================= */

$veredas = $wpdb->get_results("
    SELECT vereda, COUNT(*) total
    FROM $tabla
    GROUP BY vereda
");

$labels_veredas = [];
$data_veredas = [];

foreach($veredas as $v){
    $labels_veredas[] = $v->vereda ?: 'Sin definir';
    $data_veredas[] = $v->total;
}

?>

<link rel="stylesheet" href="<?php echo AEC_URL . 'assets/css/kpis.css'; ?>">

<div class="aec-container">

    <h2>🗺️ KPI Territoriales</h2>

    <!-- KPI CARDS -->
    <div class="kpi-modern-grid">

        <div class="kpi-card green">
            <div class="icon">🌍</div>
            <h3>Departamentos</h3>
            <p><?= $total_departamentos ?></p>
        </div>

        <div class="kpi-card blue">
            <div class="icon">🏙️</div>
            <h3>Municipios</h3>
            <p><?= $total_municipios ?></p>
        </div>

        <div class="kpi-card orange">
            <div class="icon">🌱</div>
            <h3>Veredas</h3>
            <p><?= $total_veredas ?></p>
        </div>

        <div class="kpi-card purple">
            <div class="icon">👥</div>
            <h3>Comunidades</h3>
            <p><?= $total_comunidades ?></p>
        </div>

    </div>

    <!-- GRÁFICOS -->
    <div class="aec-chart-grid-4">

        <div class="aec-chart-card">
            <h3>🌍 Organizaciones por Departamento</h3>
            <canvas id="chartDepartamentos"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>🏙️ Organizaciones por Municipio</h3>
            <canvas id="chartMunicipios"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>👥 Distribución por Comunidad</h3>
            <canvas id="chartComunidad"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>🌱 Cobertura Rural</h3>
            <canvas id="chartVeredas"></canvas>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function(){

    // DEPARTAMENTOS
    new Chart(document.getElementById('chartDepartamentos'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels_departamentos) ?>,
            datasets: [{
                label:'Organizaciones',
                data: <?= json_encode($data_departamentos) ?>,
                borderWidth:1
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    });

    // MUNICIPIOS
    new Chart(document.getElementById('chartMunicipios'), {
        type: 'polarArea',
        data: {
            labels: <?= json_encode($labels_municipios) ?>,
            datasets: [{
                data: <?= json_encode($data_municipios) ?>
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    });

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

    // VEREDAS
    new Chart(document.getElementById('chartVeredas'), {
        type: 'pie',
        data: {
            labels: <?= json_encode($labels_veredas) ?>,
            datasets: [{
                data: <?= json_encode($data_veredas) ?>
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    });

});

</script>