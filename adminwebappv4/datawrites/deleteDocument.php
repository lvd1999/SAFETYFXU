<?php
session_start();
require_once '../includes/functions.php';
require_once '../includes/config.php';

//delete document, return to documents.php
$documentID = $_GET['documentID'];

deleteDocument($documentID);
header('location: ../documents.php');
?>