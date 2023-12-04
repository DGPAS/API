<?php

include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["idTasks"])) {

    $idTasks = $_POST["idTasks"];

    if (isset($_POST["name"]) && isset($_POST["description"])) {
        $name = $_POST["name"];
        $description = $_POST["description"];

        $query = "UPDATE `tareas` SET `name`=?, `description`=? WHERE `idTasks`=?";

        $stmt = mysqli_prepare($con, $query);
        
        mysqli_stmt_bind_param($stmt, "ssi", $name, $description, $idTasks);
    }
    else if (isset($_POST["name"])) {
        $name = $_POST["name"];

        $query = "UPDATE `tareas` SET `name`=? WHERE `idTasks`=?";

        $stmt = mysqli_prepare($con, $query);
        
        mysqli_stmt_bind_param($stmt, "si", $name, $idTasks);
    }
    
    else {
        $description = $_POST["description"];

        $query = "UPDATE `tasks` SET `description`=? WHERE `idTasks`=?";

        $stmt = mysqli_prepare($con, $query);
        
        mysqli_stmt_bind_param($stmt, "si", $description, $idTasks);
    }

    if (isset($_POST["name"]) || isset($_POST["description"])) {

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