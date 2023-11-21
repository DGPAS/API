<?php

include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["idTareas"])) {
    $idTareas = $_POST["idTareas"];
} else {
    echo json_encode(["success" => false, "error" => "No idTareas provided"]);
    return;
}

$query = "DELETE FROM `tareas` WHERE idTareas=?";
$stmt = mysqli_prepare($con, $query);

if (!$stmt) {
    echo json_encode(["success" => false, "error" => "Error in prepared statement: " . mysqli_error($con)]);
    return;
}

mysqli_stmt_bind_param($stmt, "i", $idTareas);

$exe = mysqli_stmt_execute($stmt);

$arr = [];
if ($exe) {
    $arr["success"] = true;
} else {
    $arr["success"] = false;
    $arr["error"] = mysqli_error($con);
}

mysqli_stmt_close($stmt);

echo json_encode($arr);

?>
