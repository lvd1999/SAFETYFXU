<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';
//variables
$_SESSION['admin'] = adminDetails($_SESSION['adminid']);
$company_name = $_SESSION['admin']['companyName'];
$username = $_SESSION['username'];

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] !== true) {
    header("location: login.php");
    exit;
}

$user = userDetails($_GET['userid']);
$certs = get_certs($_GET['userid']); 
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <?php $page='personnel';
   include 'includes/head.php'; ?>

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
      <button class="btn btn-secondary"><a style="color:white; font-size:22px;" href="<?php echo $_SERVER['HTTP_REFERER'];?>">Back</a> </button><br>
      <br>
      <div class="col-lg-12">
      <div class="card card-user">
        <h3 class="stripe-1">Company Info</h3>
        <div class="card-body">
        <form action="" style="width: 100%; text-align:left; color: black;">
          <div class="profileDisplay" style="text-align:center;">
            <img src="../GOwebapp/profileImages/<?php echo $user['profileImage'];?>" alt="Avatar" style="width:15%;">
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-size:24px; color: black;"><strong>Firstname: </strong></label>
                  <input style="font-size:24px;"name="firstname"  type="text" class="form-control" readonly value="<?php echo $user['firstname'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-size:24px; color: black;"><strong>Surname: </strong></label>
                <input style="font-size:24px;"name="surname"  type="text" class="form-control" readonly value="<?php echo $user['surname'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-size:24px; color: black;"><strong>Email: </strong></label>
                <input style="font-size:24px;"name="email"  type="email" class="form-control" readonly value="<?php echo $user['email'];?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-size:24px; color: black;"><strong>Date Of Birth: </strong></label>
                  <input style="font-size:24px;"name="dob"  type="text" class="form-control" readonly value="<?php echo $user['dob'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-size:24px; color: black;"><strong>Gender: </strong></label>
                <input style="font-size:24px;"name="sex"  type="text" class="form-control" readonly value="<?php echo $user['sex'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-size:24px; color: black;"><strong>Occupation: </strong> </label>
                <input style="font-size:24px;"name="occupation"  type="text" class="form-control" readonly value="<?php echo $user['occupation'];?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-size:24px; color: black;"><strong>Position: </strong></label>
                  <input style="font-size:24px;"name="position"  type="text" class="form-control" readonly value="<?php echo $user['position'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-size:24px; color: black;"><strong>Nationality: </strong></label>
                <input style="font-size:24px;"name="nationality"  type="text" class="form-control" readonly value="<?php echo $user['nationality'];?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-size:24px; color: black;"><strong>English: </strong> </label>
                <input style="font-size:24px;"name="english"  type="text" class="form-control" readonly value="<?php echo $user['english'];?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label style="font-size:24px; color: black;"><strong>Phone: </strong></label>
                  <input style="font-size:24px;"name="phone"  type="text" class="form-control" readonly value="<?php echo $user['phone'];?>">
              </div>
            </div>
          </div>

       <h3><strong> Certificates:</strong></h3>
        <div>
        <?php 
          foreach($certs as $cert) { echo '<h4 style="font-size: 24px;"><strong>' .$cert['type'] . '</strong></h4>'; ?>
          <img src="../GOwebapp/certificates/<?php echo $cert['certImageFront'];?>" style="width: 400px;"> <br><br>
          <?php }  ?>
        </div>
       
        </form>
        </div>
        </div>
        </div>
      </div>
    
	
	</div>
	</div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <?php include 'includes/footer.php'; ?>


</body>

</html>
