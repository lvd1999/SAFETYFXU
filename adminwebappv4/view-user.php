<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';

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

  <div class="d-flex" id="wrapper">

	<?php include 'includes/sidebar.php'; ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

		<?php include 'includes/menubar.php'; ?>

		
		
      <div class="container-fluid">
      <a href="<?php echo $_SERVER['HTTP_REFERER'];?>">Back</a> <br>
      <img src="../GOwebapp/profileImages/<?php echo $user['profileImage'];?>"> <br>
      <!-- <?php echo $user['profileImage']; ?> <br> -->
        First Name: <?php echo $user['firstname'];?> <br>
        Surname: <?php echo $user['surname'];?> <br>
        Email: <?php echo $user['email'];?> <br>
        Date of Birth: <?php echo $user['dob'];?> <br>
        Sex: <?php echo $user['sex'];?> <br>
        Occupation: <?php echo $user['occupation'];?> <br>
        Position: <?php echo $user['position'];?> <br>
        Nationality: <?php echo $user['nationality'];?> <br>
        English: <?php echo $user['english'];?> <br>
        Phone: <?php echo $user['phone'];?> <br>

        Certificates: <br>
        <?php 
        foreach($certs as $cert) { echo $cert['type'] . '<br>'; ?>
          <img src="../GOwebapp/certificates/<?php echo $cert['certImageFront'];?>"> <br>
          <?php }  ?>

      </div>
    
	
	
	</div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <?php include 'includes/footer.php'; ?>


</body>

</html>
