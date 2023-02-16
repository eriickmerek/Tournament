<?php
  session_start();
  $conn = new mysqli("127.0.0.1","root","","torneo"); //Coneccion al servidor
  if ($conn->connect_error){ //Checar si hubo un problema conectadose al servidor
    echo "ERROR";
  }
  $nombre = $_POST['nombre'];
  $apPat = $_POST['apPat'];
  $apMat = $_POST['apMat'];
  $categoria = $_POST['categoria'];
  $idTourn = $_POST['idTourn'];
  //Checar cuantas filas ahi en la tabla Cursos
  $cnt = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM Participante"));
  $insert = "INSERT INTO Participante(id,nombre,apPaterno,apMaterno,categoria,idTorneo) VALUES('$cnt','$nombre','$apPat','$apMat','$categoria','$idTourn')";
  $query = mysqli_query($conn,$insert);
  if($query){
    echo $cnt;
  }else{
    echo "ERROR";
  }
?>
