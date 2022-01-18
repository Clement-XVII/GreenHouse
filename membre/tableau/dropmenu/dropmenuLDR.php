<?php
include "../../../connex.php";
?>
<?php
session_start();
require_once '../../../config.php'; // ajout connexion bdd
// si la session existe pas soit si l'on est pas connecté on redirige
if (!isset($_SESSION['user'])) {
  header('Location:../../../index.php');
  die();                                                                                      //importe le fichier de connexion à la base de données, vérifie si l'utilisateur et connecté ou non et ses droit admin ou membre
}

// On récupere les données de l'utilisateur
$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
$req->execute(array($_SESSION['user']));
$data = $req->fetch();

if ($data['active'] == 1) {
  header('Location: ../../../index.php');
  die();
}
?>
<?php
function filter($choix)
{
    include "../../../connex.php";
    if (isset($_GET['sdate']) || isset($_GET['edate'])) {

        $sdate = $_GET['sdate'];
        $edate = $_GET['edate'];
        $sqlAdmin = mysqli_query($connexion, "SELECT id,time,temp,hum,hc,humsol,sondetemp,gas,gas2 FROM sensor WHERE time BETWEEN ' $sdate ' AND ' $edate ' ORDER BY ID ASC");
            while ($data = mysqli_fetch_array($sqlAdmin)) {
                echo $data[$choix] . ',';
            }
        } else {
        $sqlAdmin = mysqli_query($connexion, "SELECT * FROM (SELECT * FROM sensor ORDER BY id DESC LIMIT 30) time ORDER BY id ASC");
        while ($data = mysqli_fetch_array($sqlAdmin)) {
            echo $data[$choix] . ',';
        }
    }
}
?>
<!-- *****************************************************Création de la barre de navigation*********************************************************** -->
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="../../../globe.ico" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <title>Dashboard</title>
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
  </style>
  <link href="../../../assets/css/dashboard.css" rel="stylesheet">
</head>

<body>
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="https://github.com/Clement-XVII/GreenHouse">Connected GreenHouse</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </header>
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Greenhouse</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
            </a>
          </h6>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="../../dashboard/dashboard.php">
                <span data-feather="home"></span>
                Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../../jauge/jauge.php">
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
              <a class="nav-link active" href="../../tableau/tableau.php">
                <span data-feather="bar-chart-2"></span>
                Dashboard
              </a>
            </li>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>House</span>
              <a class="link-secondary" href="#" aria-label="Add a new report">
              </a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="http://192.168.1.28/">
                  <span data-feather="printer"></span>
                  Octoprint
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../../camera/camera.php">
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
                  <a class="nav-link" href="../../utilisateur/change_pwd.php">
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
                  <li><a class="dropdown-item" href="../../utilisateur/deconnexion.php">Sign out</a></li>
                </ul>
              </div>
            </ul>
          </ul>
        </div>
      </nav>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Data control center</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <a type="button" class="btn btn-sm btn-outline-secondary" href="https://www.lycee-saint-cricq.org/">Lycée St Cricq</a>
              <a type="button" class="btn btn-sm btn-outline-secondary" href="https://www.lycee-saint-cricq.org/formations/enseignement-secondaire/bac-pro-sn/">Bac Pro SN</a>
            </div>
            <div class="btn-group me-2">
              <a type="button" class="btn btn-sm btn-outline-secondary" onclick="Export()">Export to CSV file</a>
              <a type="button" class="btn btn-sm btn-outline-secondary" href='../../../serreconnectee.sql'>Recover SQL</a>
            </div>
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
              <a href='../tableau.php' class='btn btn-sm btn-outline-secondary'>Home</a>
              <a href='../alldata.php' class='btn btn-sm btn-outline-secondary'>All data</a>
              <a href='../multichart.php' class='btn btn-sm btn-outline-secondary'>Multi Chart</a>
              <a class='btn btn-sm btn-outline-secondary' id="smooth">Smooth Chart</a>
              <div class="btn-group" role="group">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  Select data sensor
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="dropmenuTemp.php">Temperature</a></li>
                  <li><a class="dropdown-item" href="dropmenuHum.php">Humidity</a></li>
                  <li><a class="dropdown-item" href="dropmenuCO2.php">CO2</a></li>
                  <li><a class="dropdown-item" href="dropmenuO2.php">O2</a></li>
                  <li><a class="dropdown-item" href="dropmenuLDR.php">LDR</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <script>
          function Export() {
            var conf = confirm("Export to CSV file ?");
            if (conf == true) {
              window.open("../export.php", '_blank');
            }
          }
        </script>
        <div class="panel-body">
          <form class="form-horizontal" method="GET">
            <div class="form-group">
              <label class="col-md-2">From</label>
              <div class="col-md-2">
                <input type="date" name="sdate" class="form-control" value="<?php echo $sdate; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2">to</label>
              <div class="col-md-2">
                <input type="date" name="edate" class="form-control" value="<?php echo $edate; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2"></label>
              <div class="col-md-8">
                <input type="submit" class="btn btn-primary" value="Filter">
                <a href='tableau.php' class='btn btn-warning '>Reset</a>
              </div>
            </div>
          </form>
          <!-- ********************************************************************************************************************************************************************************************* -->
          <?php
          if (isset($_GET['sdate']) || isset($_GET['edate'])) {

            $sdate = $_GET['sdate'];
            $edate = $_GET['edate'];
            $sqlAdmin = mysqli_query($connexion, "SELECT id,time,temp,hum,hc,humsol FROM sensor WHERE time BETWEEN ' $sdate ' AND ' $edate ' ORDER BY ID ASC");
          } else {
            //$sqlAdmin = mysqli_query($connexion, "SELECT id,time,temp,hum,hc,humsol FROM sensor ORDER BY ID DESC LIMIT 30");
	    $sqlAdmin = mysqli_query($connexion, "SELECT * FROM (SELECT * FROM sensor ORDER BY id DESC LIMIT 30) time ORDER BY id ASC");
          }
          ?>
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
          <canvas id="myChart" width="900" height="380"></canvas>
          <script>


            let smooth = false;
            const actions = [
              {
                handler(chart1) {
                  smooth = !smooth;
                  chart1.options.elements.line.tension = smooth ? 0.4 : 0;
                  chart1.update();

                }
              }
            ];

            actions.forEach((a, i) => {
            const smooth = document.getElementById('smooth');
            smooth.onclick = () => a.handler(myChart);
            });
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
              type: 'line',
              data: {
                labels: [<?php while ($data = mysqli_fetch_array($sqlAdmin)) {
                            echo '"' . $data['time'] . '",';
                          } ?>],
                datasets: [
                    {
                  label: 'CO2',
                  data: [<?php filter(ldr); ?>],
                  backgroundColor: [
                    'rgba(190,190,190, .2)',
                  ],
                  borderColor: [
                    'rgba(190, 190, 190, 1)',
                  ],
                  borderWidth: 1.5,
                  hidden: false
                }]
              },
              options: {
                scales: {
                  x: {
                    //reverse: true,
                    ticks: {
                          //minRotation: 70,
                     }
                  },
                  y: {
                    beginAtZero: false,
                  }
                }
              }
            });
          </script>
          <!-- ********************************************************************************************************************************************************************************************* -->
          <?php
          if (isset($_GET['sdate']) || isset($_GET['edate'])) {

            $sdate = $_GET['sdate'];
            $edate = $_GET['edate'];
            $sqlAdmin = mysqli_query($connexion, "SELECT id,time,temp,hum,hc,humsol,sondetemp,gas,gas2,ldr FROM sensor WHERE time BETWEEN ' $sdate ' AND ' $edate ' ORDER BY ID DESC LIMIT 0,100");
          } else {
            $sqlAdmin = mysqli_query($connexion, "SELECT id,time,temp,hum,hc,humsol,sondetemp,gas,gas2,ldr FROM sensor ORDER BY ID DESC LIMIT 0,100");
          }

          ?>
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                <th class='text-center'>ID</th>
                <th class='text-center'>Date</th>
                <th class='text-center'>Temperature (°C)</th>
                <th class='text-center'>Humdity (%)</th> <!-- Création du tableau avec nom des colonnes -->
                <th class='text-center'>Heat index (°C)</th>
                <th class='text-center'>Soil Moisture Sensor (%)</th>
                <th class='text-center'>Temperature Sensor Probe (°C)</th>
                <th class='text-center'>CO2 (ppm)</th>
                <th class='text-center'>O2 (%)</th>
                <th class='text-center'>LDR (Lux)</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($data = mysqli_fetch_array($sqlAdmin)) {
                  echo "<tr >
<td><center>$data[id]</td>
<td><center>$data[time]</center></td>
<td><center>$data[temp]</td>
<td><center>$data[hum]</td>
<td><center>$data[hc]</td>
<td><center>$data[humsol]</td>
<td><center>$data[sondetemp]</td>
<td><center>$data[gas]</td>
<td><center>$data[gas2]</td>
<td><center>$data[ldr]</td>
</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  </div>
  <script src="../../../assets/js/jquery.min.js"></script>
  <script src="../../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../../assets/js/feather.min.js"></script>
  <script src="../../../assets/js/Chart.min.js"></script>
  <script>
    feather.replace()
  </script>
</body>

</html>
