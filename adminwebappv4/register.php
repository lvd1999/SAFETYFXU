<?php
// Include config file
require_once "includes/config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $company_name = "";
$username_err = $password_err = $confirm_password_err = $company_name_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT adminID FROM admins WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    //validate company name
    // Validate username
    if(empty(trim($_POST["company_name"]))){
        $username_err = "Please enter a company name.";
    } else{
        // Prepare a select statement
        $sql = "SELECT adminID FROM admins WHERE companyName = :company_name";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":company_name", $param_company_name, PDO::PARAM_STR);
            
            // Set parameters
            $param_company_name = trim($_POST["company_name"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $company_name_err = "This company name is already taken.";
                } else{
                    $company_name = trim($_POST["company_name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($company_name_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO admins (username, password, companyName) VALUES (:username, :password, :company_name)";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":company_name", $param_company_name, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_company_name = $company_name;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">  
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
            <div class="wrap-login103">
                <form class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <span class="login100-form-logo1">
						<img src="images/logo2.png" alt="" id="profileDisplay1">
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
                        Sign Up
                        <p>Please fill this form to create an account.</p>
                    </span>
                    
                    <div data-validate="Enter Username" class="wrap-input100 validate-input <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <input type="text" name="username" class="input100" placeholder="Username" value="<?php echo $username; ?>">
                        <span class="focus-input100" data-placeholder="&#xf207;"><?php echo $username_err; ?></span>
                    </div>

                    <div data-validate="Enter password" class="wrap-input100 validate-input <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="password" class="input100" placeholder="Password" value="<?php echo $password; ?>">
                        <span class="focus-input100" data-placeholder="&#xf191;"><?php echo $password_err; ?></span>
                    </div>

                    <div data-validate="Confirm password" class="wrap-input100 validate-input <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="confirm_password" class="input100" placeholder="Confirm Password" value="<?php echo $confirm_password; ?>">
                        <span class="focus-input100" data-placeholder="&#xf191;"><?php echo $confirm_password_err; ?></span>
                    </div>

                    <div data-validate="Enter Company Name" class="wrap-input100 validate-input <?php echo (!empty($company_name_err)) ? 'has-error' : ''; ?>">
                        <input type="text" name="company_name" class="input100" placeholder="Company Name" value="<?php echo $company_name; ?>">
                        <span class="focus-input100" data-placeholder="&#xf132;" ><?php echo $company_name_err; ?></span>
                    </div> 

                    <div class="container-login100-form-btn">
                        <div class="row">
                            <button class="login100-form-btn" value="Submit" type="submit">
                                Submit
                            </button>
                            <button class="login100-form-btn" type="reset" value="Reset">
                               Reset
                            </button>
                        </div>
                    </div>

                    <div class="text-right p-t-50">
						<a class="txt1" href="login.php">
                            Already have an account? Login here.
						</a>
					</div>
                  
                    <div class="stripe-1"></div>
                </form>
            </div>  
        </div>
    </div> 
    
    <div id="dropDownSelect1"></div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <script src="js/main.js"></script>   
</body>
</html>