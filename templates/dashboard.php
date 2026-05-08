<?php
    $modulo = $_GET['modulo'] ?? 'home';
?>

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




    <?php

        if (isset($_GET['aprobar']) && $user['rol'] == 'ADMIN') {

            global $wpdb;

            $id = intval($_GET['aprobar']);

            $tabla_asp = $wpdb->prefix . 'aec_aspirantes';
            $tabla_usr = $wpdb->prefix . 'aec_usuarios';

            // 🔥 Obtener aspirante
            $asp = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT * FROM $tabla_asp WHERE id = %d",
                    $id
                )
            );

            // 🔥 VALIDAR
            if ($asp && $asp->estado == 'PENDIENTE') {

                // 🔐 PASSWORD TEMPORAL
                $password_plano = wp_generate_password(8, false);

                // 🔐 HASH
                $password_hash = password_hash($password_plano, PASSWORD_DEFAULT);

                // 👤 CREAR USUARIO
                $wpdb->insert($tabla_usr, [
                    'nombre' => $asp->nombre,
                    'email' => $asp->email,
                    'password' => $password_hash,
                    'rol' => 'LIM',
                    'estado' => 'ACTIVO',
                    'fecha' => current_time('mysql')
                ]);

                // 🔄 ACTUALIZAR ASPIRANTE
                $wpdb->update(
                    $tabla_asp,
                    [
                        'estado' => 'APROBADO'
                    ],
                    [
                        'id' => $id
                    ]
                );

                // 🔥 CORREO
                $destino = $asp->email;

                $asunto = 'Credenciales de acceso - Plataforma AICOLD';

                $login_url = home_url('/login');

                $mensaje = '
                <div style="font-family:Arial;padding:20px;background:#f5f5f5;">
                    
                    <div style="
                        max-width:600px;
                        margin:auto;
                        background:white;
                        padding:30px;
                        border-radius:10px;
                    ">

                        <h2 style="color:#2e7d32;">
                            Bienvenido a la Plataforma AICOLD
                        </h2>

                        <p>
                            Su solicitud ha sido aprobada exitosamente.
                        </p>

                        <p>
                            Ya puede ingresar al sistema con las siguientes credenciales:
                        </p>

                        <table style="width:100%;border-collapse:collapse;">
                            <tr>
                                <td style="padding:10px;">
                                    <strong>Usuario:</strong>
                                </td>

                                <td style="padding:10px;">
                                    '.$asp->email.'
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:10px;">
                                    <strong>Contraseña:</strong>
                                </td>

                                <td style="padding:10px;">
                                    '.$password_plano.'
                                </td>
                            </tr>
                        </table>

                        <div style="margin-top:30px;text-align:center;">

                            <a href="'.$login_url.'" 
                            style="
                                background:#2e7d32;
                                color:white;
                                padding:14px 25px;
                                text-decoration:none;
                                border-radius:5px;
                                display:inline-block;
                            ">
                                Ingresar al sistema
                            </a>

                        </div>

                        <p style="
                            margin-top:30px;
                            font-size:12px;
                            color:#777;
                        ">
                            Plataforma AICOLD · Economía Circular
                        </p>

                    </div>

                </div>
                ';

                // 🔥 HEADERS HTML
                $headers = array(
                    'Content-Type: text/html; charset=UTF-8'
                );

                // 🔥 ENVIAR
                $enviado = wp_mail(
                    $destino,
                    $asunto,
                    $mensaje,
                    $headers
                );

                // 🔥 MENSAJE FINAL
                if ($enviado) {

                    echo '
                    <div style="
                        background:#d4edda;
                        color:#155724;
                        padding:15px;
                        border-radius:5px;
                        margin-bottom:20px;
                    ">
                        ✅ Usuario aprobado y correo enviado correctamente.
                    </div>
                    ';

                } else {

                    echo '
                    <div style="
                        background:#f8d7da;
                        color:#721c24;
                        padding:15px;
                        border-radius:5px;
                        margin-bottom:20px;
                    ">
                        ⚠ Usuario creado, pero el correo NO pudo enviarse.
                    </div>
                    ';
                }
            }
        }

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




<?php if($modulo == 'aspirantes'): ?>

    <h2>Aspirantes registrados</h2>

    <?php
    global $wpdb;
    $tabla = $wpdb->prefix . 'aec_aspirantes';

    $aspirantes = $wpdb->get_results("SELECT * FROM $tabla ORDER BY id DESC");
    ?>

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

<?php endif; ?>




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

