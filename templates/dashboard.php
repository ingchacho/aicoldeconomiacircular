
<?php
    if (!session_id()) session_start();
    if(!isset($_SESSION['aec_user'])){
        header("Location: ?page_id=5"); // página login
        exit;
    }
    $user = $_SESSION['aec_user'];
    global $wpdb;
    $tabla = $wpdb->prefix . 'organizaciones';
    // 🔥 FILTRO POR USUARIO
    $where = "WHERE 1=1";

    if($user['rol'] == 'LIM'){
        $where .= " AND creado_por = " . intval($user['id']);
    }

    // 🔥 ELIMINAR (solo si tiene permiso)
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']);

        if($user['rol'] == 'ADMIN'){
            $wpdb->delete($tabla, ['id' => $id]);
        } else {
            // 🔥 LIM solo elimina lo suyo
            $wpdb->delete($tabla, [
                'id' => $id,
                'creado_por' => $user['id']
            ]);
        }
        echo "<p style='color:red;'>Registro eliminado</p>";
    }
    // 🔥 LISTAR (YA FILTRADO)
    $where = "";
    if($user['rol'] == 'LIM'){
        $where = "WHERE creado_por = " . intval($user['id']);
    }
    $resultados = $wpdb->get_results("SELECT * FROM $tabla $where ORDER BY id DESC");
?>

    <div class="aec-container">
        <h2>Organizaciones Registradas</h2>
        
        <a href="?nuevo=1" class="btn btn-primary">
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
                        <a href="?edit=<?= $row->id ?>&paso=1" class="aec-btn">Editar</a>

                        <a href="?delete=<?= $row->id ?>" 
                        onclick="return confirm('¿Eliminar?')">
                        Eliminar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


<!-- 🔥 MODAL -->
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


<?php if (isset($_GET['nuevo'])): ?>
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
        const url = new URL(window.location.href);
        url.searchParams.delete('edit');
        url.searchParams.delete('paso');
        window.history.replaceState({}, document.title, url.pathname);
    }
    function nuevoRegistro() {
        fetch('<?= admin_url("admin-ajax.php") ?>', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'aec_reset_session'
            })
        }).then(() => {
            step = 1;
            document.getElementById('wizardForm').reset();
            showStep(1);
            toggleButtons(1);
            abrirModal();
        });
    }    
</script>

