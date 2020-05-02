<?php
// Initialize the session
session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';
 
//variables
$_SESSION['admin'] = adminDetails($_SESSION['adminid']);
$company_name = $_SESSION['admin']['companyName'];
$username = $_SESSION['username'];
$_SESSION['adminid'] = $_SESSION['admin']['adminID'];
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php include 'includes/head.php'; ?>

</head>

<body>

  <div class="d-flex" id="wrapper">

	<?php $page='dashboard'; include 'includes/sidebar.php'; ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

		<?php include 'includes/menubar.php'; ?>

      <div class="container-fluid">
      <a href="editprofile.php"><button>Edit</button></a> <br>
      <img src="profileImages/<?php echo $_SESSION['admin']['image'];?>" id="profileDisplay"> <br>
        <h3 class="mt-4">Company name: <?php echo $_SESSION['admin']['companyName']; ?> </h3>
		    <h3 class="mt-4">Admin Name: <?php echo $_SESSION['admin']['username']; ?></h3>
		    <h3 class="mt-4">Email: <?php echo $_SESSION['admin']['email']; ?></h3>
		    <h3 class="mt-4">First Name: <?php echo $_SESSION['admin']['firstname']; ?></h3>
		    <h3 class="mt-4">SurName: <?php echo $_SESSION['admin']['surname']; ?></h3>
		    <h3 class="mt-4">Address: <?php echo $_SESSION['admin']['address']; ?></h3>
		    <h3 class="mt-4">City: <?php echo $_SESSION['admin']['city']; ?></h3>
		    <h3 class="mt-4">Country: <?php echo $_SESSION['admin']['country']; ?></h3>
		    <h3 class="mt-4">Eircode: <?php echo $_SESSION['admin']['eircode']; ?></h3>
		    <h3 class="mt-4">Landline Number: <?php echo $_SESSION['admin']['landlineNumber']; ?></h3>
		    <h3 class="mt-4">Mobile Phone: <?php echo $_SESSION['admin']['mobileNumber']; ?></h3>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <?php include 'includes/footer.php'; ?>


</body>

</html>
