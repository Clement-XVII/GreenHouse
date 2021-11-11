<?php
include "../../connex.php";
?>
<?php
session_start();
require_once '../../config.php'; // ajout connexion bdd 
// si la session existe pas soit si l'on est pas connecté on redirige
if (!isset($_SESSION['user'])) {
  header('Location:../../index.php');
  die();
}

// On récupere les données de l'utilisateur
$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
$req->execute(array($_SESSION['user']));
$data = $req->fetch();

?>

<?php
$x_date  = mysqli_query($connexion, 'SELECT time FROM ( SELECT * FROM sensor ORDER BY id DESC LIMIT 20) Var1 ORDER BY ID ASC');
$y_temp   = mysqli_query($connexion, 'SELECT temp FROM ( SELECT * FROM sensor ORDER BY id DESC LIMIT 20) Var1 ORDER BY ID ASC');
$y_hum   = mysqli_query($connexion, 'SELECT hum FROM ( SELECT * FROM sensor ORDER BY id DESC LIMIT 20) Var1 ORDER BY ID ASC');
$y_hc   = mysqli_query($connexion, 'SELECT hc FROM ( SELECT * FROM sensor ORDER BY id DESC LIMIT 20) Var1 ORDER BY ID ASC');
?>

<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">
      <center>Graphique Température
    </h3>
  </div>

  <div class="panel-body">
    <canvas class="my-4 w-100" id="myChart" width="984" height="546"></canvas>
    <script>
      var canvas = document.getElementById('myChart');
      var data = {
        labels: [<?php while ($b = mysqli_fetch_array($x_date)) {
                    echo '"' . $b['time'] . '",';
                  } ?>],
        datasets: [{
            label: "température",
            fill: true,
            lineTension: 0.1,
            backgroundColor: "rgba(0,123,255, .2)",
            borderColor: "#007bff",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(0,123,255 .7)",
            pointBackgroundColor: "#007bff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(0,123,255 .7)",
            pointHoverBorderColor: "rgba(0,123,255 .7)",
            pointHoverBorderWidth: 2,
            pointRadius: 5,
            pointHitRadius: 10,
            data: [<?php while ($b = mysqli_fetch_array($y_temp)) {
                      echo  $b['temp'] . ',';
                    } ?>],
          },
          {
            label: "Humidité",
            fill: true,
            lineTension: 0.1,
            backgroundColor: "rgb(255, 153, 0, .2)",
            borderColor: "#ff9900",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(255, 153, 0, .7)",
            pointBackgroundColor: "#ff9900",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(255, 153, 0, .7)",
            pointHoverBorderColor: "rgba(255, 153, 0, .7)",
            pointHoverBorderWidth: 2,
            pointRadius: 5,
            pointHitRadius: 10,
            data: [<?php while ($b = mysqli_fetch_array($y_hum)) {
                      echo  $b['hum'] . ',';
                    } ?>],
          },
          {
            label: "Indice de température",
            fill: true,
            lineTension: 0.1,
            backgroundColor: "rgba(255, 0, 0, .2)",
            borderColor: "#ff0000",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(255, 0, 0, .7)",
            pointBackgroundColor: "#ff0000",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(255, 0, 0, .7)",
            pointHoverBorderColor: "rgba(255, 0, 0, .7)",
            pointHoverBorderWidth: 2,
            pointRadius: 5,
            pointHitRadius: 10,
            data: [<?php while ($b = mysqli_fetch_array($y_hc)) {
                      echo  $b['hc'] . ',';
                    } ?>],
          }
        ]
      };

      var option = {
        showLines: true,
        animation: {
          duration: 0
        }
      };

      var myLineChart = Chart.Line(canvas, {
        data: data,
        options: option
      });
    </script>
  </div>
</div>