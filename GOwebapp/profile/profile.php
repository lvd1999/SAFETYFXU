<?php
session_start();
require_once '../includes/functions.php';
require_once '../includes/config.php';

//get details
$userDetail = userDetails($_SESSION['user']['userID']);
$safepass = get_safepass($_SESSION['user']['userID']);
$certs = get_cert($_SESSION['user']['userID']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico" />

</head>

<body>
    <h1>Profile</h1>
    <img src="../profileImages/<?php echo $userDetail['profileImage'];?>"> <br>
    First Name: <?php echo $userDetail['firstname'];?> <br>
    surname: <?php echo $userDetail['surname'];?><br>
    email: <?php echo $userDetail['email'];?><br>
    dob: <?php echo $userDetail['dob'];?><br>
    sex: <?php echo $userDetail['sex'];?><br>
    occupation: <?php echo $userDetail['occupation'];?><br>
    position: <?php echo $userDetail['position'];?><br>
    nationality: <?php echo $userDetail['nationality'];?><br>
    english: <?php echo $userDetail['english'];?><br>
    phone: <?php echo $userDetail['phone'];?><br>

    <h3>Safepass</h3>
    <?php if($safepass == true) { ?>
        <img src="../certificates/<?php echo $safepass['certImageFront'];?>">
    <?php } else {?>
        No Safepass
    <?php } ?>

    <h3>Other certificates</h3>
    <?php if(count($certs) > 0) { foreach($certs as $cert) { ?>
        <img src="../certificates/<?php echo $cert['certImageFront'];?>" width="300" height="300">
    <?php } } else { ?>
        No other certificates.
    <?php } ?>
</body>

</html>

