<?php
include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["nombre"]) && isset($_POST["realizada"]) && isset($_POST["descripcion"])) {
    $nombre = $_POST["nombre"];
    $realizada = $_POST["realizada"] === "1" ? 1 : 0;
    $descripcion = $_POST["descripcion"];

    $query = "INSERT INTO `tareas`(`nombre`, `realizada`, `descripcion`) VALUES ('$nombre', $realizada, '$descripcion')";

    $exe = mysqli_query($con, $query);

    $arr = [];

    if ($exe) {
        $arr["success"] = "true";
        $arr["idTareas"] = mysqli_insert_id($con); // Añade al array el idTareas (mysqli_insert_id devuelve el valor de una columna AUTO_INCREMENT actualizada, en nuestro caso idTareas)
    } else {
        $arr["success"] = "false";
        $arr["error"] = mysqli_error($con);
    }
} else {
    $arr["success"] = "false";
}

print(json_encode($arr));
?>
