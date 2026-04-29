<?php

ob_start();
include AEC_PATH . 'templates/kpi.php';
$contenido = ob_get_clean();

$titulo = "KPI";

include AEC_PATH . 'templates/layout.php';