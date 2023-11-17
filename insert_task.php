<?php
include("dbconnection.php");
$con = dbconnection();

if (isset($_POST["nombre"]) && isset($_POST["realizada"]) && isset($_POST["descripcion"])) {
    $nombre = $_POST["nombre"];
    $realizada = $_POST["realizada"] === "1" ? 1 : 0;
    $descripcion = $_POST["descripcion"];

    $query = "INSERT INTO `tareas`(`nombre`, `realizada`, `descripcion`) VALUES ('$nombre', $realizada, '$descripcion')";

    $exe = mysqli_query($con, $query);

    $arr = [];

    if ($exe) {
        $arr["success"] = "true";
    } else {
        $arr["success"] = "false";
        $arr["error"] = mysqli_error($con);
    }
} else {
    $arr["success"] = "false";
}

print(json_encode($arr));
?>
