<?php

include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["idStudent"]) && isset($_POST["nombre"]) && isset($_POST["Apellido"]) && isset($_POST["texto"]) && isset($_POST["audio"]) && isset($_POST["video"])) {

    $idStudent = $_POST["idStudent"];
    $nombre = $_POST["nombre"];
    $Apellido = $_POST["Apellido"];
    $texto = $_POST["texto"];
    $audio = $_POST["audio"];
    $video = $_POST["video"];

    $query = "UPDATE `Alumno` SET `nombre`=?, `Apellido`=?, `texto`=?, `audio`=?, `video`=? WHERE `id`=?";

    $stmt = mysqli_prepare($con, $query);
        
    mysqli_stmt_bind_param($stmt, "ssiiii", $nombre, $Apellido, $texto, $audio, $video, $idStudent);    

    $exe = mysqli_stmt_execute($stmt);

    $arr = [];

    if ($exe) {
            $arr["success"] = "true";
    } else {
            $arr["success"] = "false";
            $arr["error"] = mysqli_error($con);
    }

        mysqli_stmt_close($stmt);

} else {
    $arr["success"] = "false";
}