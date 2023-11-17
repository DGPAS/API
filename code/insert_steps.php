<?php
include("dbconnection.php");
$con = dbconnection();

$arr = [];

if (!$con) {
    $arr["success"] = "false";
    $arr["error"] = "Error de conexión a la base de datos";
} elseif (isset($_POST["idTarea"]) && isset($_POST["descripcion"]) && isset($_POST["imagen"]) && isset($_POST["video"])) {
    $idTarea = $_POST["idTarea"];
    $descripcion = $_POST["descripcion"];
    $imagen = $_POST["imagen"];
    $video = $_POST["video"];

    // Sentencia preparada
    $query = "INSERT INTO `pasos`(`descripcion`, `imagen`, `video`, `idTarea`) VALUES (?, ?, ?, ?)";

    // Preparar la sentencia
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        // Vincular parámetros
        mysqli_stmt_bind_param($stmt, "sssi", $descripcion, $imagen, $video, $idTarea);

        // Ejecutar la sentencia
        $exe = mysqli_stmt_execute($stmt);

        if ($exe) {
            $arr["success"] = "true";
        } else {
            $arr["success"] = "false";
            $arr["error"] = "Error en la inserción: " . mysqli_stmt_error($stmt);
        }

        // Cerrar la sentencia preparada
        mysqli_stmt_close($stmt);
    } else {
        $arr["success"] = "false";
        $arr["error"] = "Error en la preparación de la sentencia: " . mysqli_error($con);
    }
} else {
    $arr["success"] = "false";
    $arr["error"] = "Parámetros insuficientes";
}

print(json_encode($arr));
?>
