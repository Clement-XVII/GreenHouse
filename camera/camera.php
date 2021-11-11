<!-- *******************************************Importation du fichier de connexion et vérification l'utilisateur******************************************** -->
<?php
include "../connex.php";
?>
<?php
session_start();
require_once '../config.php'; // ajout connexion bdd
// si la session existe pas soit si l'on est pas connecté on redirige
if (!isset($_SESSION['user'])) {
  header('Location:../index.php');
  die();
}

// On récupere les données de l'utilisateur
$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE token = ?');
$req->execute(array($_SESSION['user']));
$data = $req->fetch();

if ($data['droit'] == 0) {
  header('Location: ../index.php');
  die();
}
if ($data['active'] == 1) {
  header('Location: ../index.php');
  die();
}
?>
<!-- *******************************************Création de la barre de navigation******************************************** -->
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="icon" href="../globe.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" href="../assets/js/jquery.min.js"></script>
  <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <title>Webcams</title>
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
  <link href="../assets/css/dashboard.css" rel="stylesheet">
</head>

<body>
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="https://github.com/Clement-XVII/Serre_connectee">Connected Greenhouse</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </header>
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>
              Greenhouse
            </span>
            <a class="link-secondary" href="#" aria-label="Add a new report"></a>
          </h6>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="../dashboard/index.php">
                <span data-feather="home"></span>
                Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../jauge/jauge.php">
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
              <span>
                House
              </span>
              <a class="link-secondary" href="#" aria-label="Add a new report"></a>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="http://192.168.1.28/">
                  <span data-feather="printer"></span>
                  Octoprint
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="../camera/camera.php">
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
                <span>
                  User space
                </span>
                <a class="link-secondary" href="#" aria-label="Add a new report"></a>
              </h6>
              <ul class="nav flex-column mb-2">
                <li class="nav-item">
                  <a class="nav-link" href="../admin_dash/index.php">
                    <span data-feather="users"></span>
                    Admin Panel Management
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../utilisateur/change_pwd.php">
                    <span data-feather="lock"></span>
                    Change your password
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../utilisateur/inscription_admin.php">
                    <span data-feather="user-plus"></span>
                    New user
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
          <h1 class="h2">
            Webcams
          </h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
              <a type="button" class="btn btn-sm btn-outline-secondary" href="https://www.lycee-saint-cricq.org/">
                Lycée St Cricq
              </a>
              <a type="button" class="btn btn-sm btn-outline-secondary" href="https://www.lycee-saint-cricq.org/formations/enseignement-secondaire/bac-pro-sn/">
                Bac Pro SN
              </a>
            </div>
            <div class="btn-group me-2">
              <a type="button" class="btn btn-sm btn-outline-secondary" href="https://picdumidi.com/">
                Pic du Midi
              </a>
            </div>
          </div>
        </div>
        <!-- *******************************************CONTENU DE MA PAGE******************************************** -->
        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item" src="https://broadcast.viewsurf.com/28a84b3cd52dabcf8e1d5594d484b747/capture/9933/playEmbed" width="800px" height="600px" frameborder=0 scrolling=no seamless webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
          <iframe class="embed-responsive-item" src="https://pv.viewsurf.com/2028/Pic-du-Midi?i=NzQxMjo" width="800" height="600" frameborder="0" scrolling="no" allowfullscreen="allowfullscreen"></iframe>
          <iframe class="embed-responsive-item" src="https://pv.viewsurf.com/922/Pic-du-Midi?i=NzQxMjo" width="800" height="600" frameborder="0" scrolling="no" allowfullscreen="allowfullscreen"></iframe>
          <iframe class="embed-responsive-item" src="https://pv.viewsurf.com/2028/Pic-du-Midi?i=NzQxNjo" width="800" height="600" frameborder="0" scrolling="no" allowfullscreen="allowfullscreen"></iframe>
          <iframe class="embed-responsive-item" src="https://pv.viewsurf.com/2028/Pic-du-Midi?i=NzQxMDo" frameborder="0" scrolling="no" allowfullscreen width="800" height="600"></iframe>
          <!--	  <iframe class="embed-responsive-item" src="http://192.168.1.28/webcam/?action=stream" width="800" height="600" frameborder="0" scrolling="no" allowfullscreen="allowfullscreen"></iframe> -->
        </div>
        <!-- *******************************************FIN DU CONTENU DE MA PAGE************************************** -->
      </main>
    </div>
  </div>
  <script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/feather.min.js"></script>
  <script>
    feather.replace()
  </script>
</body>

</html>