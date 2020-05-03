<?php

session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$_SESSION['user'] = userDetails($_SESSION['email']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Homepage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style type="text/css">
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="page-header">
        <h1>Home</h1>
    </div>
    <p>
        <a href="profile/profile.php" class="btn btn-success">Profile</a>
        <a href="request.php" class="btn btn-info">Enter site code</a>
        <a href="pdf-history.php" class="btn btn-warning">PDF History</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>

    

</body>




</html>