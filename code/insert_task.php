<?php
include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["video"])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $video = $_POST["video"];

    $query = "INSERT INTO `tasks`(`name`, `description`, `video`) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($con, $query);

    mysqli_stmt_bind_param($stmt, "sss", $name, $description, $video);

    $exe = mysqli_stmt_execute($stmt);

    $arr = [];

    if ($exe) {
        $arr["success"] = "true";
        $arr["idTareas"] = mysqli_insert_id($con); // Añade al array el idTareas (mysqli_insert_id devuelve el valor de una columna AUTO_INCREMENT actualizada, en nuestro caso idTareas)
    } else {
        $arr["success"] = "false";
        $arr["error"] = mysqli_error($con);
    }

    mysqli_stmt_close($stmt);

} else {
    $arr["success"] = "false";
}

print(json_encode($arr));
?>
