<div class="aec-container">
    <h2>Registro de Organización</h2>

    <form method="POST">

        <label>Nombre de la organización</label>
        <input type="text" name="nombre" required>

        <label>Territorio</label>
        <input type="text" name="territorio" required>

        <label>Tipo de comunidad</label>
        <select name="comunidad">
            <option value="Afrocolombiana">Afrocolombiana</option>
            <option value="Indígena">Indígena</option>
            <option value="Raizal">Raizal</option>
            <option value="Palenquera">Palenquera</option>
        </select>

        <label>Actividad ambiental</label>
        <textarea name="actividad"></textarea>

        <button type="submit">Registrar</button>

    </form>
</div>