<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';

//variables
$email = $_SESSION['user']['email'];
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST['code'];
    $message = $_POST['message'];

    if (codeExists($code) === false) {
        $msg = "Code doesn't exist.";
    } else {
        // Prepare an insert statement
        $sql = "INSERT INTO siteregistrations (users_userID, buildingsites_buildingsiteID, status, requestMessage) VALUES (:userid, :buildingsiteID, 'pending', :message)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":userid", $param_userid, PDO::PARAM_STR);
            $stmt->bindParam(":buildingsiteID", $param_buildingsiteID, PDO::PARAM_STR);
            $stmt->bindParam(":message", $param_message, PDO::PARAM_STR);

            // Set parameters
            $param_userid = $_SESSION['user']['userID'];
            $site = siteByCode($code);
            $param_buildingsiteID = $site['buildingsiteID'];
            $param_message = $message;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to screen 3
                header("location: register-site.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>GO register site</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="vendor/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- sidebar -->
    <?php $page='registersite';include 'includes/sidebar.php';?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php include 'includes/topbar.php';?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Register for a site.</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
              <label for="code">Code</label>
              <input type="text" class="form-control" id="code" placeholder="" name="code" oninput="let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);">
              <p class="text-danger"><?php echo $msg;?></p>
            </div>

            <div class="form-group">
              <label for="message">Message</label>
              <textarea class="form-control" name="message" id="message" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary form-control">Submit</button>
            </form>

        </div>
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
