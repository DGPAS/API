<?php

include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["idTasks"])) {

    $idTasks = $_POST["idTasks"];

    if (isset($_POST["taskName"]) && isset($_POST["description"])) {
        $taskName = $_POST["taskName"];
        $description = $_POST["description"];

        $query = "UPDATE `tasks` SET `taskName`=?, `description`=? WHERE `idTasks`=?";

        $stmt = mysqli_prepare($con, $query);
        
        mysqli_stmt_bind_param($stmt, "ssi", $taskName, $description, $idTasks);
    }
    else if (isset($_POST["taskName"])) {
        $taskName = $_POST["taskName"];

        $query = "UPDATE `tareas` SET `taskName`=? WHERE `idTasks`=?";

        $stmt = mysqli_prepare($con, $query);
        
        mysqli_stmt_bind_param($stmt, "si", $taskName, $idTasks);
    }
    
    else {
        $description = $_POST["description"];

        $query = "UPDATE `tasks` SET `description`=? WHERE `idTasks`=?";

        $stmt = mysqli_prepare($con, $query);
        
        mysqli_stmt_bind_param($stmt, "si", $description, $idTasks);
    }

    if (isset($_POST["taskName"]) || isset($_POST["description"])) {

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