<?php

include("dbconnection.php");
$con = dbconnection();

    if (isset($_FILES['pictograma1']) && isset($_FILES['pictograma2']) && isset($_FILES['pictograma3']) && isset($_POST['idStudent'])) {
        $pictogram1 = $_FILES['pictograma1']['name'];
        $pictogram2 = $_FILES['pictograma2']['name'];
        $pictogram3 = $_FILES['pictograma3']['name'];
        $idStudent = $_POST['idStudent'];

        $pictogram1Path = 'images/students/passwords/' . $pictogram1;
        $tmp_name1 = $_FILES['pictograma1']['tmp_name'];
        move_uploaded_file($tmp_name1, $pictogram1Path);

        $pictogram2Path = 'images/students/passwords/' . $pictogram2;
        $tmp_name2 = $_FILES['pictograma2']['tmp_name'];
        move_uploaded_file($tmp_name2, $pictogram2Path);

        $pictogram3Path = 'images/students/passwords/' . $pictogram3;
        $tmp_name3 = $_FILES['pictograma3']['tmp_name'];
        move_uploaded_file($tmp_name3, $pictogram3Path);

        $query = "INSERT INTO `passwordAlumno`(`idAlumno`, `pictograma1`, `pictograma2`, `pictograma3`) VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($con, $query);

        mysqli_stmt_bind_param($stmt, "isss", $idStudent, $pictogram1, $pictogram2, $pictogram3);

        $exe = mysqli_stmt_execute($stmt);

        $arr = [];

        if ($exe) {
            $arr["success"] = "true";
            $arr["idStudent"] = mysqli_insert_id($con);
        } else {
            $arr["success"] = "false";
            $arr["error"] = mysqli_error($con);
        }

        mysqli_stmt_close($stmt);
    }
    else {
        $arr["success"] = "false";
        die('Error de paso de parametros: ' . mysqli_error());
    }

print(json_encode($arr));


?>