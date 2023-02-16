<?php
  session_start();
  $conn = new mysqli("127.0.0.1","root","","torneo"); //Coneccion al servidor
  if ($conn->connect_error){ //Checar si hubo un problema conectadose al servidor
    echo "ERROR";
  }
  $winner = $_POST['winner'];
  $place = $_POST['place'];
  $sql = "UPDATE Participante SET lugar='$place' WHERE id='$winner'";
  $query = mysqli_query($conn,$sql);
  if($query){
    echo "SUCCESS";
  }else{
    echo "ERROR";
  }
?>
