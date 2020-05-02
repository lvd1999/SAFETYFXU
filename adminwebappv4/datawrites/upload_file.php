<?php

 /*
if(move_uploaded_file($_FILES['file']['tmp_name'], $targetfolder))

 {
	echo "The file ". basename( $_FILES['file']['name']). " is uploaded";
	// Write to database.
 }

 else {

 echo "Problem uploading file";

 }
	header("location: documents.php");
*/

session_start();
require_once "../includes/config.php";
require_once '../includes/functions.php';


//$company_name = $_SESSION['admin']['company_name'];
$adminid = $_SESSION['adminid'];
$docname = $_POST['docname'];

$reg_err = '';
$cert = $reg_num = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	//echo 'test';
	
    //for image
    $pdfName = time() . '-' . $_FILES['file']['name'];
    $target_dir = "../pdf/";
    $target_file = $target_dir . basename($pdfName);

    // validate image size. Size is calculated in Bytes
    /*
	if ($_FILES['pdf']['size'] > 200000) {
        $msg = "Image size should not be greated than 200Kb";
        $msg_class = "alert-danger";
    }
	*/
	
    // check if file exists
    if (file_exists($target_file)) {
        $msg = "File already exists";
        $msg_class = "alert-danger";
    }
    // Upload image only if no errors
    if (empty($error)) {
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
    }

	/*
    //validate user input pdf title
    if (empty($_POST['title'])) {
        $title_err = "Please insert title.";
    } else {
        $title = $_POST['title'];
    }
	*/
	
	
    
	$sql = "INSERT INTO documents (name, title, admins_adminID) VALUES ('$pdfName', '$docname', $adminid)";

	
    if ($stmt = $pdo->prepare($sql)) {
        //$stmt->bindParam(":pdf", $param_pdf, PDO::PARAM_STR);

        //set parameters
        //$param_pdf = $pdfName;

        if (empty($reg_err)) {
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to profile page
                header("location: ../documents.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        unset($stmt);
    }
	
	
}
	
 ?>