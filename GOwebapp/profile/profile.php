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
    <?php echo $userDetail['firstname'];?>
</body>

</html>

