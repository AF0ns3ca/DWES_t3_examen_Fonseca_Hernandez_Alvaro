<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Añadir Nueva Taquilla</title>
</head>

<body>
    <h2>Añadir Nueva Taquilla</h2>
    <form action="nueva_taquilla.php" method="post">
        <label for="localidad">Localidad:</label><br>
        <select id="localidad" name="localidad" required>
            <option value="">Seleccione una localidad</option>
            <option value="Gijón">Gijón</option>
            <option value="Oviedo">Oviedo</option>
            <option value="Avilés">Avilés</option>
        </select><br>

        <label for="direccion">Dirección:</label><br>
        <input type="text" id="direccion" name="direccion" required><br>

        <label for="capacidad">Capacidad:</label><br>
        <input type="number" id="capacidad" name="capacidad" min="1" required><br>

        <label for="ocupadas">Taquillas Ocupadas:</label><br>
        <input type="number" id="ocupadas" name="ocupadas" min="0" required><br>

        <input type="submit" value="Añadir Taquilla">
    </form>
</body>

</html>


<?php
require_once 'connection.php';
$conexion = conectarBD();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $consulta = $conexion->prepare("INSERT INTO puntosderecogida (localidad, direccion, capacidad, ocupadas) VALUES (:localidad, :direccion, :capacidad, :ocupadas)");
    $consulta->bindParam(':localidad', $_POST['localidad']);
    $consulta->bindParam(':direccion', $_POST['direccion']);
    $consulta->bindParam(':capacidad', $_POST['capacidad']);
    $consulta->bindParam(':ocupadas', $_POST['ocupadas']);
    /////////////////////////////////////////////////
    // TODO 1:Guardar la info en la base de datos. //
    /////////////////////////////////////////////////

    //Comprobamos que no podemos añadir mas taquillas ocupadas que la capacidad de la taquilla
    if($_POST['capacidad'] >= $_POST['ocupadas']){
        if ($consulta->execute()) {
            echo "Nueva taquilla añadida con éxito.";
        } else {
            echo "Error al añadir la taquilla.";
        }
    } else {
        echo "Error al añadir la taquilla. La capacidad no puede ser menor que las taquillas ocupadas.";}
    
}
?>