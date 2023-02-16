<!DOCTYPE html>
<?php
  $conn = new mysqli("127.0.0.1","root","","torneo"); //Coneccion al servidor
  if ($conn->connect_error){ //Checar si hubo un problema conectadose al servidor
    echo "<script>alert('There was a problem connecting to the Server.')</script>";
  }
?>
<html>

<head>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link rel="stylesheet" href="Styles/materialize.min.css">
  <link rel="stylesheet" href="Styles/style_index.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>NEWS</title>
</head>

<body>
  <div class="row">
    <a href="index.php"><img src="Img/ICON.png" style="width:12%" class="header-icon"></a>
    <a href="Jueces.php" class="right header-opt" style="margin-right: 15%;">Judges</a>
    <a href="consultas.php" class="right header-opt">Participants</a>
    <a href="news.php" class="right header-opt" style="color: #FAFAFA;">News</a>
    <a href="index.php" class="right header-opt" >Home</a>
  </div>

  <div class="row">
    <div class="col hide-on-small-only m1 l2"></div>
    <div class="col s12 m9 l8" id="bigBen">
      <div id='Judge' class='section'>
        <div class='card-panel'>
          <div class='card-content'>

            <table>
              <thead>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $query = mysqli_query($conn,"SELECT * FROM participante");
                  while($row = mysqli_fetch_array($query)){
                    $idTourn = $row['id'];
                    $Name = $row['nombre'];
                    $LastName = $row['apPaterno'];
                    $SLastName = $row['apMaterno'];
                    $category = $row['categoria'];
                    $place = $row['lugar'];
                    $idtorneo = $row['idTorneo'];
                    echo "
                    <tr>
                      <td>";?><img src="img/1.jpg"><?php echo"</td>
                      <td><h4> 'Felicidades a $Name por haber obtenido el primer lugar en este destacado torneo de Kung Fu, de antemano, gracias por su destacada participacion'. </h4></td>
                    </tr>
                    ";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>





    </div>


<!--
    <div class="col hide-on-small-only m2 l2">
      <ul class="section table-of-contents fixed" id="side">
        <li><a href="#Tournament">Create News</a></li>
        <?php
          $query = mysqli_query($conn,"SELECT * FROM torneo ORDER by 1 DESC");
          while($row = mysqli_fetch_array($query)){
            $idTourn = $row['id'];
            $Name = $row['nombre'];
            echo "<li><a href='#$idTourn'>$Name</a></li>";
          }
        ?>
      </ul>
    </div>  -->
  </div>
  <footer class="page-footer" >
    <div class="container">
      <div class="row">
        <div class="col l4 s12">
          <img src="Img/ICON.png" style="width:60%; margin-top: 26px;" class="header-icon">
        </div>
        <div class="col l4 s12">
          <center>
            <ul>
              <li>Developers:</li>
              <li style="color:#717171">Benjamín Alejandro González Torres</li>
              <li style="color:#717171">Erick Leonardo Meza Morán</li>
              <li style="color:#717171">Horacio Saldaña Zermeño</li>
            </ul>
          </center>
        </div>
        <div class="col l4 s12">
          <img src="Img/uaa.png" class="right" style="width:70%; margin-top: 18px;">
        </div>
      </div>
      <div class="row">
        <p style="color:#717171" class="right">© 2018 Wushu Tournament</p>
      </div>
    </div>

  </footer>

  <!--Import materialize.js-->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
  <!--Funciones de javascript-->
  <script type="text/javascript">
  $(document).ready(function(){
    $('.scrollspy').scrollSpy({
      scrollOffset:50
    });

    //Funcion para agregar torneo
    $("#createTourn").click(function(event) {
      event.preventDefault();
      var Nombre = $("#RegName").val();
      var Sede = $("#RegPlace").val();
      var Fecha = $("#RegDate").val();
      var Hora = $("#RegTime").val();
      $.ajax({
        url: 'functions/CrearTorneo.php',
        type: 'POST',
        data: {nombre: Nombre, sede: Sede, fecha: Fecha, hora: Hora},
        success: function(response){
          if(response == "ERROR"){
            alert("Error creating tournament, try again later.");
          }else{
            $("#bigBen").append("<div id='"+response+"' class='section scrollspy'>"+
            "<div class='card-panel'>"+
              "<div class='card-content'>"+
                "<a href='Torneo.php?Tournid="+response+"' class='btn-floating btn-large waves-effect waves-light right' style='background-color: #FFFFFF;'><i class='material-icons' style='color:#FF5722;'>edit</i></a>"+
                "<h3 style='color:#E1E1E1'>"+Nombre+"</h3>"+
                "<h5>This tournament will take place in "+Sede+".</h5>"+
                "<h5>Tournament date: "+Fecha+"</h5>"+
                "<h5>Tournament time: "+Hora+"</h5>"+
              "</div>"+
            "</div>"+
            "</div>");
            $("#side").append("<li><a href='#"+response+"'>"+Nombre+"</a></li>");
            alert("Tournament created.");
          }
        }
      })
      .done(function() {
        console.log("Tournament created.");
      })
      .fail(function() {
        console.log("Error creating tournament.");
      })
      .always(function() {
        console.log("complete");
      });
    });
  });
  </script>
</body>

</html>
