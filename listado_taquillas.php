<?php
require "connection.php";
$conexion = conectarBD();
// Iniciamos sesion
session_start();

// Creamos ua variable para guardar la localidad seleccionada
$selectedLocalidad = '';

// Si existe la variable de sesion localidad, la guardamos en la variable $selectedLocalidad
if (isset($_SESSION['localidad'])) {
    $selectedLocalidad = $_SESSION['localidad'];
}



?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>Taquillator</title>
</head>

<body>
    <form action="" method="get">
        <select name="localidad">
            <option value="">Todas las localidades</option>
            <option value="Gijón" <?= $selectedLocalidad == 'Gijón' ? 'selected' : ''; ?>>Gijón</option>
            <option value="Oviedo" <?= $selectedLocalidad == 'Oviedo' ? 'selected' : ''; ?>>Oviedo</option>
            <option value="Avilés" <?= $selectedLocalidad == 'Avilés' ? 'selected' : ''; ?>>Avilés</option>
        </select>
        <input type="submit" value="Buscar">
    </form>

</body>

</html>



<?php
if (isset($_GET['localidad'])) {
    ////////////////////////////////////////////
    // TODO 2: Obtener taquillas según filtro //
    ////////////////////////////////////////////
    // Guardamos en la variable $selectedLocalidad el valor de la localidad seleccionada y tambien lo guardamos en la variable de sesion localidad
    $selectedLocalidad = $_GET['localidad'];
    $_SESSION['localidad'] = $selectedLocalidad;

    $sql = "SELECT * FROM puntosderecogida";
    if ($selectedLocalidad !== '') {
        $sql .= " WHERE localidad = ?";
        $resultado = $conexion->prepare($sql);
        $resultado->execute([$selectedLocalidad]);
    } else {
        $resultado = $conexion->query($sql);
    }



    if ($resultado->rowCount() > 0) {
        echo "<table><tr><th>Localidad</th><th>Dirección</th><th>Capacidad</th><th>Ocupadas</th></tr>";
        /////////////////////////////////////
        // TODO 3: Imprimir filas de tabla //
        /////////////////////////////////////
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
            if ($row['ocupadas'] !== $row['capacidad']) {
                echo "<tr><td>" . htmlspecialchars($row["localidad"]) . "</td><td>" . htmlspecialchars($row["direccion"]) . "</td><td>" . htmlspecialchars($row["capacidad"]) . "</td><td>" . htmlspecialchars($row["ocupadas"]) . "</td></tr>";
            }
        }
        echo "</table>";
    } else {
        echo "No hay resultados";
    }
}
?>