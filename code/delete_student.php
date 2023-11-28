<?php

include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["idStudent"])) {
    $idStudent = $_POST["idStudent"];
} else {
    echo json_encode(["success" => false, "error" => "No idStudent provided"]);
    return;
}

$query = "DELETE FROM `Alumno` WHERE id=?";

$stmt = mysqli_prepare($con, $query);


if (!$stmt) {
    echo json_encode(["success" => false, "error" => "Error in prepared statement: " . mysqli_error($con)]);
    return;
}

mysqli_stmt_bind_param($stmt, "i", $idStudent);
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
