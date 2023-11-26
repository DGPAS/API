<?php

include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["steps"]) && isset($_POST["idTarea"])) {
    
    $idTarea = $_POST["idTarea"];
    $steps = json_decode($_POST["steps"], true);

    // Obtener los IDs de la tabla pasos que corresponden a la tarea actual
    $query_existing_ids = "SELECT `id`, `numPaso` FROM `pasos` WHERE `idTarea`=?";
    $stmt_existing_ids = mysqli_prepare($con, $query_existing_ids);
    mysqli_stmt_bind_param($stmt_existing_ids, "i", $idTarea);
    $exe_existing_ids = mysqli_stmt_execute($stmt_existing_ids);

    if (!$exe_existing_ids) {
        $arr["success"] = "false";
        $arr["error"] = "Error en la consulta SELECT: " . mysqli_error($con);
        die('Error en la consulta SELECT: ' . mysqli_error($con));
    }

    $result_existing_ids = mysqli_stmt_get_result($stmt_existing_ids);

    // Guardar los IDs existentes en un array asociativo
    $existing_ids = [];
    while ($row_existing_ids = mysqli_fetch_assoc($result_existing_ids)) {
        $existing_ids[$row_existing_ids["numPaso"]] = $row_existing_ids["id"];
    }

    mysqli_stmt_close($stmt_existing_ids);

    // Recorrer los pasos proporcionados y actualizar o insertar según sea necesario
    foreach ($steps as $step) {
        $numPaso = $step['numPaso'];
        $descripcion = $step['descripcion'];
        $imagen = $step['imagen'];

        if (isset($existing_ids[$numPaso])) {
            // El paso ya existe, actualizar
            $id_to_update = $existing_ids[$numPaso];
            $query_update = "UPDATE `pasos` SET `descripcion`=?, `imagen`=? WHERE `id`=?";
            $stmt_update = mysqli_prepare($con, $query_update);
            mysqli_stmt_bind_param($stmt_update, "ssi", $descripcion, $imagen, $id_to_update);
            $exe_update = mysqli_stmt_execute($stmt_update);

            if (!$exe_update) {
                $arr["success"] = "false";
                $arr["error"] = "Error en la consulta UPDATE: " . mysqli_error($con);
                die('Error en la consulta UPDATE: ' . mysqli_error($con));
            }

            mysqli_stmt_close($stmt_update);
        } else {
            // El paso no existe, insertar nuevo
            $query_insert = "INSERT INTO `pasos` (`numPaso`, `descripcion`, `imagen`, `idTarea`) VALUES (?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($con, $query_insert);
            mysqli_stmt_bind_param($stmt_insert, "issi", $numPaso, $descripcion, $imagen, $idTarea);
            $exe_insert = mysqli_stmt_execute($stmt_insert);

            if (!$exe_insert) {
                $arr["success"] = "false";
                $arr["error"] = "Error en la consulta INSERT: " . mysqli_error($con);
                die('Error en la consulta INSERT: ' . mysqli_error($con));
            }

            mysqli_stmt_close($stmt_insert);
        }
    }

    // Eliminar los pasos que están en la base de datos pero no en la lista `steps`
    foreach ($existing_ids as $numPaso => $id_to_delete) {
        $delete_this_step = true;

        foreach ($steps as $step) {
            if ($step['numPaso'] == $numPaso) {
                $delete_this_step = false;
                break;
            }
        }

        if ($delete_this_step) {
            $query_delete = "DELETE FROM `pasos` WHERE `id`=?";
            $stmt_delete = mysqli_prepare($con, $query_delete);
            mysqli_stmt_bind_param($stmt_delete, "i", $id_to_delete);
            $exe_delete = mysqli_stmt_execute($stmt_delete);

            if (!$exe_delete) {
                $arr["success"] = "false";
                $arr["error"] = "Error en la consulta DELETE: " . mysqli_error($con);
                die('Error en la consulta DELETE: ' . mysqli_error($con));
            }

            mysqli_stmt_close($stmt_delete);
        }
    }

    $arr["success"] = "true";

} else {
    $arr["success"] = "false";
}

echo json_encode($arr);

?>