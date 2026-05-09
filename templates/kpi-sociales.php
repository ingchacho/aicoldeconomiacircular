<?php

global $wpdb;

// TABLAS
$tabla_org = $wpdb->prefix . 'organizaciones';
$tabla_asp = $wpdb->prefix . 'aec_aspirantes';
$tabla_usr = $wpdb->prefix . 'aec_usuarios';


// =====================================
// KPI 1 — TOTAL ORGANIZACIONES
// =====================================

$total_org = $wpdb->get_var("
    SELECT COUNT(*)
    FROM $tabla_org
");


// =====================================
// KPI 2 — ASPIRANTES
// =====================================

$total_asp = $wpdb->get_var("
    SELECT COUNT(*)
    FROM $tabla_asp
");


// =====================================
// KPI 3 — USUARIOS APROBADOS
// =====================================

$total_usr = $wpdb->get_var("
    SELECT COUNT(*)
    FROM $tabla_usr
");


// =====================================
// KPI 4 — REGISTROS PENDIENTES
// =====================================

$pendientes = $wpdb->get_var("
    SELECT COUNT(*)
    FROM $tabla_asp
    WHERE estado = 'PENDIENTE'
");


// =====================================
// GRÁFICA — COMUNIDADES
// =====================================

$comunidades = $wpdb->get_results("
    SELECT enfoque, COUNT(*) as total
    FROM $tabla_org
    GROUP BY enfoque
");

$labels_comunidad = [];
$data_comunidad = [];

foreach($comunidades as $c){

    $labels_comunidad[] = $c->enfoque ?: 'Sin definir';
    $data_comunidad[] = $c->total;
}


// =====================================
// GRÁFICA — MUNICIPIOS
// =====================================

$municipios = $wpdb->get_results("
    SELECT municipio, COUNT(*) as total
    FROM $tabla_org
    GROUP BY municipio
");

$labels_municipio = [];
$data_municipio = [];

foreach($municipios as $m){

    $labels_municipio[] = $m->municipio;
    $data_municipio[] = $m->total;
}

?>


<style>
    /* =========================
    KPI MODERNOS
    ========================= */

    /* =========================
KPI MODERNOS
========================= */

.kpi-grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit, minmax(280px,1fr));

    gap:25px;

    margin-top:30px;
}


/* CARD */

.kpi-card{

    position:relative;

    overflow:hidden;

    border-radius:24px;

    padding:30px;

    min-height:180px;

    color:white;

    box-shadow:
    0 15px 40px rgba(0,0,0,.12);

    transition:.35s ease;

    display:flex;

    flex-direction:column;

    justify-content:space-between;
}


.kpi-card:hover{

    transform:
    translateY(-8px)
    scale(1.02);

    box-shadow:
    0 25px 50px rgba(0,0,0,.18);
}


/* ICONO */

.kpi-icon{

    font-size:55px;

    opacity:.9;

    margin-bottom:10px;
}


/* TITULO */

.kpi-card h3{

    font-size:18px;

    font-weight:600;

    margin-bottom:15px;
}


/* VALOR */

.kpi-card p{

    font-size:52px;

    font-weight:900;

    line-height:1;
}


/* COLORES DIFERENTES */

.kpi-card:nth-child(1){

    background:
    linear-gradient(135deg,#0f2027,#203a43,#2c5364);
}

.kpi-card:nth-child(2){

    background:
    linear-gradient(135deg,#11998e,#38ef7d);
}

.kpi-card:nth-child(3){

    background:
    linear-gradient(135deg,#fc4a1a,#f7b733);
}

.kpi-card:nth-child(4){

    background:
    linear-gradient(135deg,#8e2de2,#4a00e0);
}

    .kpi-card:hover {
        transform: translateY(-5px);
    }

    .kpi-icon {
        font-size: 40px;
        display: block;
        margin-bottom: 15px;
    }

    .kpi-card h3 {
        font-size: 18px;
        margin-bottom: 10px;
        color: #333;
    }

    .kpi-card p {
        font-size: 40px;
        font-weight: bold;
        color: #2e7d32;
    }



    /* =========================
    GRÁFICAS KPI
    ========================= */

    .chart-grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(400px,1fr));
        gap:25px;
        margin-top:40px;
    }

    .chart-card{
        background:white;
        padding:25px;
        border-radius:20px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
    }

    .chart-card h3{
        margin-bottom:20px;
    }
</style>


<div class="aec-container">

    <h1>👥 KPI Sociales</h1>

    <!-- KPI CARDS -->
    <div class="kpi-grid">

        <div class="kpi-card">
            <span class="kpi-icon">🏢</span>
            <h3>Organizaciones</h3>
            <p><?= $total_org ?></p>
        </div>

        <div class="kpi-card">
            <span class="kpi-icon">📝</span>
            <h3>Aspirantes</h3>
            <p><?= $total_asp ?></p>
        </div>

        <div class="kpi-card">
            <span class="kpi-icon">✅</span>
            <h3>Usuarios Aprobados</h3>
            <p><?= $total_usr ?></p>
        </div>

        <div class="kpi-card">
            <span class="kpi-icon">⏳</span>
            <h3>Pendientes</h3>
            <p><?= $pendientes ?></p>
        </div>

    </div>


    <!-- GRÁFICAS -->
    <div class="chart-grid">

        <div class="chart-card">

            <h3>
                👥 Tipo de Comunidad
            </h3>

            <canvas id="chartComunidad"></canvas>

        </div>

        <div class="chart-card">

            <h3>
                🗺️ Cobertura Territorial
            </h3>

            <canvas id="chartMunicipios"></canvas>

        </div>

    </div>

</div>


<script>
    document.addEventListener("DOMContentLoaded", function(){
        // COMUNIDADES
        new Chart(document.getElementById('chartComunidad'), {
            type:'doughnut',
            data:{
                labels: <?= json_encode($labels_comunidad) ?>,
                datasets:[{
                    data: <?= json_encode($data_comunidad) ?>
                }]
            }
        });

        // MUNICIPIOS
        new Chart(document.getElementById('chartMunicipios'), {
            type:'bar',
            data:{
                labels: <?= json_encode($labels_municipio) ?>,
                datasets:[{
                    label:'Organizaciones',
                    data: <?= json_encode($data_municipio) ?>
                }]
            }
        });
    });
</script>