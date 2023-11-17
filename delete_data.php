<?php

include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["idTareas"])) {
    $idTareas = $_POST["idTareas"];
} else {
    echo json_encode(["success" => false, "error" => "No idTareas provided"]);
    return;
}

$query = "DELETE FROM `tareas` WHERE idTareas='$idTareas'";

$exe = mysqli_query($con, $query);

$arr = [];
if ($exe) {
    $arr["success"] = true;
} else {
    $arr["success"] = false;
    $arr["error"] = mysqli_error($con);
}
echo json_encode($arr);

?>
