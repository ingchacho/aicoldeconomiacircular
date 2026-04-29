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

    $total = $wpdb->get_var("SELECT COUNT(*) FROM $tabla $where");

    $por_municipio = $wpdb->get_results("
        SELECT municipio, COUNT(*) as total 
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
            END as enfoque,
            COUNT(*) as total 
        FROM $tabla 
        $where
        GROUP BY enfoque
    ");


    $uso_residuos = $wpdb->get_var("
        SELECT COUNT(*) FROM $tabla 
        $where AND usa_residuos = 'SI'
    ");

    $porcentaje_residuos = $total > 0 ? round(($uso_residuos / $total) * 100) : 0;


    $impacto = $wpdb->get_var("
        SELECT COUNT(*) FROM $tabla 
        $where AND problema_ambiental IS NOT NULL 
        AND problema_ambiental != ''
    ");


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
        <div id="aec-loader" class="aec-loader">
            <div class="spinner"></div>
        </div>

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


        <button onclick="exportarExcel()">Exportar Excel</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        let graficoMunicipio;
        let graficoComunidad;
        let graficoEstado;

        document.addEventListener("DOMContentLoaded", function(){

            graficoMunicipio = crearGrafico('graficoMunicipio', 'bar', 
                <?= json_encode($labels_municipio) ?>,
                <?= json_encode($data_municipio) ?>
            );

            graficoComunidad = crearGrafico('graficoComunidad', 'pie',
                <?= json_encode($labels_comunidad) ?>,
                <?= json_encode($data_comunidad) ?>
            );

            graficoEstado = crearGrafico('graficoEstado', 'doughnut',
                <?= json_encode($labels_estado) ?>,
                <?= json_encode($data_estado) ?>
            );

        });

        function crearGrafico(id, tipo, labels, data){
            return new Chart(document.getElementById(id), {
                type: tipo,
                data: {
                    labels: labels,
                    datasets: [{
                        data: data
                    }]
                }
            });
        }

        function actualizarGrafico(chart, datos, campo){

            const labels = datos.map(d => d[campo]);
            const values = datos.map(d => d.total);

            chart.data.labels = labels;
            chart.data.datasets[0].data = values;
            chart.update();
        }

    </script>
    <script>
        const ajaxUrl = "<?= admin_url('admin-ajax.php') ?>";

        // detectar cambios
        document.querySelectorAll('.aec-filtros select').forEach(select => {
            select.addEventListener('change', filtrarKPI);
        });


        function filtrarKPI(){

            document.getElementById('aec-loader').style.display = 'flex';

            const form = document.querySelector('.aec-filtros');
            const data = new FormData(form);
            data.append('action', 'aec_filtrar_kpi');

            fetch(ajaxUrl, {
                method: 'POST',
                body: data
            })
            .then(res => res.json())
            .then(data => {

                document.getElementById('aec-loader').style.display = 'none';

                // document.querySelector('.kpi-box p').innerText = data.total;

                animarKPI(document.querySelector('.kpi-box p'), data.total);

                actualizarGrafico(graficoMunicipio, data.municipios, 'municipio');
                actualizarGrafico(graficoComunidad, data.comunidad, 'enfoque');
                actualizarGrafico(graficoEstado, data.estado, 'estado_iniciativa');

            });
        }

        function exportarExcel(){

            const params = new URLSearchParams(new FormData(document.querySelector('.aec-filtros')));

            window.open("<?= admin_url('admin-ajax.php') ?>?action=aec_exportar_excel&" + params);
        }

        function animarKPI(elemento, valor){

            let inicio = 0;
            let intervalo = setInterval(() => {

                inicio += Math.ceil(valor / 20);
                if(inicio >= valor){
                    inicio = valor;
                    clearInterval(intervalo);
                }

                elemento.innerText = inicio;

            }, 50);
        }

    </script>




