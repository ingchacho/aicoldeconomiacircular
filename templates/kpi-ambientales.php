<?php

global $wpdb;

$tabla = $wpdb->prefix . 'organizaciones';

/* =========================================
CONSULTAS KPI AMBIENTALES
========================================= */

// Total organizaciones verdes
$total_verdes = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
");

// Uso de residuos
$uso_residuos = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
    WHERE usa_residuos = 'SI'
");

// Impacto ambiental
$impacto = $wpdb->get_var("
    SELECT COUNT(*) 
    FROM $tabla
    WHERE problema_ambiental IS NOT NULL
    AND problema_ambiental != ''
");

/* =========================================
GRÁFICO MUNICIPIOS
========================================= */

$municipios = $wpdb->get_results("
    SELECT municipio, COUNT(*) total
    FROM $tabla
    GROUP BY municipio
");

$labels_municipios = [];
$data_municipios = [];

foreach($municipios as $m){
    $labels_municipios[] = $m->municipio;
    $data_municipios[] = $m->total;
}

/* =========================================
GRÁFICO COMUNIDADES
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

?>

<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . '../assets/css/kpis.css'; ?>">

<div class="aec-container">

    <h2>🌱 KPI Ambientales</h2>

    <!-- KPI CARDS -->
    <div class="kpi-modern-grid">

        <div class="kpi-card green">
            <div class="icon">♻️</div>
            <h3>Organizaciones Verdes</h3>
            <p><?= $total_verdes ?></p>
        </div>

        <div class="kpi-card blue">
            <div class="icon">🗑️</div>
            <h3>Uso de Residuos</h3>
            <p><?= $uso_residuos ?></p>
        </div>

        <div class="kpi-card orange">
            <div class="icon">🌎</div>
            <h3>Impacto Ambiental</h3>
            <p><?= $impacto ?></p>
        </div>

    </div>

    <!-- GRÁFICAS -->
    <div class="aec-chart-grid-4">

        <div class="aec-chart-card">
            <h3>♻️ Uso de Residuos</h3>
            <canvas id="chartResiduos"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>🌎 Impacto Ambiental</h3>
            <canvas id="chartImpacto"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>🗺️ Organizaciones por Municipio</h3>
            <canvas id="chartMunicipio"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>👥 Tipo de Comunidad</h3>
            <canvas id="chartComunidad"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function(){
        // PIE
        new Chart(document.getElementById('chartResiduos'), {
            type: 'doughnut',
            data: {
                labels: ['Usa residuos', 'No usa'],
                datasets: [{
                    data: [
                        <?= $uso_residuos ?>,
                        <?= max(0, $total_verdes - $uso_residuos) ?>
                    ]
                }]
            },
            options:{
                responsive:true,
                maintainAspectRatio:false
            }
        });

        // BAR
        // IMPACTO AMBIENTAL
        new Chart(document.getElementById('chartImpacto'), {
            type: 'pie',

            data: {
                labels: [
                    'Con impacto identificado',
                    'Sin impacto identificado'
                ],

                datasets: [{
                    data: [
                        <?= $impacto ?>,
                        <?= max(0, $total_verdes - $impacto) ?>
                    ]
                }]
            },

            options:{
                responsive:true,
                maintainAspectRatio:false
            }
        });

       // MUNICIPIOS
        new Chart(document.getElementById('chartMunicipio'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels_municipios) ?>,
                datasets: [{
                    label: 'Organizaciones',
                    data: <?= json_encode($data_municipios) ?>,
                    borderWidth: 1
                }]
            },
            options:{
                responsive:true,
                maintainAspectRatio:false,
                scales:{
                    y:{
                        beginAtZero:true
                    }
                }
            }
        });

        // COMUNIDADES
        new Chart(document.getElementById('chartComunidad'), {
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
    });
</script>