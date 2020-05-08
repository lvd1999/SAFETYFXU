<?php

session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$_SESSION['user'] = userDetails($_SESSION['id']);
//get details
$userDetail = userDetails($_SESSION['user']['userID']);
$safepass = get_safepass($_SESSION['user']['userID']);
$certs = get_cert($_SESSION['user']['userID']);
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>GO Profile</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="vendor/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- sidebar -->
    <?php $page='profile';include 'includes/sidebar.php';?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php include 'includes/topbar.php';?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Profile</h1>
          <form>
            <div class="form-group mx-auto" style="width:200px">
              <img src="profileImages/<?php echo $_SESSION['user']['profileImage'];?>" onClick='triggerClick()'
                id='profileDisplay' class="img-fluid" id="profile">
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="FirstName">First Name</label>
                <input type="text" readonly class="form-control" id="FirstName"
                  placeholder="<?php echo $_SESSION['user']['firstname'];?>">
              </div>
              <div class="col-sm-6">
                <label for="Surname">Surname</label>
                <input type="text" readonly class="form-control" id="Surname"
                  placeholder="<?php echo $_SESSION['user']['surname'];?>">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="InputEmail">Email</label>
                <input type="text" readonly class="form-control" id="InputEmail"
                  placeholder="<?php echo $_SESSION['user']['email'];?>">
              </div>
              <div class="col-sm-6">
                <label for="phone">Phone</label>
                <input type="text" readonly class="form-control" id="phone"
                  placeholder="<?php echo $_SESSION['user']['phone'];?>">
              </div>
            </div>

            <div class="form-group">
              <label for="date">Date of Birth</label>
              <input type="text" readonly class="form-control" id="date"
                placeholder="<?php echo $_SESSION['user']['dob'];?>">
            </div>

            <div class="form-group">
              <label for="sex">Gender</label>
              <input type="text" readonly class="form-control" id="sex"
                placeholder="<?php echo $_SESSION['user']['sex'];?>">
            </div>

            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="occupation">Occupation</label>
                <input type="text" readonly class="form-control" id="occupation"
                  placeholder="<?php echo $_SESSION['user']['occupation'];?>">
              </div>

              <div class="col-sm-6">
                <label for="position">Position</label>
                <input type="text" readonly class="form-control" id="position"
                  placeholder="<?php echo $_SESSION['user']['position'];?>">
              </div>
            </div>
            <div class="form-group">
              <label for="nationality">Nationality</label>
              <input type="text" readonly class="form-control" id="nationality"
                placeholder="<?php echo $_SESSION['user']['nationality'];?>">
            </div>
            <div class="form-group">
              <label for="english">English</label>
              <input type="text" readonly class="form-control" id="english"
                placeholder="<?php echo $_SESSION['user']['english'];?>">
            </div>

          </form>

          <h1>Certificates</h1>
          <h3>Safe Pass</h3>
          <?php if(empty($safepass)) { ?>
          No safepass.
          <?php } else { ?>
          <!-- <img id="certImg" class="img-fluid" src="certificates/<?php echo $safepass['certImageFront']?>"> -->

          <div class="card mx-auto" style="width: 200px;">
            <img src="certificates/<?php echo $safepass['certImageFront'];?>" class="card-img-top">
            <div class="card-body">
              <p class="card-text">Front</p>
            </div>
          </div>

          <div class="card mx-auto" style="width: 200px;">
            <img src="certificates/<?php echo $safepass['certImageBack'];?>" class="card-img-top">
            <div class="card-body">
              <p class="card-text">Back</p>
            </div>
          </div>

          <?php } ?>

          <h3>Other certificates</h3>
          <?php if(count($certs) <=0) { ?>
          No other certificates.
          <?php } else { foreach($certs as $cert) {?>
          <div class="card mx-auto" style="width: 200px;">
            <img src="certificates/<?php echo $cert['certImageFront'];?>" class="card-img-top">
            <div class="card-body">
              <p class="card-text"><?php echo $cert['type'];?></p>
            </div>
          </div>


          <?php } }?>
        </div> <!-- end of container-fluid -->
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- footer -->
      <?php include 'includes/footer.php';?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- logout modal -->
  <?php include 'includes/logoutmodal.php';?>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="vendor/js/sb-admin-2.min.js"></script>

</body>

</html>