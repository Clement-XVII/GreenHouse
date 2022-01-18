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

if ($data['active'] == 1) {
  header('Location: ../../index.php');
  die();
}
?>
<?php
$time = '';
$temp = '';
$hum = '';
$hc = '';
$humsol = '';
$sondetemp = '';
$gas = '';
$gas2 = '';
$ldr = '';
$today = date("Y-m-d H:i:s");
$tommorow = date('Y-m-d H:i:s', strtotime($today . ' +1 day'));
//query to get data from the table
//'2021-04-13 00:00:00'
$sql = "SELECT time, temp,hum,hc,humsol,sondetemp,gas,gas2,ldr FROM sensor ORDER BY id DESC";
//$sql = "SELECT * FROM sensor WHERE id BETWEEN 50 AND 100";
//"SELECT order_date, SUM(grand_total) AS total_grand  FROM orders GROUP BY order_date LIMIT = 15";
$result = mysqli_query($connexion, $sql);
//loop through the returned data
while ($row = mysqli_fetch_array($result)) {

  $time = $time . '"' . $row['time'] . '",';
  $temp = $temp . '"' . $row['temp'] . '",';
  $hum = $hum . '"' . $row['hum'] . '",';
  $hc = $hc . '"' . $row['hc'] . '",';
  $humsol = $humsol . '"' . $row['humsol'] . '",';
  $sondetemp = $sondetemp . '"' . $row['sondetemp'] . '",';
  $gas = $gas . '"' . $row['gas'] . '",';
  $gas2 = $gas2 . '"' . $row['gas2'] . '",';
  $ldr = $ldr . '"' . $row['ldr'] . '",';
}


$time = trim($time, ",");
$temp = trim($temp, ",");
$hum = trim($hum, ",");
$hc = trim($hc, ",");
$humsol = trim($humsol, ",");
$sondetemp = trim($sondetemp, ",");
$gas = trim($gas, ",");
$gas2 = trim($gas2, ",");
$ldr = trim($ldr, ",");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="../../globe.ico" />
  <link href="../../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <title>Gauge</title>
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .container {
      width: auto;
      margin: 0 auto;
      text-align: center;
    }

    .gauge {
      width: 350px;
      height: 350px;
      display: inline-block;
    }
  </style>
  <link href="../../assets/css/dashboard.css" rel="stylesheet">
</head>

<body>
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="https://github.com/Clement-XVII/Serre_connectee">Connected GreenHouse</a>
    <!--px-2-->
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </header>
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <!--px-2-->
            <span>Greenhouse</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
            </a>
          </h6>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="../dashboard/dashboard.php">
                <span data-feather="home"></span>
                Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../jauge/jauge.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gauge">
                  <path d="M19.778,21.32C21.841,19.272 23,16.495 23,13.599C23,11.891 22.604,10.274 21.899,8.834" />
                  <path d="M19.024,5.198C17.118,3.626 14.669,2.68 12,2.68C5.929,2.68 1,7.573 1,13.599C1,16.495 2.159,19.272 4.222,21.32" />
                  <path id="needle" d="M13.184,12.694L21.241,6.538" />
                  <circle id="center" cx="12" cy="13.599" r="1.456" />
                  <path id="display" d="M15.753,18.86C15.753,18.408 15.385,18.041 14.933,18.041L9.067,18.041C8.615,18.041 8.247,18.408 8.247,18.86L8.247,20.5C8.247,20.953 8.615,21.32 9.067,21.32L14.933,21.32C15.385,21.32 15.753,20.953 15.753,20.5L15.753,18.86Z" />
                </svg>
                Gauge
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../tableau/tableau.php">
                <span data-feather="bar-chart-2"></span>
                Dashboard
              </a>
            </li>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <!--px-2-->
              <span>House</span>
              <a class="link-secondary" href="#" aria-label="Add a new report">
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="https://octoprint.org/">
                  <span data-feather="printer"></span>
                  Octoprint
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../camera/camera.php">
                  <span data-feather="camera"></span>
                  Webcams
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="http://srv-sn64.quickconnect.to/">
                  <span data-feather="hard-drive"></span>
                  NAS Synology
                </a>
              </li>
              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>User space</span>
                <a class="link-secondary" href="#" aria-label="Add a new report">
                </a>
              </h6>
              <ul class="nav flex-column mb-2">
                <li class="nav-item">
                  <a class="nav-link" href="../utilisateur/change_pwd.php">
                    <span data-feather="lock"></span>
                    Change your password
                  </a>
                </li>
              </ul>
              <hr>
              <div class="dropdown px-3">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                  <span data-feather="user" class="rounded-circle me-2"></span>
                  <strong><?php echo $data['pseudo']; ?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                  <li><a class="dropdown-item" href="../utilisateur/deconnexion.php">Sign out</a></li>
                </ul>
              </div>
            </ul>
          </ul>
        </div>
      </nav>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Gauge</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <a type="button" class="btn btn-sm btn-outline-secondary" href="https://www.lycee-saint-cricq.org/">Lycée St Cricq</a>
            </div>
            <a type="button" class="btn btn-sm btn-outline-secondary" href="https://www.lycee-saint-cricq.org/formations/enseignement-secondaire/bac-pro-sn/">Bac Pro SN</a>
          </div>
        </div>
        <div class="container">
          <div id="g" class="gauge"></div>
          <div id="g1" class="gauge"></div>
          <div id="g2" class="gauge"></div>
          <div id="g3" class="gauge"></div>
          <div id="g4" class="gauge"></div>
          <div id="g5" class="gauge"></div>
          <div id="g6" class="gauge"></div>
          <div id="g7" class="gauge"></div>
        </div>
        <script src="../../assets/js/raphael-2.1.4.min.js"></script>
        <script src="../../assets/js/justgage.js"></script>
        <script>
          var g = new JustGage({
            id: "g",
            label: "Temperature",
            value: [<?php echo $temp; ?>],
            symbol: ' °C',
            valueFontColor: "grey",
            min: 0,
            max: 40,
            decimals: 2,
            gaugeWidthScale: 0.6,
            pointer: true,

            pointerOptions: {
              toplength: 8,
              bottomlength: -20,
              bottomwidth: 6,
              color: '#8e8e93'
            },
            gaugeWidthScale: -0.1,

            customSectors: [{
              color: "#ff0000",
              lo: 0,
              hi: 10
            }, {
              color: "#ffff00",
              lo: 10,
              hi: 20
            }, {
              color: "#00ff00",
              lo: 20,
              hi: 25
            }, {
              color: "#ffff00",
              lo: 25,
              hi: 30
            }, {
              color: "#ff0000",
              lo: 30,
              hi: 40
            }],
          });

          var g1 = new JustGage({
            id: "g1",
            label: "Humidity",
            value: [<?php echo $hum; ?>],
            symbol: ' %',
            valueFontColor: "grey",
            min: 0,
            max: 100,
            decimals: 2,
            gaugeWidthScale: 0.6,
            pointer: true,

            pointerOptions: {
              toplength: 8,
              bottomlength: -20,
              bottomwidth: 6,
              color: '#8e8e93'
            },
            gaugeWidthScale: -0.1,

            customSectors: [{
              color: "#ff0000",
              lo: 0,
              hi: 30
            }, {
              color: "#ffff00",
              lo: 30,
              hi: 40
            }, {
              color: "#00ff00",
              lo: 40,
              hi: 70
            }, {
              color: "#ffff00",
              lo: 70,
              hi: 80
            }, {
              color: "#ff0000",
              lo: 80,
              hi: 100
            }],
          });

          var g2 = new JustGage({
            id: "g2",
            label: "Soil Moisture Sensor",
            value: [<?php echo $humsol; ?>],
            symbol: ' %',
            valueFontColor: "grey",
            min: 0,
            max: 100,
            gaugeWidthScale: 0.6,
            pointer: true,

            pointerOptions: {
              toplength: 8,
              bottomlength: -20,
              bottomwidth: 6,
              color: '#8e8e93'
            },
            gaugeWidthScale: -0.1,

            customSectors: [{
              color: "#ff0000",
              lo: 0,
              hi: 40
            }, {
              color: "#ffff00",
              lo: 40,
              hi: 61
            }, {
              color: "#00ff00",
              lo: 61,
              hi: 71
            }, {
              color: "#ffff00",
              lo: 71,
              hi: 85
            }, {
              color: "#ff0000",
              lo: 85,
              hi: 100
            }],
          });

          var g3 = new JustGage({
            id: "g3",
            label: "Heat index",
            value: [<?php echo $hc; ?>],
            symbol: ' °C',
            valueFontColor: "grey",
            min: 0,
            max: 40,
            decimals: 2,
            gaugeWidthScale: 0.6,
            pointer: true,

            pointerOptions: {
              toplength: 8,
              bottomlength: -20,
              bottomwidth: 6,
              color: '#8e8e93'
            },
            gaugeWidthScale: -0.1,

            customSectors: [{
              color: "#ff0000",
              lo: 0,
              hi: 10
            }, {
              color: "#ffff00",
              lo: 10,
              hi: 20
            }, {
              color: "#00ff00",
              lo: 20,
              hi: 25
            }, {
              color: "#ffff00",
              lo: 25,
              hi: 30
            }, {
              color: "#ff0000",
              lo: 30,
              hi: 40
            }],
          });

          var g4 = new JustGage({
            id: "g4",
            label: "Temperature Sensor Probe",
            value: [<?php echo $sondetemp; ?>],
            symbol: ' °C',
            valueFontColor: "grey",
            min: 0,
            max: 40,
            decimals: 2,
            gaugeWidthScale: 0.6,
            pointer: true,

            pointerOptions: {
              toplength: 8,
              bottomlength: -20,
              bottomwidth: 6,
              color: '#8e8e93'
            },
            gaugeWidthScale: -0.1,

            customSectors: [{
              color: "#ff0000",
              lo: 0,
              hi: 10
            }, {
              color: "#ffff00",
              lo: 10,
              hi: 20
            }, {
              color: "#00ff00",
              lo: 20,
              hi: 25
            }, {
              color: "#ffff00",
              lo: 25,
              hi: 30
            }, {
              color: "#ff0000",
              lo: 30,
              hi: 40
            }],
          });

          var g5 = new JustGage({
            id: "g5",
            label: "O2",
            value: [<?php echo $gas2; ?>],
            symbol: ' %',
            valueFontColor: "grey",
            min: 0,
            max: 100,
            decimals: 2,
            gaugeWidthScale: 0.6,
            pointer: true,

            pointerOptions: {
              toplength: 8,
              bottomlength: -20,
              bottomwidth: 6,
              color: '#8e8e93'
            },
            gaugeWidthScale: -0.1,

            customSectors: [{
              color: "#ff0000",
              lo: 0,
              hi: 6
            }, {
              color: "#ffff00",
              lo: 6, //  taux normaux dans l'atmasphèere
              hi: 17
            }, {
              color: "#00ff00",
              lo: 19, // lieux fermés ok
              hi: 21
            }, {
              color: "#ffff00",
              lo: 21,
              hi: 25
            }, {
              color: "#ff0000",
              lo: 25,
              hi: 100
            }],
          });

          var g6 = new JustGage({
            id: "g6",
            label: "CO2",
            value: [<?php echo $gas; ?>],
            symbol: ' ppm',
            valueFontColor: "grey",
            min: 0,
            max: 5000,
            gaugeWidthScale: 0.6,
            pointer: true,

            pointerOptions: {
              toplength: 8,
              bottomlength: -20,
              bottomwidth: 6,
              color: '#8e8e93'
            },
            gaugeWidthScale: -0.1,

            customSectors: [{
              color: "#ff0000",
              lo: 0,
              hi: 380
            }, {
              color: "#ffff00",
              lo: 380, //  taux normaux dans l'atmasphèere
              hi: 480
            }, {
              color: "#00ff00",
              lo: 480, // lieux fermés ok
              hi: 800
            }, {
              color: "#24a319",
              lo: 800, // lieux fermés ok 			//800-1100 parfait
              hi: 2000
            }, {
              color: "#ffff00",
              lo: 2000,
              hi: 3000
            }, {
              color: "#ff0000",
              lo: 3000,
              hi: 5000
            }],
          });

          var g7 = new JustGage({
            id: "g7",
            label: "LDR",
            value: [<?php echo $ldr; ?>],
            symbol: ' Lux',
            valueFontColor: "grey",
            min: 180,
            max: 750,
            decimals: 0,
            gaugeWidthScale: 0.6,
            pointer: true,

            pointerOptions: {
              toplength: 8,
              bottomlength: -20,
              bottomwidth: 6,
              color: '#8e8e93'
            },
            gaugeWidthScale: -0.1,

            customSectors: [{
              color: "#848484",
              lo: 0,
              hi: 100
            }, {
              color: "#9e9c82",
              lo: 200,
              hi: 300
            }, {
              color: "#d1ce7a",
              lo: 300,
              hi: 400
            }, {
              color: "#e1df76",
              lo: 500,
              hi: 600
            }, {
              color: "#fafa6e",
              lo: 600,
              hi: 750
            }],
          });
        </script>
        <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/js/feather.min.js"></script>
        <script>
          feather.replace()
        </script>
</body>

</html>