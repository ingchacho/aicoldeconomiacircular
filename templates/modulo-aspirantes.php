<?php

global $wpdb;

$tabla = $wpdb->prefix . 'aec_aspirantes';

$aspirantes = $wpdb->get_results("
    SELECT * 
    FROM $tabla 
    ORDER BY id DESC
");

?>

<div class="aec-container">

    <h2>Aspirantes registrados</h2>

    <table border="1" width="100%">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach($aspirantes as $a): ?>

            <tr>

                <td><?= $a->id ?></td>

                <td><?= $a->nombre ?></td>

                <td><?= $a->email ?></td>

                <td><?= $a->estado ?></td>

                <td>

                    <?php if($a->estado == 'PENDIENTE'): ?>

                        <a href="?modulo=aspirantes&aprobar=<?= $a->id ?>" class="aec-btn">
                            Aprobar
                        </a>

                    <?php else: ?>

                        ✔ Aprobado

                    <?php endif; ?>

                </td>

            </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>