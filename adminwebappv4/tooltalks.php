<?php
// Initialize the session
session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';

//variables
$_SESSION['admin'] = adminDetails($_SESSION['adminid']);
$company_name = $_SESSION['admin']['companyName'];
$username = $_SESSION['username'];

$sites = get_sites($_SESSION['adminid']);
$newsites = get_newsites($_SESSION['adminid']);
$requests = get_pendingrequest($_SESSION['adminid']);

//new data
$sitesInfo = json_decode(get_sitesInfo($_SESSION['adminid']));

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php $page='tooltalks'; include 'includes/head.php'; ?>

</head>

<body>

<?php include 'includes/sidebar.php'; ?>
<div id="right-panel" class="right-panel">
	<div class="wrapper" id="wrapper">
			<?php include 'includes/menubar.php'; ?>
		<div class="main-panel">
			<!-- Page Content -->
			<div class="content"> 
		
      <div class="container-fluid">
        <h1 class="mt-4">Tooltalk 1:</h1>
		<p>blah da blah.</p>

		<h1 class="mt-4">Tooltalk 2:</h1>
        <p>blah da blah.</p>
      </div>
    
</div>
	
	</div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <?php include 'includes/footer.php'; ?>
  <script src="./js/demo.js"></script>

</body>

</html>
