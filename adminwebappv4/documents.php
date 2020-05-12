<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';
//variables
$_SESSION['admin'] = adminDetails($_SESSION['admin']['adminID']);
$company_name = $_SESSION['admin']['companyName'];
$username = $_SESSION['username'];

$docs = docsByAdmin($_SESSION['admin']['adminID']);
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

	<?php $page='documents'; include 'includes/head.php'; echo'<style>.doc h4{  background-color: #FFE400;
  color: #282828 !important;}</style>' ?>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>

<?php $page='dashboard'; include 'includes/sidebar.php'; ?>
 <div id="right-panel" class="right-panel">
   <div class="wrapper" id="wrapper">
      <!-- Page Content -->
        <?php include 'includes/menubar.php'; ?>
     <div class="main-panel">  
      <!-- /#page-content-wrapper -->
      <div class="content">
	 	 <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: -2%">
			<h3>Documents</h3>
			<button type="button" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-warning d-none d-sm-inline-block btn btn-danger shadow-sm" style="font-size:24px;"><i class="fas fa-plus fa-sm text-white-100"></i> 
				Add new Document
			</button>
		</div>

		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalCenterTitle">Add new Document</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					<form action="datawrites/upload_file.php" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label>FileName: </label>
						<input type="text" class="form-control" name="docname" size="50" />
					</div>
					<label>Upload File</label>
					<div class="custom-file mb-3">
						<input type="file" class="custom-file-input" id="customFile" name="file" size="50" required>
						<label class="custom-file-label" for="customFile">Choose file</label>
					</div>
					
					<input type="submit" value="Upload" />
					<!-- <button class="btn btn-secondary" type="submit">upload</button> -->
					</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
					</div>
				</div>
				</div>

				<div class="row">
					<div class="col-md-5 col-lg-12">
						<div class="card card-user">
							<h3 class="stripe-1">Company Information</h3>
							<div class="card-header">
								<h3 class="card-title">New Current Document</h3>
							</div>
							<div class="card-body">
								<div class="row">
								<table class="table table-striped" style="font-size:25px;">
								<?php foreach($sites as $site) {
			$docs = docsBySite($site['buildingsiteID']);
			if(count($docs) > 0) {?>
				
					<thead class="tr">
						<tr>
							<th scope="col" class="tr"  style="color:black; font-size:24px;"><?php echo $site['sitename'];?></th>
							<th class="tr"></th>
							<th class="tr"></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($docs as $doc) {?>
						<tr>
							<th scope="row" class="re" style="color:black; font-size:25px;"><a  style="color:black; font-size:25px;" href="pdf/<?php echo $doc['name'];?>"
									target="_blank"><?php echo $doc['title'];?></a></th>
							<th class="re"><a  style="color:red; font-size:25px;" href="datawrites/deleteDocument.php?documentID=<?php echo $doc['documentID']?>"><span
										class="material-icons">delete</a></span></th>
							<!-- <th><span class="material-icons">create</span></th> -->
							<!-- <th><button onclick="myFunction(<?php echo $doc['documentID']; ?>)">Edit Sites</button> -->
							<th class="re"><a  style="color:blue; font-size:25px;" onclick="myFunction(<?php echo $doc['documentID']; ?>)"><span class="material-icons">create</span></a>



							<div style="display:none" id="sitediv<?php echo $doc['documentID']; ?>">

								<form method="post" action="datawrites/updatedocsite.php">
									<input type="hidden" id="docId" name="docid" value="<?php echo $doc['documentID']; ?>">
									<div class="row">
										<div class="col-md-8">
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
										</div>
										<div class="col-md-4">
											<button class="btn btn-success" type="submit">Done</button>
										</div>
									</div>
									

									
								</form>

							</div>




							</th>
						</tr>

						<?php } ?>
					</tbody>
				
				<?php } } ?>
		</table>
							</div>
						</div>
					</div>
		
		<!-- End File Upload-->
			</div>
			</div>
				</div>
					</div>
				<div class="col-md-5 col-lg-12 col-xl-12">
						<div class="card card-user">
							<h3 class="stripe-1">Company Information</h3>
							<div class="card-header">
								<h3 class="card-title">New Documents</h3>
							</div>
							<div class="card-body">
				<table class="table">
							<?php
		
			//echo var_dump($newdocs);
		
			$count = 1;
			foreach($newdocs as $doc) { ?>
			
				<tbody>
					<tr><th><a style="color:black; font-size:23px;" href="pdf/<?php echo $doc['name']; ?>" target="_blank" />
					<!--?php echo var_dump($doc); ?-->
					<?php echo "No site: ". $doc['title']; ?> </a></th>
					<th><a  style="color:red; font-size:25px;" href="datawrites/deleteDocument.php?documentID=<?php echo $doc['documentID']?>"><span
										class="material-icons">delete</a></span></th>
					<th><a  style="color:blue; font-size:25px;" onclick="myFunction(<?php echo $doc['documentID']; ?>)"><span class="material-icons">create</span>
					
					<div style="display:none" id="sitediv<?php echo $doc['documentID']; ?>">
				
				<form method="post" action="datawrites/updatenewdocsite.php" >
					<input type="hidden" id="docId" name="docid" value="<?php echo $doc['documentID']; ?>">
					<div class="row">
						<div class="col-md-8">
							<select class="custom-select" name="site">
								<option value="0"> "None" </option>
								<?php 
								foreach ($sites as $site) { ?>
									<option value="<?php echo $site['buildingsiteID']; ?>"> <?php echo $site['sitename']; ?></option>
								<?php } ?>
							
							</select>
						</div>
					<div class="col-md-4">
						<button type="submit" class="btn btn-success" style="font-size:22px;">Done</button>
					</div>
					</div>
				</form>
				</div>
				</th>
				</tr>
				</tbody>
				
				
			
				
				<?php 	
				$count++;
				//echo $count;
			} ?>

</table>


		
	
		<script>
		function myFunction(valIn) {
		  var x = document.getElementById("sitediv"+valIn);
		  if (x.style.display === "none") {
			x.style.display = "block";
		  } else {
			x.style.display = "none";
		  }
		}
		</script>
		<script>
			// Add the following code if you want the name of the file appear on select
			$(".custom-file-input").on("change", function() {
			var fileName = $(this).val().split("\\").pop();
			$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
			});
		</script>
		
		
		

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
