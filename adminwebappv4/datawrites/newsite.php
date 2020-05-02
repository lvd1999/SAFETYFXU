<?php

echo 'here';

session_start();
require_once '../includes/functions.php';
require_once '../includes/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$code = $_POST['code'];
	$address = $_POST['address'];
	$sitename = $_POST['sitename'];

	// Prepare an insert statement
	$sql = "INSERT INTO buildingsites (sitename, code, address, admins_adminID) VALUES (:sitename, :code, :address, :adminid)";


	if ($stmt = $pdo->prepare($sql)) {
		// Bind variables to the prepared statement as parameters
		$stmt->bindParam(":code", $code, PDO::PARAM_STR);
		$stmt->bindParam(":address", $address, PDO::PARAM_STR);
		$stmt->bindParam(":sitename", $sitename, PDO::PARAM_STR);
		$stmt->bindParam(":adminid", $_SESSION['adminid'], PDO::PARAM_STR);



		// Attempt to execute the prepared statement
		if ($stmt->execute()) {
			// Redirect to screen 3
			header("location: ../sites.php");
		} else {
			echo "Something went wrong. Please try again later.";
		}	

		// Close statement
		unset($stmt);	
	}
}

?>