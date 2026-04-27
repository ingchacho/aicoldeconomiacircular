<?php
global $wpdb;
$tabla = $wpdb->prefix . 'organizaciones';

// KPI 1
$total = $wpdb->get_var("SELECT COUNT(*) FROM $tabla");

// KPI 2
$por_municipio = $wpdb->get_results("
    SELECT municipio, COUNT(*) as total 
    FROM $tabla 
    GROUP BY municipio
");

// KPI 3
$por_comunidad = $wpdb->get_results("
    SELECT enfoque, COUNT(*) as total 
    FROM $tabla 
    GROUP BY enfoque
");
?>


<?php
// MUNICIPIOS
$labels_municipio = [];
$data_municipio = [];

foreach ($por_municipio as $row) {
    $labels_municipio[] = $row->municipio;
    $data_municipio[] = $row->total;
}

// COMUNIDAD
$labels_comunidad = [];
$data_comunidad = [];

foreach ($por_comunidad as $row) {
    $labels_comunidad[] = $row->enfoque;
    $data_comunidad[] = $row->total;
}
?>




<div class="aec-container">

    <h2>Dashboard de Indicadores</h2>

    <!-- KPI TOTAL -->
    <div class="kpi-box">
        <h3>Total Organizaciones</h3>
        <p><?= $total ?></p>
    </div>

    <h3>Organizaciones por Municipio</h3>
    <canvas id="graficoMunicipio"></canvas>

    <h3>Tipo de Comunidad</h3>
    <canvas id="graficoComunidad"></canvas>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    // MUNICIPIOS
    const ctx1 = document.getElementById('graficoMunicipio');

    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels_municipio) ?>,
            datasets: [{
                label: 'Organizaciones',
                data: <?= json_encode($data_municipio) ?>,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });


    // COMUNIDAD
    const ctx2 = document.getElementById('graficoComunidad');

    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: <?= json_encode($labels_comunidad) ?>,
            datasets: [{
                data: <?= json_encode($data_comunidad) ?>
            }]
        },
        options: {
            responsive: true
        }
    });

</script>
