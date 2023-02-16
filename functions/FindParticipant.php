<?php
  session_start();
  $conn = new mysqli("127.0.0.1","root","","torneo"); //Coneccion al servidor
  if ($conn->connect_error){ //Checar si hubo un problema conectadose al servidor
    echo "<script>alert('There was a problem connecting to the Server.')</script>";
  }
  $person = $_POST['person'];

  $insert = "SELECT * FROM Participante";
  $query = mysqli_query($conn,$insert);
  while($check = mysqli_fetch_array($query)){
    if($check['id'] == $person){
      echo $check['nombre']." ".$check['apPaterno']." ".$check['apMaterno'];
    }
  }
?>
