<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';
//variables
$_SESSION['admin'] = adminDetails($_SESSION['admin']['adminID']);
$company_name = $_SESSION['admin']['companyName'];
$username = $_SESSION['username'];

$docsss = docsByAdmin($_SESSION['admin']['adminID']);
$newdocs = newDocsByAdmin($_SESSION['admin']['adminID']);
$sites = get_sites($_SESSION['admin']['adminID']);


// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] !== true) {
    header("location: login.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

	<?php $page='documents'; include 'includes/head.php'; ?>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>

	<div class="d-flex" id="wrapper">

		<?php include 'includes/sidebar.php'; ?>

		<!-- Page Content -->
		<div id="page-content-wrapper">

			<?php include 'includes/menubar.php'; ?>

			<div class="container-fluid">

				<h1 class="mt-4">Add Document:</h1>
				<p></p>

				<!-- File upload -->
				<form action="datawrites/upload_file.php" method="post" enctype="multipart/form-data">

					<input type="file" name="file" size="50" required />
					Filename: <input type="text" name="docname" size="50" />

					<br />

					<input type="submit" value="Upload" />

				</form>




				<!-- End File Upload-->

				<h1 class="mt-4">New Documents:</h1>

				<p></p>

				<?php
		
			//echo var_dump($newdocs);
		
			$count = 1;
			foreach($newdocs as $doc) { ?>
				<a href="pdf/<?php echo $doc['name']; ?>" target="_blank" />
				<!--?php echo var_dump($doc); ?-->
				<?php echo "No site: ". $doc['title']; ?> </a>
				<button onclick="myFunction(<?php echo $doc['documentID']; ?>)">Edit Sites</button>
				<br>
				<div style="display:none" id="sitediv<?php echo $doc['documentID']; ?>">

					<form method="post" action="datawrites/updatenewdocsite.php">
						<input type="hidden" id="docId" name="docid" value="<?php echo $doc['documentID']; ?>">
						<select class="custom-select" name="site">
							<option value="0"> "None" </option>
							<?php 
							foreach ($sites as $site) { ?>
							<option value="<?php echo $site['buildingsiteID']; ?>"> <?php echo $site['sitename']; ?>
							</option>
							<?php } ?>

						</select>

						<button type="submit">Done</button>
					</form>
					<!-- <a
						href="datawrites/deleteDocument.php?documentID=<?php echo $doc['documentID']?>"><button>Delete</button></a> -->
					<br>
					<br>

				</div>

				<?php 	
				$count++;
				//echo $count;
			} ?>











				<h1>new current documents</h1>

				<?php foreach($sites as $site) {
			$docs = docsBySite($site['buildingsiteID']);
			if(count($docs) > 0) {?>
				<table class="table">
					<thead class="thead-light">
						<tr>
							<th scope="col"><?php echo $site['sitename'];?></th>
							<th scope="col"></th>
							<th scope="col"></th>
							<th scope="col">Delete</th>
							<th scope="col">Edit site</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($docs as $doc) {?>
						<tr>
							<th scope="row"><a href="pdf/<?php echo $doc['name'];?>"
									target="_blank"><?php echo $doc['title'];?></a></th>
							<th></th>
							<th></th>
							<th><a href="datawrites/deleteDocument.php?documentID=<?php echo $doc['documentID']?>"><span
										class="material-icons">delete</a></span></th>
							<!-- <th><span class="material-icons">create</span></th> -->
							<!-- <th><button onclick="myFunction(<?php echo $doc['documentID']; ?>)">Edit Sites</button> -->
							<th><a onclick="myFunction(<?php echo $doc['documentID']; ?>)"><span class="material-icons">create</span></a>





							<div style="display:none" id="sitediv<?php echo $doc['documentID']; ?>">

								<form method="post" action="datawrites/updatedocsite.php">
									<input type="hidden" id="docId" name="docid" value="<?php echo $doc['documentID']; ?>">
									<select class="custom-select" name="site">
										<option value="<?php echo $doc['buildingsites_buildingsiteID']; ?>" selected><?php echo $doc['sitename']; ?></option>
										<!-- <option value="">asd</option> -->
										<?php 
										foreach ($sites as $site) { ?>
										<option value="<?php echo $site['buildingsiteID']; ?>">
											<?php echo $site['sitename']; ?>
										</option>
										<?php } ?>

									</select>

									<button type="submit">Done</button>
								</form>

							</div>




							</th>
						</tr>




						





						<?php } ?>
					</tbody>
				</table>
				<?php } } ?>



				<script>
					function myFunction(valIn) {
						var x = document.getElementById("sitediv" + valIn);
						if (x.style.display === "none") {
							x.style.display = "block";
						} else {
							x.style.display = "none";
						}
					}
				</script>




			</div>



		</div>
		<!-- /#page-content-wrapper -->

	</div>
	<!-- /#wrapper -->

	<?php include 'includes/footer.php'; ?>


</body>

</html>