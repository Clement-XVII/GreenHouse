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

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="icon" href="../../globe.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
  <title>Live data</title>
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
  <link href="../../assets/css/dashboard.css" rel="stylesheet">
</head>

<body>
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="https://github.com/Clement-XVII/Serre_connectee">Serre connectée</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </header>
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Serre</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
            </a>
          </h6>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="../dashboard/dashboard_membre.php">
                <span data-feather="home"></span>
                Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../jauge/jauge_membre.php">
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
              <a class="nav-link" href="../tableau/tableau_membre.php">
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
                <a class="nav-link" href="../camera/camera_membre.php">
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
          <h1 class="h2">Live Data</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <a type="button" class="btn btn-sm btn-outline-secondary" href="https://www.lycee-saint-cricq.org/">Lycée St Cricq</a>

            </div>
            <a type="button" class="btn btn-sm btn-outline-secondary" href="https://www.lycee-saint-cricq.org/formations/enseignement-secondaire/bac-pro-sn/">Bac Pro SN</a>
          </div>
        </div>

        <script>
          var refreshId = setInterval(function() {
            $('#responsecontainer').load('data.php');
          }, 1000);
        </script>
        <div class="container">
          <script type="text/javascript" src="../../assets/js/mdb.min.js"></script>
          <div id="responsecontainer">
          </div>
        </div>
        
        <body>
          <script>
            $(document).ready(function() {
              var table = $('#example').DataTable({
                responsive: true
              });

              new $.fn.dataTable.FixedHeader(table);
            });
          </script>
          <div class="table-responsive-sm">
            <table id="example" class="table table-striped" style="width:100%">
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
                </tr>
              </thead>
              <tbody>
                <!-- Ajoute les données dans le tableau -->
                <?php
                $sqlAdmin = mysqli_query($connexion, "SELECT id,time,temp,hum,hc,humsol,sondetemp,gas,gas2 FROM sensor ORDER BY ID DESC LIMIT 100");
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
</tr>";
                }
                ?>
            </table>
          </div>

        <script src="../../assets/js/feather.min.js"></script>
        <script>
          feather.replace()
        </script>
</body>

</html>