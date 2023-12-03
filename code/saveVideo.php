<?php

include("dbconnection.php");
$con = dbconnection();

$home = getenv('HOME');

if (isset($_FILES['video']) && isset($_POST['idTareas'])) {
    $video = $_FILES['video']['name'];
    $idTasks = $_POST['idTareas'];

    $videoPath = 'video/' . $video;
    $tmp_name = $_FILES['video']['tmp_name'];

    move_uploaded_file($tmp_name, $videoPath);

    $query = "UPDATE `tareas` SET `video`=? WHERE `idTareas`=?";

    $stmt = mysqli_prepare($con, $query);

    mysqli_stmt_bind_param($stmt, "si", $video, $idTasks);

    $exe = mysqli_stmt_execute($stmt);

    $arr = [];

    if ($exe) {
        $arr["success"] = "true";
        $arr["idTareas"] = $idTasks; // Use the provided idTareas directly
    } else {
        $arr["success"] = "false";
        $arr["error"] = mysqli_error($con);
    }

    mysqli_stmt_close($stmt);

    echo json_encode($arr);
} else {
    $arr["success"] = "false";
    die('Error in parameter passing: ' . mysqli_error());
}
?>
