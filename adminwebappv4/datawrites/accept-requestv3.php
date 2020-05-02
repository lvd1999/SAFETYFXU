<?php
// Initialize the session
session_start();
require_once '../includes/functions.php';
require_once '../includes/config.php';

$siteregistrationid = $_GET['siteregistrationid'];
acceptRequest($siteregistrationid);


header('location: ../sites.php');
?>
