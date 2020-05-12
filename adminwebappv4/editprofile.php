<?php
// Initialize the session
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
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <?php $page='dashboard'; include 'includes/head.php'; ?>
  
  
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
        <div class="row">
          <div class="col-md-8">
            <div class="card card-user">
            <h3 class="stripe-1">Company Information</h3>
              <div class="card-header">
                <div class="col-md-6">
                    <h3 class="card-title">Edit Profile</h3>
                </div>
                <div class="col-md-6" style="text-align: right;">
                    <button class="btn btn-secondary btn-round"><a href="/admin-dashboard.php" style="color:white; font-size: 20px;">Back</a></button>
                </div>
              </div>
              <div class="card-body">
                <form action="datawrites/updateprofile.php" method="post" enctype="multipart/form-data">
                  <div style="text-align:center;">
                    <div class="card-avatar">
                      <div class="profiledisplay">
                        <img src="<?php echo "profileImages/" . $_SESSION['admin']['image']; ?> " onClick='triggerClick()' id='profileDisplay'>
                      </div>
                    </div>
                    <button type="button" class="btn btn-primary" style="margin-top:1%; font-size:22px;"> <a class="info" onClick="triggerClick()">Change Avatar</a></button>
                      <input type="file" name="profileImage" onChange="displayImage(this)"
                        id="profileImage" class="form-control" style="display: none">
                  </div>
                 <br>
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" class="form-control" placeholder="Company Name" value="<?php echo $_SESSION['admin']['companyName'];?>">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" placeholder="Email" value="<?php echo $_SESSION['admin']['email'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-5 pr-1">
                      <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" placeholder="Firstname" value="<?php echo $_SESSION['admin']['firstname'];?>">
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>Surname</label>
                        <input type="text" class="form-control" placeholder="Surname" value="<?php echo $_SESSION['admin']['lastname'];?>">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Mobile Phone</label>
                        <input type="text" class="form-control" placeholder="Mobile Phone" value="<?php echo $_SESSION['admin']['mobileNumber']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" placeholder="Company Address" value="<?php echo $_SESSION['admin']['address']; ?>">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label>Landline Number</label>
                        <input type="text" class="form-control" placeholder="Landline Number" value="<?php echo $_SESSION['admin']['landlineNumber']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" placeholder="City" value="<?php echo $_SESSION['admin']['city'];?>">
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" placeholder="Country" value="<?php echo $_SESSION['admin']['country'];?>">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Eircode</label>
                        <input type="text" class="form-control" placeholder="Eircode" value="<?php echo $_SESSION['admin']['eircode'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                        <input type="submit" value="Done">
                   </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
    <!-- /#wrapper -->

    <?php include 'includes/footer.php'; ?>

</div>
<script src="./js/demo.js"></script>


</body>

</html>

<script>
function triggerClick(e) {
  document.querySelector('#profileImage').click();
}
function displayImage(e) {
  if (e.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      document
        .querySelector('#profileDisplay')
        .setAttribute('src', e.target.result);
    };
    reader.readAsDataURL(e.files[0]);
  }
}
</script>