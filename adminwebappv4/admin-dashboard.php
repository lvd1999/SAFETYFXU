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

<?php include 'includes/head.php';  echo'<style>.adminsidebar h4{  background-color: #FFE400;
  color: #282828 !important;}</style>' ?>

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
          <div class="col-md-4">
            <div class="card card-user">
              <h3 class="stripe-1">Company Information</h3>
              <div class="card-body">
                <div class="author">
                  <a href="#">
                    <img class="avatar border-gray" src="./images/logo2.png" alt="...">
                  </a>
                  <h2 class="title">Company name: <?php echo $_SESSION['admin']['companyName']; ?></h2>
                  <h2 class="description">
                    Admin Name: <?php echo $username; ?>
                  </h2>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card card-user">
            <h3 class="stripe-1">Company Information</h3>
              <div class="card-header">
                <div class="row">
                  <div class="col-md-6"> 
                    <h3 class="card-title">Profile</h3>
                  </div>
                 <div class="col-md-6" style="text-align: right;">
                 <!-- Button trigger modal -->
                  <button type="button" class="btn btn-secondary btn-round" data-toggle="modal" data-target="#exampleModalScrollable" style="font-size:22px;">
                    Edit Profile
                  </button>
                </div>

                  <!-- Modal -->
                  <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Profile</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
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
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Company Name</label>
                        <input style="font-size:22px;"name="companyName"  type="text" class="form-control" placeholder="Company Name" value="<?php echo $_SESSION['admin']['companyName'];?>">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;" for="exampleInputEmail1">Email address</label>
                        <input style="font-size:22px;" name="email" type="email" class="form-control" placeholder="Email" value="<?php echo $_SESSION['admin']['email'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;">First Name</label>
                        <input style="font-size:22px;" name="firstname" type="text" class="form-control" placeholder="Firstname" value="<?php echo $_SESSION['admin']['firstname'];?>">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Surname</label>
                        <input style="font-size:22px;" type="text" class="form-control" placeholder="Surname" name="lastname" value="<?php echo $_SESSION['admin']['surname'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Address</label>
                        <input style="font-size:22px;" name="address" type="text" class="form-control" placeholder="Company Address" value="<?php echo $_SESSION['admin']['address']; ?>">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;">City</label>
                        <input style="font-size:22px;"  name="city" type="text" class="form-control" placeholder="City" value="<?php echo $_SESSION['admin']['city'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Country</label>
                        <input style="font-size:22px;" name="country" type="text" class="form-control" placeholder="Country" value="<?php echo $_SESSION['admin']['country'];?>">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Eircode</label>
                        <input style="font-size:22px;" name="eircode" type="text" class="form-control" placeholder="Eircode" value="<?php echo $_SESSION['admin']['eircode'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Mobile Phone</label>
                        <input style="font-size:22px;" name="mobile" type="text" class="form-control" placeholder="Mobile Phone" value="<?php echo $_SESSION['admin']['mobileNumber']; ?>">
                      </div>
                    </div>
                  
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Landline Number</label>
                        <input style="font-size:22px;" name="landline" type="text" class="form-control" placeholder="Landline Number" value="<?php echo $_SESSION['admin']['landlineNumber']; ?>">
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-secondary" type="submit">submit</button>
                </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
               
                </div>
               
              </div>
              <div class="card-body">
              <form method="post">
                  <div style="text-align:center;">
                    <div class="card-avatar">
                      <div class="profiledisplay">
                        <img src="<?php echo "profileImages/" . $_SESSION['admin']['image']; ?> " onClick='triggerClick()' id='profileDisplay'>
                      </div>
                    </div>
                  </div>
                 <br>
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Company Name</label>
                        <input style="font-size:22px;" type="text" class="form-control" disabled="" placeholder="Company Name" value="<?php echo $_SESSION['admin']['companyName'];?>">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;" for="exampleInputEmail1">Email address</label>
                        <input style="font-size:22px;" type="email" class="form-control" disabled="" placeholder="Email" value="<?php echo $_SESSION['admin']['email'];?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-5 pr-1">
                      <div class="form-group">
                        <label style="font-size:22px;">First Name</label>
                        <input style="font-size:22px;" type="text" class="form-control" disabled="" placeholder="Firstname" value="<?php echo $_SESSION['admin']['firstname'];?>">
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Surname</label>
                        <input style="font-size:22px;" type="text" class="form-control" disabled="" placeholder="Surname" value="<?php echo $_SESSION['admin']['surname'];?>">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Mobile Phone</label>
                        <input style="font-size:22px;" type="text" class="form-control" disabled="" placeholder="Mobile Phone" value="<?php echo $_SESSION['admin']['mobileNumber']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Address</label>
                        <input style="font-size:22px;" type="text" class="form-control" disabled="" placeholder="Company Address" value="<?php echo $_SESSION['admin']['address']; ?>">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Landline Number</label>
                        <input style="font-size:22px;" type="text" class="form-control" disabled="" placeholder="Landline Number" value="<?php echo $_SESSION['admin']['landlineNumber']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label style="font-size:22px;">City</label>
                        <input style="font-size:22px;" type="text" class="form-control" disabled="" placeholder="City" value="<?php echo $_SESSION['admin']['city'];?>">
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Country</label>
                        <input style="font-size:22px;" type="text" class="form-control" disabled="" placeholder="Country" value="<?php echo $_SESSION['admin']['country'];?>">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label style="font-size:22px;">Eircode</label>
                        <input style="font-size:22px;" type="text" class="form-control" disabled="" placeholder="Eircode" value="<?php echo $_SESSION['admin']['eircode'];?>">
                      </div>
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


</body>

</html>
