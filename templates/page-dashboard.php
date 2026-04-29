<?php

ob_start();
include AEC_PATH . 'templates/dashboard.php';
$contenido = ob_get_clean();

$titulo = "Dashboard";

include AEC_PATH . 'templates/layout.php';