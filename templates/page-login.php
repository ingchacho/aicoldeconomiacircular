<div class="aec-login">

    <h2>Iniciar Sesión</h2>

    <form method="POST">

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Contraseña</label>
        <input type="password" name="password" required>

        <button type="submit">Ingresar</button>

    </form>

</div>

<?php include AEC_PATH . 'includes/auth/login.php'; ?>