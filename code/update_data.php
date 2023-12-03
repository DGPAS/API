<?php

include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["idTareas"])) {

    $idTasks = $_POST["idTareas"];

    if (isset($_POST["nombre"]) && isset($_POST["descripcion"])) {
        $name = $_POST["nombre"];
        $description = $_POST["descripcion"];

        $query = "UPDATE `tareas` SET `nombre`=?, `descripcion`=? WHERE `idTareas`=?";

        $stmt = mysqli_prepare($con, $query);
        
        mysqli_stmt_bind_param($stmt, "ssi", $name, $description, $idTasks);
    }
    else if (isset($_POST["nombre"])) {
        $name = $_POST["nombre"];

        $query = "UPDATE `tareas` SET `nombre`=? WHERE `idTareas`=?";

        $stmt = mysqli_prepare($con, $query);
        
        mysqli_stmt_bind_param($stmt, "si", $name, $idTasks);
    }
    
    else {
        $description = $_POST["descripcion"];

        $query = "UPDATE `tareas` SET `descripcion`=? WHERE `idTareas`=?";

        $stmt = mysqli_prepare($con, $query);
        
        mysqli_stmt_bind_param($stmt, "si", $description, $idTasks);
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