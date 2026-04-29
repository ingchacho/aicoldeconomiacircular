<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo ?? 'Sistema AICOLD'; ?></title>

    <link rel="stylesheet" href="<?php echo AEC_URL . 'assets/css/style.css'; ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<header class="aec-header">
    <h2>AICOLD</h2>
</header>

<div class="aec-layout">

    <aside class="aec-sidebar">
        <ul>
            <li><a href="aicold/wordpress-6.9.4/wordpress/index.php/kpi">📈 KPI</a></li>
            <li><a href="/aicold/wordpress-6.9.4/wordpress/index.php/dashboard/">📊 Dashboard</a></li>
        </ul>
    </aside>

    <main class="aec-content">
        <?php echo $contenido ?? ''; ?>
    </main>

</div>

</body>
</html>