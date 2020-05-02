<?php

echo $_POST['docid'];
echo $_POST['site'];

session_start();
require_once '../includes/functions.php';
require_once '../includes/config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$docid = $_POST['docid'];
	$siteid = $_POST['site'];

	// Prepare an insert statement
	$sql = "UPDATE documentsites set buildingsites_buildingsiteID = :siteid where documents_documentID = :docid";


	if ($stmt = $pdo->prepare($sql)) {
		// Bind variables to the prepared statement as parameters
		$stmt->bindParam(":docid", $docid, PDO::PARAM_STR);
		$stmt->bindParam(":siteid", $siteid, PDO::PARAM_STR);

		// Attempt to execute the prepared statement
		if ($stmt->execute()) {
			// Redirect to screen 3
			header("location: ../documents.php");
		} else {
			echo "Something went wrong. Please try again later.";
		}	

		// Close statement
		unset($stmt);	
	}
}

?>