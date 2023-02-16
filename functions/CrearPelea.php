<?php
  session_start();
  $conn = new mysqli("127.0.0.1","root","","torneo"); //Coneccion al servidor
  if ($conn->connect_error){ //Checar si hubo un problema conectadose al servidor
    echo "ERROR";
  }
  $pers1 = $_POST['pers1'];
  $pers2 = $_POST['pers2'];
  $idTourn = $_POST['idTourn'];
  //Checar cuantas filas ahi en la tabla Cursos
  $cnt = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM Pelea"));
  $insert = "INSERT INTO Pelea(id,idPart1,idPart2,idTorneo) VALUES('$cnt','$pers1','$pers2','$idTourn')";
  $query = mysqli_query($conn,$insert);
  if($query){
    $resultado = "";
    $sql1 = "SELECT nombre,apPaterno	FROM Participante WHERE	id='$pers1'";
    $sql2 = "SELECT nombre,apPaterno	FROM Participante WHERE	id='$pers2'";
    $result = mysqli_query($conn,$sql1);
    while($row = mysqli_fetch_array($result)){
      $resultado = $row['nombre']." ".$row['apPaterno']." vs ";
    }
    $result2 = mysqli_query($conn,$sql2);
    while($row = mysqli_fetch_array($result2)){
      $resultado = $resultado.$row['nombre']." ".$row['apPaterno'];
    }
    echo $resultado;
  }else{
    echo "ERROR";
  }
?>
