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
  <title>Judges</title>
</head>

<body>
  <div class="row">
    <a href="index.php"><img src="Img/ICON.png" style="width:12%" class="header-icon"></a>
    <a href="Jueces.php" class="right header-opt" style="margin-right: 15%; color: #FAFAFA;">Judges</a>
    <a href="consultas.php" class="right header-opt">Participants</a>
    <a href="news.php" class="right header-opt">News</a>
    <a href="index.php" class="right header-opt">Home</a>
  </div>


  <div class="row">
    <div class="col hide-on-small-only m1 l2"></div>
    <div class="col s12 m9 l8" id="bigBen">
      <ul id="Tournament" class="collapsible scrollspy" data-collapsible="accordion">
        <li>
          <div class="collapsible-header"><i class="material-icons">add_circle_outline</i><a class="AgregarCollap">Add Judge</a></div>
          <div class="collapsible-body">
            <form>
              <div class="row">
                <div class="input-field col s4">
                  <input id="RegName" type="text" class="validate" required>
                  <label for="RegName">Name</label>
                </div>
                <div class="input-field col s4">
                  <input id="RegApPat" type="text" class="validate" required>
                  <label for="RegApPat">Last Name</label>
                </div>
                <div class="input-field col s4">
                  <input id="RegApMat" type="text" class="validate" required>
                  <label for="RegApMat">Second Last Name</label>
                </div>
              </div>
              <div class="row">
                <div class="col s6">
                  <label>Type of Judge</label>
                  <select class="browser-default" style="background-color: #282828;">
                    <option value="" disabled selected>Choose your option</option>
                    <option value="Primary">Primary</option>
                    <option value="Leader">Leader</option>
                    <option value="Helper">Helper</option>
                  </select>
                </div>
                <div class="input-field col s6">
                  <input id="RegSchool" type="text" class="validate" required>
                  <label for="RegSchool">School</label>
                </div>
              </div>
              <div class="row">
                <button class="waves-effect waves-orange btn-flat right" type="reset">Cancel</button>
                <button class="waves-effect waves-orange btn-flat right" type="submit" id="createJudge">Add</button>
              </div>
            </form>
          </div>
        </li>
        <li>
          <div class="collapsible-header" style="border-radius: 0px 0px 10px 10px;"></div>
        </li>
      </ul>
      <div id='Judge' class='section scrollspy'>
        <div class='card-panel'>
          <div class='card-content'>
            <table>
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>School</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $query = mysqli_query($conn,"SELECT * FROM Juez");
                  while($row = mysqli_fetch_array($query)){
                    $idTourn = $row['id'];
                    $Name = $row['nombre'];
                    $LastName = $row['apPaterno'];
                    $SLastName = $row['apMaterno'];
                    $Type = $row['tipo'];
                    $School = $row['escuela'];
                    echo "
                    <tr>
                      <td>$idTourn</td>
                      <td>$Name $LastName $SLastName</td>
                      <td>$Type</td>
                      <td>$School</td>
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
    <div class="col hide-on-small-only m2 l2">
      <ul class="section table-of-contents fixed" id="side">
        <li><a href="#Tournament">Add Judge</a></li>
        <li><a href="#Judge">Judges</a></li>
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

    //Funcion para agregar juez
    $("#createJudge").click(function(event) {
      event.preventDefault();
      var Nombre = $("#RegName").val();
      var ApPat = $("#RegApPat").val();
      var ApMat = $("#RegApMat").val();
      var Tipo = $("select").val();
      var Escuela = $("#RegSchool").val();
      $.ajax({
        url: 'functions/AddJudge.php',
        type: 'POST',
        data: {nombre: Nombre, apPat: ApPat, apMat: ApMat, tipo: Tipo, escuela: Escuela},
        success: function(response){
          if(response == "ERROR"){
            alert("Error adding judge, try again later.");
          }else{
            $("table").append("<tr><td>"+response+"</td><td>"+Nombre+" "+ApPat+" "+ApMat+"</td><td>"+Tipo+"</td><td>"+Escuela+"</td></tr>");
            alert("Judge added.");
          }
        }
      })
      .done(function() {
        console.log("Judge added.");
      })
      .fail(function() {
        console.log("Error adding Judge.");
      })
      .always(function() {
        console.log("complete");
      });
    });
  });
  </script>
</body>

</html>
