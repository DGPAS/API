<?php

include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["idTareas"])) {

    $idTareas = $_POST["idTareas"];

    if (isset($_POST["nombre"]) && isset($_POST["descripcion"])) {
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];

        $query = "UPDATE `tareas` SET `nombre`='$nombre',`descripcion`='$descripcion' WHERE `idTareas`=$idTareas";
    }
    else if (isset($_POST["nombre"])) {
        $nombre = $_POST["nombre"];

        $query = "UPDATE `tareas` SET `nombre`='$nombre' WHERE `idTareas`=$idTareas";
    }
    
    else {
        $descripcion = $_POST["descripcion"];

        $query = "UPDATE `tareas` SET `descripcion`='$descripcion' WHERE `idTareas`=$idTareas";
    }

    if (isset($_POST["nombre"]) || isset($_POST["descripcion"])) {

        $exe = mysqli_query($con, $query);

        $arr = [];

        if ($exe) {
            $arr["success"] = "true";
        } else {
            $arr["success"] = "false";
            $arr["error"] = mysqli_error($con);
        }
    }
} else {
    $arr["success"] = "false";
}