<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';
//variables

?>


<!DOCTYPE html>
<html lang="en">

<head>

  <?php $page='dashboard'; include 'includes/head.php'; ?>
  
  
</head>

<body>

  <div class="d-flex" id="wrapper">

    <?php include 'includes/sidebar.php'; ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <?php include 'includes/menubar.php'; ?>



      <div class="container-fluid">
        <h1>Edit profile</h1>
        <form action="datawrites/updateprofile.php" method="post" enctype="multipart/form-data">

        <!-- for update image -->
        <img src="<?php echo "profileImages/" . $_SESSION['admin']['image']; ?> " onClick='triggerClick()' id='profileDisplay'>
        <button type="button" class="btn btn-primary" style="margin-top:1%;"> <a class="info" onClick="triggerClick()">Change Avatar</a></button>
        <input type="file" name="profileImage" onChange="displayImage(this)"
                        id="profileImage" class="form-control" style="display: none">
        <span></span>
            <br>

            Company Name: <input type="text" name="companyName" value="<?php echo $_SESSION['admin']['companyName'];?>"> <br>
            Email: <input type="text" name="email" value="<?php echo $_SESSION['admin']['email'];?>"> <br>
            First Name: <input type="text" name="firstname" value="<?php echo $_SESSION['admin']['firstname'];?>"> <br>
            Last Name: <input type="text" name="lastname" value="<?php echo $_SESSION['admin']['lastname'];?>"> <br>
            Address: <input type="text" name="address" value="<?php echo $_SESSION['admin']['address'];?>"> <br>
            City: <input type="text" name="city" value="<?php echo $_SESSION['admin']['city'];?>"> <br>
            Country: <input type="text" name="country" value="<?php echo $_SESSION['admin']['country'];?>"> <br>
            Eircode: <input type="text" name="eircode" value="<?php echo $_SESSION['admin']['eircode'];?>"> <br>
            Landline Number: <input type="text" name="landline" value="<?php echo $_SESSION['admin']['landlineNumber'];?>"> <br>
            Mobile Number: <input type="text" name="mobile" value="<?php echo $_SESSION['admin']['mobileNumber'];?>"> <br>
            
            <input type="submit">
        </form>
      </div>

     

    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <?php include 'includes/footer.php'; ?>


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