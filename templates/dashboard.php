<?php
global $wpdb;
$tabla = $wpdb->prefix . 'organizaciones';

// ELIMINAR
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $wpdb->delete($tabla, ['id' => $id]);
    echo "<p style='color:red;'>Registro eliminado</p>";
}

// LISTAR
$resultados = $wpdb->get_results("SELECT * FROM $tabla ORDER BY id DESC");
?>

<div class="aec-container">

    <h2>Organizaciones Registradas</h2>

    <button onclick="abrirModal()">+ Agregar</button>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Territorio</th>
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
                    <a href="?edit=<?= $row->id ?>&paso=1" class="aec-btn">Editar</a>
                    <a href="?delete=<?= $row->id ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>


<div id="modalForm" class="aec-modal">
    <div class="aec-modal-content">
        <span onclick="cerrarModal()" class="close">&times;</span>

        <?php include AEC_PATH . 'templates/registro.php'; ?>

    </div>
</div>

<?php if (isset($_GET['edit'])): ?>
    <script>
    document.addEventListener("DOMContentLoaded", function(){
        abrirModal();
    });
    </script>
<?php endif; ?>

<script>
    function abrirModal(){
        document.getElementById("modalForm").classList.add("active");
    }

    function cerrarModal(){
        document.getElementById("modalForm").classList.remove("active");
    }
</script>

<script>
