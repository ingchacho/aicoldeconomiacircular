<div class="aec-container">
    <h2>👤 Mi Perfil</h2>

    <div class="aec-card">
        <p><strong>Nombre:</strong> <?= $user['nombre'] ?? '' ?></p>
        <p><strong>Email:</strong> <?= $user['email'] ?? '' ?></p>
        <p><strong>Rol:</strong> <?= $user['rol'] ?? '' ?></p>
    </div>
</div>