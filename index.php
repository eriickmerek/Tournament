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
  <title>Home</title>
</head>

<body>
  <div class="row">
    <a href="index.php"><img src="Img/ICON.png" style="width:12%" class="header-icon"></a>
    <a href="Jueces.php" class="right header-opt" style="margin-right: 15%;">Judges</a>
    <a href="consultas.php" class="right header-opt">Participants</a>
    <a href="news.php" class="right header-opt">News</a>
    <a href="index.php" class="right header-opt" style="color: #FAFAFA;">Home</a>
  </div>


  <div class="row">
    <div class="col hide-on-small-only m1 l2"></div>
    <div class="col s12 m9 l8" id="bigBen">
      <ul id="Tournament" class="collapsible scrollspy" data-collapsible="accordion">
        <li>
          <div class="collapsible-header"><i class="material-icons">add_circle_outline</i><a class="AgregarCollap">Create Tournament</a></div>
          <div class="collapsible-body">
            <form>
              <div class="row">
                <div class="input-field col s6">
                  <input id="RegName" type="text" class="validate" required>
                  <label for="RegName">Name</label>
                </div>
                <div class="input-field col s6">
                  <input id="RegPlace" type="text" class="validate" required>
                  <label for="RegPlace">Place</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6">
                  <input id="RegDate" type="text" class="validate" required>
                  <label for="RegDate">Date</label>
                </div>
                <div class="input-field col s6">
                  <input id="RegTime" type="text" class="validate" required>
                  <label for="RegTime">Time</label>
                </div>
              </div>
              <div class="row">
                <button class="waves-effect waves-orange btn-flat right" type="reset">Cancel</button>
                <button class="waves-effect waves-orange btn-flat right" type="submit" id="createTourn">Create</button>
              </div>
            </form>
          </div>
        </li>
        <li>
          <div class="collapsible-header" style="border-radius: 0px 0px 10px 10px;"></div>
        </li>
      </ul>
      <?php
        $query = mysqli_query($conn,"SELECT * FROM Torneo ORDER by 1 DESC");
        while($row = mysqli_fetch_array($query)){
          $idTourn = $row['id'];
          $Name = $row['nombre'];
          $Sede = $row['sede'];
          $Fecha = $row['fecha'];
          $Hora = $row['hora_inicio'];

          echo "
          <div id='$idTourn' class='section scrollspy'>
            <div class='card-panel'>
              <div class='card-content'>
              <a href='Torneo.php?Tournid=$idTourn' class='btn-floating btn-large waves-effect waves-light right' style='background-color: #FFFFFF;'><i class='material-icons' style='color:#FF5722;'>add</i></a>
                <h3 style='color:#E1E1E1'>$Name</h3>
                <h5>This tournament will take place in $Sede.</h5>
                <h5>Tournament date: $Fecha</h5>
                <h5>Tournament time: $Hora</h5>
              </div>
            </div>
          </div>
          ";
        }
      ?>
    </div>
    <div class="col hide-on-small-only m2 l2">
      <ul class="section table-of-contents fixed" id="side">
        <li><a href="#Tournament">Create Tournament</a></li>
        <?php
          $query = mysqli_query($conn,"SELECT * FROM Torneo ORDER by 1 DESC");
          while($row = mysqli_fetch_array($query)){
            $idTourn = $row['id'];
            $Name = $row['nombre'];
            echo "<li><a href='#$idTourn'>$Name</a></li>";
          }
        ?>
      </ul>
    </div>
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
