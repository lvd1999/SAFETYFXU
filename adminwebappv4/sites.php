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

	<?php $page='sites'; include 'includes/head.php'; ?>

</head>

<body>
<?php include 'includes/sidebar.php'; ?>
<div id="right-panel" class="right-panel">
	<div class="wrapper" id="wrapper">
			<?php include 'includes/menubar.php'; ?>
		<div class="main-panel">
			<!-- Page Content -->
			<div class="content">
				<!-- Button trigger modal -->
				<div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: -2%">
					<h3>Sites</h3>
					<button type="button" data-toggle="modal" data-target="#exampleModalCenter" class="btn d-none d-sm-inline-block btn-danger shadow-sm" style="font-size:24px;"><i class="fas fa-plus fa-lg text-white-100"></i> 
						Add new Site
					</button>
				</div>
				
				<!-- Modal -->
				<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalCenterTitle">Add new Site</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="datawrites/newsite.php" method="post">
							<div class="form-group">
								<label>Name: </label>
								<input type='text' class="form-control" placeholder="Site name" name='sitename'>
							</div>
					
							<div class="form-group">
								<label>Addrss: </label>
								<input type='text' class="form-control" placeholder="Address" name='address'>
							</div>
				
							<div class="form-group">
								<label>Code: </label>
								<input type='text' class='form-control'  placeholder='Address' name='code' oninput="let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);">
							</div>
							<button class="btn btn-secondary" type="submit">submit</button>
						<!-- <input type="submit" value="submit"> -->
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
					</div>
				</div>
				</div>

				<div class="row">
					<div class="col-md-5 col-lg-12 col-xl-12">
						<div class="card card-user">
							<h3 class="stripe-1">Company Information</h3>
							<div class="card-header">
								<h3 class="card-title">Current Site</h3>
							</div>
							<div class="card-body">
								<table class="table table-striped">
								<tbody>
									<?php	
										foreach ($sites as $site) { ?>
										<tr>
											<th style="font-size:24px;" class="tr"><a data-toggle="collapse" aria-expanded="false" data-target="#site<?php echo $site['buildingsiteID'];?>" aria-controls="collapseExample" style="color:black; font-size:24px;"><?php echo $site['sitename']; ?></a></th>
											<th style="font-size:24px;" class="tr"><a data-toggle="collapse" aria-expanded="false" data-target="#site<?php echo $site['buildingsiteID'];?>" aria-controls="collapseExample" style="color:black;"><?php echo $site['address']; ?></th>
											<th style="font-size:24px;" class="tr"><a data-toggle="collapse" aria-expanded="false" data-target="#site<?php echo $site['buildingsiteID'];?>" aria-controls="collapseExample" style="color:black;"><?php echo $site['code']; ?></th>
										</tr>
											
										<?php $members = membersBySite($site['buildingsiteID']); ?>
											<div class="collapse" id="site<?php echo $site['buildingsiteID'];?>">
												<tr><th style="font-size:24px;">Operatives: </th><th></th><th></th></tr>
												
											<?php 
											if(count($members) > 0) { ?>
											<tr>
											<?php
											foreach($members as $member){ ?>
												
												<tr><th style="font-size:24px;" class="re"><a style="color:black; font-size:24px;" href="view-user.php?userid=<?php echo $member['userID'];?>"><?php echo $member['userID'] . ': ' .$member['firstname'] . ' ' . $member['surname'];?> (<?php echo $member['status'];?>)</a></th><th class="re"></th><th class="re"></th></tr>
												
											<?php } ?>
											<?php } else { ?> <th class="re" style="font-size:24px;">No members in this site.</th> <?php } ?>
												</tr>
											</div>
											
										<?php } ?>
									
									</tbody>
								</table>
							</div>
						</div> 
					</div>
				</div>
			
				<div class="row">
					<div class="col-md-5 col-lg-12 col-xl-12">
						<div class="card card-user">
							<h3 class="stripe-1">Company Information</h3>
							<div class="card-header">
								<h3 class="card-title">Pending Requests<span class="badge badge-danger"></span></h3>
							</div>
							<div class="card-body">
								<table class="comic">
									<tbody>
									<?php
									if (count($requests) > 0) {
										foreach ($requests as $request) {?>
											<tr>
												<th style="font-size:24px;">
  													<?php echo $request['firstname'] . "\t" . $request['surname'] ?>
												</th>
												<th style="font-size:24px;"><?php echo $request['sitename'] ?></th>
												<th style="font-size:24px;"><?php echo $request['requestMessage'] ?></th>
												<th class="alertnumber" ><?php echo '<a href="datawrites/accept-request.php?siteregistrationid=' .$request['siteregistrationID'] .'"><button class="btn btn-secondary" style="font-size:24px;">Allow</button>' . "</a>" ?></th>
											</tr>
											<!-- //var_dump($request);
										echo $request['firstname'] . "\t\t" . $request['surname'] . "\t" . $request['sitename'] . "\t\t" . $request['requestMessage']. "\t\t" .
													'<a href="datawrites/accept-request.php?siteregistrationid=' .$request['siteregistrationID'] .'"><button>Allow</button>' . "</a>" . "<br>";
										}
										
										//echo 'datawrites/accept-request.php?siteregistrationid=' .$request['siteregistrationID']; -->
									<?php }  ?>
									<?php }?>

									
									</tbody>
								</table>
								
							</div>
						</div>
					</div>
				</div>	
								
							
				<div class="row">
					
					<div class="col">
						<div class="card card-user">
							<h3 class="stripe-1">Company Information</h3>
							<div class="card-header">
								<h3 class="card-title">New Site</h3>
							</div>
							<div class="card-body">
							<table class="comic">
								<tbody>
									
									<?php		
									foreach ($newsites as $site) { ?>
									<tr>
										<td style="font-size:24px;"><?php echo $site['sitename']?></td>
										<td style="font-size:24px;"><?php echo $site['address']?></td>
										<td style="font-size:24px;"><?php echo $site['code']?></td>
									</tr>
								<?php } ?>	

								</tbody>
							</table>
								
						</div>
					</div>
						
					</div>
				</div>
			
				<!-- <h1> Pending Requests: </h1>
				    <?php
					
						
						if (count($requests) > 0) {
							foreach ($requests as $request) {
								//var_dump($request);
							echo $request['firstname'] . "\t\t" . $request['surname'] . "\t" . $request['sitename'] . "\t\t" . $request['requestMessage']. "\t\t" .
										'<a href="datawrites/accept-request.php?siteregistrationid=' .$request['siteregistrationID'] .'"><button>Allow</button>' . "</a>" . "<br>";
							}
							
							//echo 'datawrites/accept-request.php?siteregistrationid=' .$request['siteregistrationID'];
						} else {
							echo "No pending request at the moment.";
						}
						
					?> -->
				
				
				<!-- <br>
				<br>
				<h1> Current Sites: </h1>

				<div class="panel-group" id="accordion">
					<?php			
						if (count($sitesInfo) > 0) {
							$count=1;
							foreach ($sitesInfo as $site) { ?>
								
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $count; ?>"><?php echo $site->sitename." - ".$site->address." - ".$site->code; ?> </a>
										</h4>
									</div>
									<div id="collapse<?php echo $count; ?>" class="panel-collapse collapse in">
										
										<h5> Operatives: </h5>
										<?php
										foreach ($site->gos as $go){
											echo '<h4> '.$go.'</h4>';
										}
										?>
									</div>
								</div> 
								<br>
								<?php
								$count=$count+1;
							}
						} ?>
						
					
				

					
				</div>
					
				
				<h1> New Sites: </h1>
				
				<div class="panel-group" id="accordion">
					<?php		
						foreach ($newsites as $site) { ?>
						<h4> <?php echo $site['sitename']." - ".$site['address']." - ".$site['code']; ?></h4>
					<?php } ?>	
				

				<div class="panel-group" id="accordion">
				<?php			
						if (count($sitesInfo) > 0) {
							$count=1;
							foreach ($sitesInfo as $site) { ?>
								
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $count; ?>"><?php echo $site->sitename." - ".$site->address." - ".$site->code; ?> </a>
										</h4>
									</div>
									<div id="collapse<?php echo $count; ?>" class="panel-collapse collapse in">
										
										<h5> Operatives: </h5>
										<?php
										foreach ($site->gos as $go){
											echo '<h4> '.$go.'</h4>';
										}
										?>
									</div>
								</div> 
								<br>
								<?php
								$count=$count+1;
							}
						}
						?>
						
					
				

					
				</div> -->
				</div>
						
			</div>
			
		</div>
		
	</div>
									
</div>
								
	
	
  <?php include 'includes/footer.php'; ?>
  <script src="./js/demo.js"></script>
  <script>
	  
	$(".badge").text($(".alertnumber").length);
	if ($(".alertnumber").length == 0) {
	$(".badge").text("No Request");
	}
	  
	 
  </script>

</body>

</html>
