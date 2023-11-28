<?php
include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["nombre"]) && isset($_POST["Apellido"]) && isset($_POST["foto"]) && isset($_POST["texto"]) && isset($_POST["audio"]) && isset($_POST["video"])) {
    $nombre = $_POST["nombre"];
    $Apellido = $_POST["Apellido"];
    $foto = $_POST["foto"];
    $texto = $_POST["texto"];
    $audio = $_POST["audio"];
    $video = $_POST["video"];

    $query = "INSERT INTO `Alumno`(`nombre`, `Apellido`, `foto`, `texto`, `audio`, `video`) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $query);

    mysqli_stmt_bind_param($stmt, "sssiii", $nombre, $Apellido, $foto, $texto, $audio, $video);


    $exe = mysqli_stmt_execute($stmt);

    $arr = [];

    if ($exe) {
        $arr["success"] = "true";
        $arr["idStudent"] = mysqli_insert_id($con); // Añade al array el idTareas (mysqli_insert_id devuelve el valor de una columna AUTO_INCREMENT actualizada, en nuestro caso idTareas)

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
