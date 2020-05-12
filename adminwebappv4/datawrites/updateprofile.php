<?php
session_start();
require_once '../includes/config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // for image validation
    if (!isset($_FILES['profileImage']) || $_FILES['profileImage']['error'] == UPLOAD_ERR_NO_FILE) {        //if no image changes, update with same photo
        $profileImageName = $_SESSION['admin']['image'];
    } else {
//for image upload
        $profileImageName = time() . '-' . $_FILES['profileImage']['name'];
        $target_dir = "../profileImages/";
        $target_file = $target_dir . basename($profileImageName);

// validate image size. Size is calculated in Bytes
        // if ($_FILES['profileImage']['size'] > 200000) {
        //     $msg = "Image size should not be greated than 200Kb";
        // }
// check if file exists
        if (file_exists($target_file)) {
            $msg = "File already exists";
        }
    }
    
    //get data
    $companyName = $_POST['companyName'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $eircode = $_POST['eircode'];
    $landline = $_POST['landline'];
    $mobile = $_POST['mobile'];
    
    move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file);
    // Prepare an insert statement
    $sql = "UPDATE admins SET image=?, companyName=?, email=?, firstname=?, surname=?, address=?, city=?, country=?, eircode=?, landlineNumber=?, mobileNumber=? WHERE username=?";
    $stmt = $pdo->prepare($sql);
    
    // Attempt to execute the prepared statement
    if ($stmt->execute([$profileImageName, $companyName, $email, $firstname, $lastname, $address, $city, $country, $eircode, $landline, $mobile, $_SESSION['admin']['username']])) {
        // Redirect to profile page
        
        header("location: ../admin-dashboard.php");
    } else {
        echo "Something went wrong. Please try again later.";
    }
}



?>