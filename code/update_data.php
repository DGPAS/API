<?php

include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["idTareas"])) {

    $idTareas = $_POST["idTareas"];

    if (isset($_POST["nombre"]) && isset($_POST["descripcion"])) {
        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];

        $query = "UPDATE `tareas` SET `nombre`=?, `descripcion`=? WHERE `idTareas`=?";

        $stmt = mysqli_prepare($con, $query);
        
        mysqli_stmt_bind_param($stmt, "ssi", $nombre, $descripcion, $idTareas);
    }
    else if (isset($_POST["nombre"])) {
        $nombre = $_POST["nombre"];

        $query = "UPDATE `tareas` SET `nombre`=? WHERE `idTareas`=?";

        $stmt = mysqli_prepare($con, $query);
        
        mysqli_stmt_bind_param($stmt, "si", $nombre, $idTareas);
    }
    
    else {
        $descripcion = $_POST["descripcion"];

        $query = "UPDATE `tareas` SET `descripcion`=? WHERE `idTareas`=?";

        $stmt = mysqli_prepare($con, $query);
        
        mysqli_stmt_bind_param($stmt, "si", $descripcion, $idTareas);
    }

    if (isset($_POST["nombre"]) || isset($_POST["descripcion"])) {

        $exe = mysqli_stmt_execute($stmt);

        $arr = [];

        if ($exe) {
            $arr["success"] = "true";
        } else {
            $arr["success"] = "false";
            $arr["error"] = mysqli_error($con);
        }

        mysqli_stmt_close($stmt);
    }
} else {
    $arr["success"] = "false";
}