<!-- 
sitesInfo call left join
rework database

-->


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

	<?php $page='sites'; include 'includes/head.php'; ?>

</head>

<body>

	<div class="d-flex" id="wrapper">

		<?php include 'includes/sidebar.php'; ?>

		<!-- Page Content -->
		<div id="page-content-wrapper">
		

			<?php include 'includes/menubar.php'; ?>
				
			<div class="container-fluid">
				<h1> Add new site: </h1>
				
				<form action="datawrites/newsite.php" method="post">
					Name: <input type='text' name='sitename'>
					Address: <input type='text' name='address'>
					Code: <input type='text' name='code' oninput="let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);">
					<input type="submit">
				</form>
				
				
				
				
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					Name: <input type='text' name='sitename'>
					Address: <input type='text' name='address'>
					Code: <input type='text' name='code' oninput="let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);">
					<input type="submit">
				</form>
				<br>
			
				<h1> Pending Requests: </h1>
				    <?php
					
						
						if (count($requests) > 0) {
							foreach ($requests as $request) {
								//var_dump($request);
							echo $request['firstname'] . "\t\t" . $request['surname'] . "\t" . $request['buildingsites_buildingsiteID'] . "\t\t" . $request['requestMessage']. "\t\t" . $request['siteregistrationID'] .
										'<a href="datawrites/accept-request.php?siteregistrationid=' .$request['siteregistrationID'] .'"><button>Allow</button>' . "</a>" . "<br>";
								
							}
							
							echo 'datawrites/accept-request.php?siteregistrationid=' .$request['siteregistrationID'];
						} else {
							echo "No pending request at the moment.";
						}
						
					?>
				
				
				<br>
				<br>
				<h1> Current Sites: </h1>
					

				<div class="panel-group" id="accordion">
					<?php
						
						//echo var_dump(json_encode($sites));
						//echo var_dump($sitesInfo);
						
						
						
						if (count($sitesInfo) > 0) {
							$count=1;
							foreach ($sitesInfo as $site) {
								echo '
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$count.'">'. $site->content .'</a>
										</h4>
									</div>
									<div id="collapse'.$count.'" class="panel-collapse collapse in">';
										foreach ($site->gos as $go){
											echo '<h4> '.$go.'</h4>';
										}
										echo '
									</div>
								</div> ';
								$count=$count+1;
							}
						}
						
						
					?>
				

					
				</div>
				
			</div>
		
		<!-- /#page-content-wrapper -->

		</div>
		<!-- /#wrapper -->
	</div>
	
	<!-- Move code to separate php file  -->
	<?php

		
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			$code = $_POST['code'];
			$address = $_POST['address'];
			$sitename = $_POST['sitename'];

			// Prepare an insert statement
			$sql = "INSERT INTO buildingsites (sitename, code, address, admins_adminID) VALUES (:sitename, :code, :address, :adminid)";

		
			if ($stmt = $pdo->prepare($sql)) {
				// Bind variables to the prepared statement as parameters
				$stmt->bindParam(":code", $code, PDO::PARAM_STR);
				$stmt->bindParam(":address", $address, PDO::PARAM_STR);
				$stmt->bindParam(":sitename", $sitename, PDO::PARAM_STR);
				$stmt->bindParam(":adminid", $_SESSION['adminid'], PDO::PARAM_STR);



				// Attempt to execute the prepared statement
				if ($stmt->execute()) {
					// Redirect to screen 3
					header("location: sites.php");
				} else {
					echo "Something went wrong. Please try again later.";
				}	

				// Close statement
				unset($stmt);	
			}
		}

	?>
	
	
  <?php include 'includes/footer.php'; ?>


</body>

</html>
