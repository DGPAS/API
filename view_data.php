
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("dbconnection.php");
$con=dbconnection();

$query = "SELECT `idTareas`, `nombre`, `realizada`, `descripcion`, `inicio`, `final`, `agenda_id`, `miniatura` FROM `tareas`";



$exe=mysqli_query($con,$query);

if (!$exe) {
    die('Error en la consulta: ' . mysqli_error($con));
}

$arr=[];
while($row=mysqli_fetch_assoc($exe))
{
    $arr[]=$row;
}
print(json_encode($arr));
?>