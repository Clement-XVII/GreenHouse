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
  <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="https://github.com/Clement-XVII/Serre_connectee">Connected GreenHouse</a>
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
                <span>
                  User space
                </span>
                <a class="link-secondary" href="#" aria-label="Add a new report"></a>
              </h6>
              <ul class="nav flex-column mb-2">
                <li class="nav-item">
                  <a class="nav-link active" href="../admin_dash/index.php">
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
          Admin Panel Management
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
          </div>
        </div>
        <!-- *******************************************CONTENU DE MA PAGE******************************************** -->

        <link rel="stylesheet" href="../assets/css/datatables.min.css"/>
        <title>Admin Panel Management</title>

        <body>
        <div class="table-responsive-sm">
          <div class="container-fluid">
            <div class="row">
              <div class="container">
                <div class="row">
                  <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                      <th>Id</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Privileges</th>
                      <th>User deactivation</th>
                      <th>registration date</th>
                      <th>Options</th>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  <div class="col-md-2"></div>
                </div>
              </div>
            </div>
          </div>
          <script src="../assets/js/jquery.min.js"></script>
          <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
          <script src="../assets/js/datatables.min.js"></script>

          <script type="text/javascript">
            $(document).ready(function() {
              $('#example').DataTable({
                "fnCreatedRow": function(nRow, aData, iDataIndex) {
                  $(nRow).attr('id', aData[0]);
                },
                'serverSide': 'true',
                'processing': 'true',
                'paging': 'true',
                'order': [],
                'ajax': {
                  'url': 'fetch_data.php',
                  'type': 'post',
                },
                "columnDefs": [{
                  'target': [5],
                  'orderable': false,
                }]
              });
            });

            $(document).on('submit', '#updateUser', function(e) {
              e.preventDefault();
              //var tr = $(this).closest('tr');
              var date_inscription = $('#date_inscriptionField').val();
              var pseudo = $('#nameField').val();
              var droit = $('#droitField').val();
              var active = $('#activeField').val();
              var email = $('#emailField').val();
              var trid = $('#trid').val();
              var id = $('#id').val();
              if (date_inscription != '' && pseudo != '' && droit != '' && active != '' && email != '') {
                $.ajax({
                  url: "update_user.php",
                  type: "post",
                  data: {
                    date_inscription: date_inscription,
                    pseudo: pseudo,
                    droit: droit,
                    active: active,
                    email: email,
                    id: id
                  },
                  success: function(data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    if (status == 'true') {
                      table = $('#example').DataTable();
                      // table.cell(parseInt(trid) - 1,0).data(id);
                      // table.cell(parseInt(trid) - 1,1).data(pseudo);
                      // table.cell(parseInt(trid) - 1,2).data(email);
                      // table.cell(parseInt(trid) - 1,3).data(droit);
                      // table.cell(parseInt(trid) - 1,4).data(date_inscription);
                      var button = '<td><a href="javascript:void();" data-id="' + id + '" class="btn btn-info btn-sm editbtn">Edit</a>  <a href="#!"  data-id="' + id + '"  class="btn btn-danger btn-sm deleteBtn">Delete</a></td>';
                      var row = table.row("[id='" + trid + "']");
                      row.row("[id='" + trid + "']").data([id, pseudo, email, droit, active, date_inscription, button]);
                      $('#exampleModal').modal('hide');
                    } else {
                      alert('failed');
                    }
                  }
                });
              } else {
                alert('Fill all the required fields');
              }
            });
            $('#example').on('click', '.editbtn ', function(event) {
              var table = $('#example').DataTable();
              var trid = $(this).closest('tr').attr('id');
              // console.log(selectedRow);
              var id = $(this).data('id');
              $('#exampleModal').modal('show');

              $.ajax({
                url: "get_single_data.php",
                data: {
                  id: id
                },
                type: 'post',
                success: function(data) {
                  var json = JSON.parse(data);
                  $('#nameField').val(json.pseudo);
                  $('#emailField').val(json.email);
                  $('#droitField').val(json.droit);
                  $('#activeField').val(json.active);
                  $('#date_inscriptionField').val(json.date_inscription);
                  $('#id').val(id);
                  $('#trid').val(trid);
                }
              })
            });

            $(document).on('click', '.deleteBtn', function(event) {
              var table = $('#example').DataTable();
              event.preventDefault();
              var id = $(this).data('id');
              if (confirm("Are you sure want to delete this User ? ")) {
                $.ajax({
                  url: "delete_user.php",
                  data: {
                    id: id
                  },
                  type: "post",
                  success: function(data) {
                    var json = JSON.parse(data);
                    status = json.status;
                    if (status == 'success') {
                      //table.fnDeleteRow( table.$('#' + id)[0] );
                      //$("#example tbody").find(id).remove();
                      //table.row($(this).closest("tr")) .remove();
                      $("#" + id).closest('tr').remove();
                    } else {
                      alert('Failed');
                      return;
                    }
                  }
                });
              } else {
                return null;
              }



            })
          </script>
          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form id="updateUser">
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="trid" id="trid" value="">
                    <div class="mb-3 row">
                      <label for="nameField" class="col-md-3 form-label">Name</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" id="nameField" name="name">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="emailField" class="col-md-3 form-label">Email</label>
                      <div class="col-md-9">
                        <input type="email" class="form-control" id="emailField" name="email">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="droitField" class="col-md-3 form-label">privileges</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" id="droitField" name="droit">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="activeField" class="col-md-3 form-label">disable</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" id="activeField" name="active">
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label for="date_inscriptionField" class="col-md-3 form-label">registration date</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" id="date_inscriptionField" name="date_inscription">
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </body>

</html>
<script type="text/javascript">
  //var table = $('#example').DataTable();
</script>



<!-- *******************************************FIN DU CONTENU DE MA PAGE************************************** -->
</main>
</div>
</div>
<script src="../assets/js/feather.min.js"></script>
<script>
  feather.replace()
</script>
</body>

</html>