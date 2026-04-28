<?php
global $wpdb;
$tabla = $wpdb->prefix . 'organizaciones';


$where = "WHERE 1=1";

if (!empty($_GET['municipio'])) {
    $municipio = esc_sql($_GET['municipio']);
    $where .= " AND municipio = '$municipio'";
}

if (!empty($_GET['enfoque'])) {
    $enfoque = esc_sql($_GET['enfoque']);
    $where .= " AND enfoque = '$enfoque'";
}

if (!empty($_GET['estado'])) {
    $estado = esc_sql($_GET['estado']);
    $where .= " AND estado_iniciativa = '$estado'";
}

/* =========================
   KPIs BASE
========================= */

// TOTAL
// $total = $wpdb->get_var("SELECT COUNT(*) FROM $tabla");
$total = $wpdb->get_var("SELECT COUNT(*) FROM $tabla $where");


// MUNICIPIOS
// $por_municipio = $wpdb->get_results("
//     SELECT municipio, COUNT(*) as total 
//     FROM $tabla 
//     GROUP BY municipio
// ");

$por_municipio = $wpdb->get_results("
    SELECT municipio, COUNT(*) as total 
    FROM $tabla 
    $where
    GROUP BY municipio
");

// COMUNIDAD
// $por_comunidad = $wpdb->get_results("
//     SELECT 
//         CASE 
//             WHEN enfoque IS NULL OR enfoque = '' 
//             THEN 'Sin definir'
//             ELSE enfoque
//         END as enfoque,
//         COUNT(*) as total 
//     FROM $tabla 
//     GROUP BY enfoque
// ");
$por_comunidad = $wpdb->get_results("
    SELECT 
        CASE 
            WHEN enfoque IS NULL OR enfoque = '' 
            THEN 'Sin definir'
            ELSE enfoque
        END as enfoque,
        COUNT(*) as total 
    FROM $tabla 
    $where
    GROUP BY enfoque
");

// USO DE RESIDUOS
// $uso_residuos = $wpdb->get_var("
//     SELECT COUNT(*) FROM $tabla 
//     WHERE usa_residuos = 'SI'
// ");
$uso_residuos = $wpdb->get_var("
    SELECT COUNT(*) FROM $tabla 
    $where AND usa_residuos = 'SI'
");

$porcentaje_residuos = $total > 0 ? round(($uso_residuos / $total) * 100) : 0;

// IMPACTO AMBIENTAL
// $impacto = $wpdb->get_var("
//     SELECT COUNT(*) FROM $tabla 
//     WHERE problema_ambiental IS NOT NULL 
//     AND problema_ambiental != ''
// ");
$impacto = $wpdb->get_var("
    SELECT COUNT(*) FROM $tabla 
    $where AND problema_ambiental IS NOT NULL 
    AND problema_ambiental != ''
");

// ESTADO
// $estado = $wpdb->get_results("
//     SELECT estado_iniciativa, COUNT(*) as total 
//     FROM $tabla 
//     GROUP BY estado_iniciativa
// ");
$estado = $wpdb->get_results("
    SELECT estado_iniciativa, COUNT(*) as total 
    FROM $tabla 
    $where
    GROUP BY estado_iniciativa
");
/* =========================
   PREPARAR DATOS PARA JS
========================= */

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

// ESTADO
$labels_estado = [];
$data_estado = [];

foreach ($estado as $row) {
    $labels_estado[] = $row->estado_iniciativa ?: 'Sin definir';
    $data_estado[] = $row->total;
}
?>

<div class="aec-container">

    <h2>Dashboard de Indicadores</h2>

    <form method="GET" class="aec-filtros">

    <select name="municipio">
        <option value="">Todos los municipios</option>
        <?php
        $municipios = $wpdb->get_results("SELECT DISTINCT municipio FROM $tabla");
        foreach($municipios as $m){
            $selected = ($_GET['municipio'] ?? '') == $m->municipio ? 'selected' : '';
            echo "<option $selected>{$m->municipio}</option>";
        }
        ?>
    </select>

    <select name="enfoque">
        <option value="">Todas las comunidades</option>
        <?php
        $enfoques = $wpdb->get_results("SELECT DISTINCT enfoque FROM $tabla");
        foreach($enfoques as $e){
            $selected = ($_GET['enfoque'] ?? '') == $e->enfoque ? 'selected' : '';
            echo "<option $selected>{$e->enfoque}</option>";
        }
        ?>
    </select>

    <select name="estado">
        <option value="">Todos los estados</option>
        <?php
        $estados = $wpdb->get_results("SELECT DISTINCT estado_iniciativa FROM $tabla");
        foreach($estados as $es){
            $selected = ($_GET['estado'] ?? '') == $es->estado_iniciativa ? 'selected' : '';
            echo "<option $selected>{$es->estado_iniciativa}</option>";
        }
        ?>
    </select>

    <button type="submit">Filtrar</button>

</form>

    <!-- KPIs -->
    <div class="kpi-grid">

        <div class="kpi-box">
            <h3>Total Organizaciones</h3>
            <p><?= $total ?></p>
        </div>

        <div class="kpi-box">
            <h3>Uso de Residuos</h3>
            <p><?= $porcentaje_residuos ?>%</p>
        </div>

        <div class="kpi-box">
            <h3>Impacto Ambiental</h3>
            <p><?= $impacto ?></p>
        </div>

    </div>

    <!-- GRÁFICAS -->

    <div class="chart-grid">

    <div class="chart-box">
        <h3>Organizaciones por Municipio</h3>
        <canvas id="graficoMunicipio"></canvas>
    </div>

    <div class="chart-box">
        <h3>Tipo de Comunidad</h3>
        <canvas id="graficoComunidad"></canvas>
    </div>

    <div class="chart-box">
        <h3>Estado del Emprendimiento</h3>
        <canvas id="graficoEstado"></canvas>
    </div>

</div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function(){

    // MUNICIPIOS
    const ctx1 = document.getElementById('graficoMunicipio');

    if(ctx1){
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
    }

    // COMUNIDAD
    const ctx2 = document.getElementById('graficoComunidad');

    if(ctx2){
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
    }

    // ESTADO
    const ctx3 = document.getElementById('graficoEstado');

    if(ctx3){
        new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($labels_estado) ?>,
                datasets: [{
                    data: <?= json_encode($data_estado) ?>
                }]
            },
            options: {
                responsive: true
            }
        });
    }

});
</script>