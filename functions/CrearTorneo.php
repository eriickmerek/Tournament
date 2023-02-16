<?php
  session_start();
  $conn = new mysqli("127.0.0.1","root","","torneo"); //Coneccion al servidor
  if ($conn->connect_error){ //Checar si hubo un problema conectadose al servidor
    echo "ERROR";
  }
  $nombre = $_POST['nombre'];
  $sede = $_POST['sede'];
  $fecha = $_POST['fecha'];
  $hora = $_POST['hora'];
  //Checar cuantas filas ahi en la tabla Cursos
  $cnt = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM Torneo"));
  //Checar si el nombre ya ha sido usado anteriormente
  $check_name = "SELECT * FROM Torneo WHERE nombre='$nombre'";
  $run_name = mysqli_query($conn,$check_name);
  $check = mysqli_num_rows($run_name);
  if($check != 1){
    $insert = "INSERT INTO Torneo(id,nombre,sede,fecha,hora_inicio) VALUES('$cnt','$nombre','$sede','$fecha','$hora')";
    $query = mysqli_query($conn,$insert);
    if($query){
      echo $cnt;
    }else{
      echo "ERROR";
    }
  }else{
    echo "ERROR";
  }
?>
