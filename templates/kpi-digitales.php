<?php

global $wpdb;

$tabla = $wpdb->prefix . 'organizaciones';

/* =========================================
KPI DIGITALES
========================================= */

// Total registros
$total_registros = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
");

// Registros con email
$con_email = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
    WHERE email IS NOT NULL
    AND email != ''
");

// Registros con teléfono
$con_telefono = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
    WHERE telefono IS NOT NULL
    AND telefono != ''
");

// Registros completos
$completos = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
    WHERE nombre IS NOT NULL
    AND municipio IS NOT NULL
    AND enfoque IS NOT NULL
");

// =========================================
// MUNICIPIOS
// =========================================

$municipios = $wpdb->get_results("
    SELECT municipio, COUNT(*) total
    FROM $tabla
    GROUP BY municipio
");

$labels_municipio = [];
$data_municipio = [];

foreach($municipios as $m){
    $labels_municipio[] = $m->municipio;
    $data_municipio[] = $m->total;
}

// =========================================
// COMUNIDADES
// =========================================

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

?>


<link rel="stylesheet" href="<?php echo AEC_URL . 'assets/css/kpis.css'; ?>">


<div class="aec-container">

    <h2>💻 KPI Digitales del Micrositio</h2>

    <!-- KPI CARDS -->
    <div class="kpi-modern-grid">

        <div class="kpi-card blue">
            <div class="icon">📝</div>
            <h3>Registros Totales</h3>
            <p><?= $total_registros ?></p>
        </div>

        <div class="kpi-card green">
            <div class="icon">📧</div>
            <h3>Con Email</h3>
            <p><?= $con_email ?></p>
        </div>

        <div class="kpi-card orange">
            <div class="icon">📱</div>
            <h3>Con Teléfono</h3>
            <p><?= $con_telefono ?></p>
        </div>

        <div class="kpi-card purple">
            <div class="icon">✅</div>
            <h3>Registros Completos</h3>
            <p><?= $completos ?></p>
        </div>

    </div>

    <!-- GRÁFICOS -->
    <div class="aec-chart-grid-4">

        <div class="aec-chart-card">
            <h3>📧 Contactabilidad</h3>
            <canvas id="chartContacto"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>🗺️ Registros por Municipio</h3>
            <canvas id="chartMunicipios"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>👥 Comunidades Registradas</h3>
            <canvas id="chartComunidades"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>📊 Nivel de Completitud</h3>
            <canvas id="chartCompletitud"></canvas>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function(){

    // CONTACTABILIDAD
    new Chart(document.getElementById('chartContacto'), {
        type: 'doughnut',
        data: {
            labels: ['Con Email', 'Sin Email'],
            datasets: [{
                data: [
                    <?= $con_email ?>,
                    <?= max(0, $total_registros - $con_email) ?>
                ]
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    });

    // MUNICIPIOS
    new Chart(document.getElementById('chartMunicipios'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels_municipio) ?>,
            datasets: [{
                label:'Registros',
                data: <?= json_encode($data_municipio) ?>
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    });

    // COMUNIDADES
    new Chart(document.getElementById('chartComunidades'), {
        type: 'polarArea',
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

    // COMPLETITUD
    new Chart(document.getElementById('chartCompletitud'), {
        type: 'pie',
        data: {
            labels: ['Completos', 'Incompletos'],
            datasets: [{
                data: [
                    <?= $completos ?>,
                    <?= max(0, $total_registros - $completos) ?>
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