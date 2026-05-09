<?php

if (!session_id()) {
    session_start();
}

global $wpdb;

$user = $_SESSION['aec_user'];

$tabla = $wpdb->prefix . 'organizaciones';


// =========================
// FILTRO POR ROL
// =========================

$where = "";

if($user['rol'] == 'LIM'){

    $where = "WHERE creado_por = " . intval($user['id']);

}


// =========================
// CONSULTAR ORGANIZACIONES
// =========================

$resultados = $wpdb->get_results("
    SELECT *
    FROM $tabla
    $where
    ORDER BY id DESC
");

?>

<div class="aec-container">

    <h2>Organizaciones Registradas</h2>

    <a href="?modulo=organizaciones&nuevo=1" class="btn btn-primary">
        Nuevo registro
    </a>

    <table border="1" width="100%">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Municipio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($resultados as $row): ?>

                <tr>

                    <td><?= $row->id ?></td>

                    <td><?= $row->nombre ?></td>

                    <td><?= $row->municipio ?></td>

                    <td>

                        <a href="?modulo=organizaciones&edit=<?= $row->id ?>&paso=1"
                           class="aec-btn">
                            Editar
                        </a>

                        <a href="?modulo=organizaciones&delete=<?= $row->id ?>"
                           onclick="return confirm('¿Eliminar?')">
                            Eliminar
                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>