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
  <title>Tournament</title>

  <style>
    .pelea{
      border: 1px solid #ddd;
      border-radius: 10px;
    }
    .titulo{
      padding-bottom:3%;
    }
    .match{
      border: 1px solid #ddd;
    }
    .fight{
      color: white;
    }
    .modal{
      background-color: #282828;
    }
  </style>
</head>

<body>
  <?php
    $idTournament = $_GET['Tournid'];
  ?>
  <div class="row">
    <a href="index.php"><img src="Img/ICON.png" style="width:12%" class="header-icon"></a>
    <a href="Jueces.php" class="right header-opt" style="margin-right: 15%;">Judges</a>
    <a href="consultas.php" class="right header-opt">Participants</a>
    <a href="news.php" class="right header-opt">News</a>
    <a href="index.php" class="right header-opt">Home</a>
  </div>


  <div class="row">
    <div class="col hide-on-small-only m1 l2"></div>
    <div class="col s12 m9 l8" id="bigBen">
      <ul id="Participant" class="collapsible scrollspy" data-collapsible="accordion">
        <!--Add Participant-->
        <li>
          <div class="collapsible-header"><i class="material-icons">add_circle_outline</i><a class="AgregarCollap">Add Participant</a></div>
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
                  <label>Category</label>
                  <select class="browser-default" style="background-color: #282828;">
                    <option value="" disabled selected>Choose your option</option>
                    <option value="Age">Age</option>
                    <option value="Weight">Weight</option>
                    <option value="Level">Level</option>
                  </select>
                </div>
                <div class="input-field col s6">
                  <input id="RegTournID" type="text" class="validate" value="<?php echo $idTournament?>" required>
                  <label for="RegTournID">ID Tournament</label>
                </div>
              </div>
              <div class="row">
                <button class="waves-effect waves-orange btn-flat right" type="reset">Cancel</button>
                <button class="waves-effect waves-orange btn-flat right" type="submit" id="createParticipant">Add</button>
              </div>
            </form>
          </div>
        </li>
        <!--Create Match-->
        <li>
          <div class="collapsible-header" style="border-radius: 0px;"><i class="material-icons">add_circle_outline</i><a class="AgregarCollap">Create Match</a></div>
          <div class="collapsible-body">
            <form>
              <div class="row">
                <div class="input-field col s4">
                  <input id="MatID" type="text" class="validate" value="<?php echo $idTournament?>" required>
                  <label for="MatID">ID Tournament</label>
                </div>
                <div class="input-field col s4">
                  <input id="MatPers1" type="text" class="validate" required>
                  <label for="MatPers1">ID First Participant</label>
                </div>
                <div class="input-field col s4">
                  <input id="MatPers2" type="text" class="validate" required>
                  <label for="MatPers2">ID Second Participant</label>
                </div>
              </div>
              <div class="row">
                <span id="FullNamePart"></span>
                <button class="waves-effect waves-orange btn-flat right" type="reset">Cancel</button>
                <button class="waves-effect waves-orange btn-flat right" type="submit" id="createMatch">Create</button>
              </div>
            </form>
          </div>
        </li>
        <li>
          <div class="collapsible-header" style="border-radius: 0px 0px 10px 10px;"></div>
        </li>
      </ul>
    </div>
  </div>

  <div class="row center"><h3>Matches</h3></div>
  <div class="row">
    <div class="col hide-on-small-only m1 l1"></div>
    <?php
    $vector = array();
    $query = mysqli_query($conn,"SELECT * FROM Pelea WHERE idTorneo='$idTournament'");
    while($row = mysqli_fetch_array($query)){
      $nombreP = "";
      $sql = "SELECT * FROM Participante WHERE id='".$row['idPart1']."'";
      $result = mysqli_query($conn,$sql);
      while($Participante = mysqli_fetch_array($result)){
        $nombreP = $Participante['nombre']." ".$Participante['apPaterno'];
      }
      $sql = "SELECT * FROM Participante WHERE id='".$row['idPart2']."'";
      $result = mysqli_query($conn,$sql);
      while($Participante = mysqli_fetch_array($result)){
        $nombreP = $nombreP." vs ".$Participante['nombre']." ".$Participante['apPaterno'];
      }
      array_push($vector,$nombreP);
    }
    ?>
    <table class="col s12 m10 l10 centered">
      <tbody>
        <tr>
          <td class="match"><h5>
            <?php
            if(!empty($vector[0])){ echo $vector[0]; }
            else{ echo "Unkown vs Unkown";  }
            ?></h5>
          </td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td class="match"><h5><a class="fight modal-trigger" href="#modal1" id="a4">
            <?php
            if(!empty($vector[4])){ echo $vector[4]; }
            else{ echo "Unkown vs Unkown";  }
            ?>
          </td></h5></a>
          <td></td>
        </tr>
        <tr>
          <td class="match"><h5>
            <?php
            if(!empty($vector[1])){ echo $vector[1]; }
            else{ echo "Unkown vs Unkown";  }
            ?></h5></a>
          </td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td class="match"><h5><a class="fight modal-trigger" href="#modal1" id="a6">
            <?php
            if(!empty($vector[6])){ echo $vector[6]; }
            else{ echo "Unkown vs Unkown";  }
            ?></h5></a>
          </td>
        </tr>
        <tr>
          <td class="match"><h5><a class="fight">
            <?php
            if(!empty($vector[2])){ echo $vector[2]; }
            else{ echo "Unkown vs Unkown";  }
            ?></h5></a>
          </td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td class="match"><h5><a class="fight modal-trigger" href="#modal1" id="a5">
            <?php
            if(!empty($vector[5])){ echo $vector[5]; }
            else{ echo "Unkown vs Unkown";  }
            ?></h5></a>
          </td>
          <td></td>
        </tr>
        <tr>
          <td class="match"><h5><a class="fight">
            <?php
            if(!empty($vector[3])){ echo $vector[3]; }
            else{ echo "Unkown vs Unkown";  }
            ?></h5></a>
          </td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h4>Update Match</h4>
      <form method="post">
        <div class="row">
          <div class="input-field col s6">
            <input id="ModalPers1" type="text" class="validate" required>
            <label for="ModalPers1">ID First Participant</label>
          </div>
          <div class="input-field col s6">
            <input id="ModalPers2" type="text" class="validate" required>
            <label for="ModalPers2">ID Second Participant</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s4">
            <input id="ModalTournID" type="text" class="validate" value="<?php echo $idTournament?>" required>
            <label for="ModalTournID">ID Tournament</label>
          </div>
          <div class="input-field col s4">
            <input id="ModalWinnerID" type="text" class="validate" required>
            <label for="ModalWinnerID">Winner ID</label>
          </div>
          <div class="input-field col s4">
            <input id="ModalWinPlace" type="text" class="validate" required>
            <label for="ModalWinPlace">Place</label>
          </div>
        </div>
        <div class="row">
          <span id="FullNamePartModal"></span>
          <button class="waves-effect waves-orange btn-flat right modal-action modal-close" type="reset">Cancel</button>
          <button class="waves-effect waves-orange btn-flat right" type="submit" id="UpdateModal">Update</button>
          <button class="waves-effect waves-orange btn-flat right" type="submit" id="UpdateWinner">Update Winner</button>
        </div>
      </form>
    </div>
  </div>

  <!--Footer-->
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
    $('.modal').modal();

    //Funcion para agregar participante
    $("#createParticipant").click(function(event) {
      event.preventDefault();
      var Nombre = $("#RegName").val();
      var ApPat = $("#RegApPat").val();
      var ApMat = $("#RegApMat").val();
      var Categoria = $("select").val();
      var idTournament = $("#RegTournID").val();
      $.ajax({
        url: 'functions/AddParticipant.php',
        type: 'POST',
        data: {nombre: Nombre, apPat: ApPat, apMat: ApMat, categoria: Categoria, idTourn: idTournament},
        success: function(response){
          if(response == "ERROR"){
            alert("Error adding participant, try again later.");
          }else{
            //$("table").append("<tr><td>"+response+"</td><td>"+Nombre+" "+ApPat+" "+ApMat+"</td><td>"+Tipo+"</td><td>"+Escuela+"</td></tr>");
            alert("Participant added.");
          }
        }
      })
      .done(function() {
        console.log("Participant added.");
      })
      .fail(function() {
        console.log("Error adding Participant.");
      })
      .always(function() {
        console.log("complete");
      });
    });

    //Si el ID Participante 1 se presiona una tecla
    $("#MatPers1").keyup(function(){
      var Person = this.value;
      $.ajax({
        url: 'functions/FindParticipant.php',
        type: 'POST',
        data: {person: Person},
        success: function(response){
          $("#FullNamePart").html(response);
        }
      })
      .done(function() {
        console.log("Registrado a curso.");
      })
      .fail(function() {
        console.log("Hubo un error registrandote al curso.");
      })
      .always(function() {
        console.log("complete");
      });
    });

    //Si el ID Participante 2 se presiona una tecla
    $("#MatPers2").keyup(function(){
      var Person = this.value;
      $.ajax({
        url: 'functions/FindParticipant.php',
        type: 'POST',
        data: {person: Person},
        success: function(response){
          $("#FullNamePart").html(response);
        }
      })
      .done(function() {
        console.log("Registrado a curso.");
      })
      .fail(function() {
        console.log("Hubo un error registrandote al curso.");
      })
      .always(function() {
        console.log("complete");
      });
    });

    //Crear una pelea
    $("#createMatch").click(function(event) {
      event.preventDefault();
      var Pers2 = $("#MatPers2").val();
      var Pers1 = $("#MatPers1").val();
      var idTournament = $("#MatID").val();
      $.ajax({
        url: 'functions/CrearPelea.php',
        type: 'POST',
        data: {pers1: Pers1, pers2: Pers2, idTourn: idTournament},
        success: function(response){
          if(response == "ERROR"){
            alert("Error adding participant, try again later.");
          }else{
            alert("Match created.");
          }
        }
      })
      .done(function() {
        console.log("Match created.");
      })
      .fail(function() {
        console.log("Error creating match.");
      })
      .always(function() {
        console.log("complete");
      });
    });


    //Modal keyups
    //Si el ID Participante 1 se presiona una tecla
    $("#ModalPers1").keyup(function(){
      var Person = this.value;
      $.ajax({
        url: 'functions/FindParticipant.php',
        type: 'POST',
        data: {person: Person},
        success: function(response){
          $("#FullNamePartModal").html(response);
        }
      })
      .done(function() {
        console.log("Registrado a curso.");
      })
      .fail(function() {
        console.log("Hubo un error registrandote al curso.");
      })
      .always(function() {
        console.log("complete");
      });
    });

    //Si el ID Participante 2 se presiona una tecla
    $("#ModalPers2").keyup(function(){
      var Person = this.value;
      $.ajax({
        url: 'functions/FindParticipant.php',
        type: 'POST',
        data: {person: Person},
        success: function(response){
          $("#FullNamePartModal").html(response);
        }
      })
      .done(function() {
        console.log("Registrado a curso.");
      })
      .fail(function() {
        console.log("Hubo un error registrandote al curso.");
      })
      .always(function() {
        console.log("complete");
      });
    });

    //Modal Update
    $("#UpdateModal").click(function(event) {
      event.preventDefault();
      var Pers2 = $("#ModalPers2").val();
      var Pers1 = $("#ModalPers1").val();
      var idTournament = $("#ModalTournID").val();
      $.ajax({
        url: 'functions/CrearPelea.php',
        type: 'POST',
        data: {pers1: Pers1, pers2: Pers2, idTourn: idTournament},
        success: function(response){
          if(response == "ERROR"){
            alert("Error updating match, try again later.");
          }else{
            alert("Match updated.");
          }
        }
      })
      .done(function() {
        console.log("Match created.");
      })
      .fail(function() {
        console.log("Error creating match.");
      })
      .always(function() {
        console.log("complete");
      });
    });

    //Update Winner UpdateWinner
    $("#UpdateWinner").click(function(event) {
      event.preventDefault();
      var idWinner = $("#ModalWinnerID").val();
      var WinPlace = $("#ModalWinPlace").val();
      $.ajax({
        url: 'functions/UpdateWinner.php',
        type: 'POST',
        data: {winner: idWinner, place: WinPlace},
        success: function(response){
          if(response == "ERROR"){
            alert("Error updating winner, try again later.");
          }else{
            alert("Winner updated.");
          }
        }
      })
      .done(function() {
        console.log("Match created.");
      })
      .fail(function() {
        console.log("Error creating match.");
      })
      .always(function() {
        console.log("complete");
      });
    });

  });
  </script>
</body>

</html>
