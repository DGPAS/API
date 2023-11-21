<?php
include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_POST["miniatura"]) && isset($_POST["video"])) {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $miniatura = $_POST["miniatura"];
    $video = $_POST["video"];

    $query = "INSERT INTO `tareas`(`nombre`, `descripcion`, `miniatura`, `video`) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($con, $query);

    mysqli_stmt_bind_param($stmt, "ssss", $nombre, $descripcion, $miniatura, $video);

    $exe = mysqli_stmt_execute($stmt);

    $arr = [];

    if ($exe) {
        $arr["success"] = "true";
        $arr["idTareas"] = mysqli_insert_id($con); // Añade al array el idTareas (mysqli_insert_id devuelve el valor de una columna AUTO_INCREMENT actualizada, en nuestro caso idTareas)
    } else {
        $arr["success"] = "false";
        $arr["error"] = mysqli_error($con);
    }

    mysqli_stmt_close($stmt);

} else {
    $arr["success"] = "false";
}

print(json_encode($arr));
?>
