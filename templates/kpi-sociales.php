<?php

    global $wpdb;

    $tabla = $wpdb->prefix . 'organizaciones';

    /* =========================================
    KPIs SOCIALES
    ========================================= */

    // Total organizaciones
    $total_org = $wpdb->get_var("
        SELECT COUNT(*) 
        FROM $tabla
    ");

    // Comunidades
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

    // Municipios
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

    // Organizaciones activas socialmente
    $impacto_social = $wpdb->get_var("
        SELECT COUNT(*) 
        FROM $tabla
        WHERE problema_ambiental IS NOT NULL
        AND problema_ambiental != ''
    ");

?>

<link rel="stylesheet" href="<?php echo AEC_URL . 'assets/css/kpis.css'; ?>">

<div class="aec-container">

    <h2>👥 KPI Sociales</h2>

    <!-- KPI CARDS -->
    <div class="kpi-modern-grid">

        <div class="kpi-card blue">
            <div class="icon">🏢</div>
            <h3>Organizaciones</h3>
            <p><?= $total_org ?></p>
        </div>

        <div class="kpi-card purple">
            <div class="icon">👥</div>
            <h3>Comunidades</h3>
            <p><?= count($labels_comunidad) ?></p>
        </div>

        <div class="kpi-card green">
            <div class="icon">🌍</div>
            <h3>Municipios Impactados</h3>
            <p><?= count($labels_municipios) ?></p>
        </div>

        <div class="kpi-card orange">
            <div class="icon">🤝</div>
            <h3>Impacto Social</h3>
            <p><?= $impacto_social ?></p>
        </div>

    </div>

    <!-- GRÁFICAS -->
    <div class="aec-chart-grid-4">

        <div class="aec-chart-card">
            <h3>👥 Tipo de Comunidad</h3>
            <canvas id="chartComunidadSocial"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>🗺️ Cobertura Territorial</h3>
            <canvas id="chartMunicipiosSocial"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>🌍 Impacto Social</h3>
            <canvas id="chartImpactoSocial"></canvas>
        </div>

        <div class="aec-chart-card">
            <h3>🏢 Organizaciones</h3>
            <canvas id="chartOrganizaciones"></canvas>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    document.addEventListener("DOMContentLoaded", function(){

        // COMUNIDAD
        new Chart(document.getElementById('chartComunidadSocial'), {
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

        // MUNICIPIOS
        new Chart(document.getElementById('chartMunicipiosSocial'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels_municipios) ?>,
                datasets: [{
                    label:'Cobertura',
                    data: <?= json_encode($data_municipios) ?>,
                    borderWidth:1
                }]
            },
            options:{
                responsive:true,
                maintainAspectRatio:false
            }
        });

        // IMPACTO SOCIAL
        new Chart(document.getElementById('chartImpactoSocial'), {
            type: 'doughnut',
            data: {
                labels: ['Con impacto', 'Sin impacto'],
                datasets: [{
                    data: [
                        <?= $impacto_social ?>,
                        <?= max(0, $total_org - $impacto_social) ?>
                    ]
                }]
            },
            options:{
                responsive:true,
                maintainAspectRatio:false
            }
        });

        // ORGANIZACIONES
        new Chart(document.getElementById('chartOrganizaciones'), {
            type: 'pie',
            data: {
                labels: ['Registradas'],
                datasets: [{
                    data: [<?= $total_org ?>]
                }]
            },
            options:{
                responsive:true,
                maintainAspectRatio:false
            }
        });

    });

</script>