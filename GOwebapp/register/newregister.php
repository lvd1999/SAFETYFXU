<?php
session_start();

// Include config file
require_once "../includes/config.php";

// Define variables and initialize with empty values
$email = $password = $confirm_password = $dob = $firstname = $surname = $phone = $sex = $occupation = $position = $english = $nationality = "";
$email_err = $password_err = $confirm_password_err = $dob_err = $firstname_err = $surname_err = $phone_err = $occupation_err = $position_err = $english_err = $nationality_err = $img_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter a email.";
    } else {
        // Prepare a select statement
        $sql = "SELECT userID FROM users WHERE email = :email";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            }

            // Close statement
            unset($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    //validate all other input
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = "Please enter first name.";
    } else {
        $firstname = trim($_POST["firstname"]);
    }

    if (empty(trim($_POST["surname"]))) {
        $surname_err = "Please enter surname.";
    } else {
        $surname = trim($_POST["surname"]);
    }

    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter phone number.";
    } else {
        $phone = trim($_POST["phone"]);
    }
    if (trim($_POST["occupation"]) == "0") {
      $occupation_err = "Please choose an occupation.";
  } else {
      $occupation = trim($_POST["occupation"]);
  }
    if (trim($_POST["position"]) == "0") {
      $position_err = "Please choose an position.";
  } else {
      $position = trim($_POST["position"]);
  }
  if (trim($_POST["nationality"]) == "0") {
    $nationality_err = "Please choose a nationality.";
} else {
    $nationality = trim($_POST["nationality"]);
}
if (trim($_POST["english"]) == "0") {
  $english_err = "Please choose English level.";
} else {
  $english = trim($_POST["english"]);
}

$date = $_POST['dob'];
$_age = floor((time() - strtotime("$date")) / 31556926);
if($_age <= 16) {$dob_err = 'Age must be over 16.';}

//for image
$profileImageName = time() . '-' . $_FILES['profileImage']['name'];
$target_dir = "../profileImages/";
$target_file = $target_dir . basename($profileImageName);

// validate image size. Size is calculated in Bytes
if ($_FILES['profileImage']['size'] > 200000) {
    $img_err = "Image size should not be greated than 200Kb";
}
// check if file exists
if (file_exists($target_file)) {
    $img_err = "File already exists";
}
// Upload image only if no errors
if (empty($img_err)) {
    move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file);
}

    // Check input errors register
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($surname_err) && empty($phone_err) && empty($occupation_err) && empty($position_err) && empty($nationality_err) && empty($english_err) && empty($img_err)) {
      // $sql = "INSERT INTO users (email, password, firstname, surname, dob, sex, occupation, position, nationality, english, phone) VALUES (:email, :password, :firstname, :surname, :dob, :sex, :occupation, :position, :nationality, :english, :phone)";
      $sql = "INSERT INTO users (email, password, firstname, surname, dob, sex, occupation, position, nationality, english, phone, profileImage) VALUES (:email, :password, :firstname, :surname, :dob, :sex, :occupation, :position, :nationality, :english, :phone, :profile_image)";

      if ($stmt = $pdo->prepare($sql)) {
          // Bind variables to the prepared statement as parameters
          $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
          $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
          $stmt->bindParam(":firstname", $param_firstname, PDO::PARAM_STR);
          $stmt->bindParam(":surname", $param_surname, PDO::PARAM_STR);
          $stmt->bindParam(":dob", $param_dob, PDO::PARAM_STR);
          $stmt->bindParam(":sex", $param_sex, PDO::PARAM_STR);
          $stmt->bindParam(":occupation", $param_occupation, PDO::PARAM_STR);
          $stmt->bindParam(":position", $param_position, PDO::PARAM_STR);
          $stmt->bindParam(":nationality", $param_nationality, PDO::PARAM_STR);
          $stmt->bindParam(":english", $param_english, PDO::PARAM_STR);
          $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
          $stmt->bindParam(":profile_image", $param_profile_image, PDO::PARAM_STR);
  
          // Set parameters
          $param_email = $email;
          $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
          $param_firstname = $firstname;
          $param_surname = $surname;
          $param_dob = $dob;
          $param_sex = $sex;
          $param_occupation = $occupation;
          $param_position = $position;
          $param_nationality = $nationality;
          $param_english = $english;
          $param_phone = $phone;
          $param_profile_image = $profileImageName;
  
          // Attempt to execute the prepared statement
          if ($stmt->execute()) {
              // Redirect to GO homepage
              echo "<script>
              alert('Registered successfully!');
              window.location.href='../login.php';
              </script>";
          } else {
              echo "Something went wrong. Please try again later.";
          }
  
          // Close statement
          unset($stmt);
      }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../vendor/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                enctype="multipart/form-data">
                <div class="form-group mx-auto" style="width:200px">
                  <img src="../images/blank-avatar.jpg" onClick='triggerClick()' id='profileDisplay' class="img-fluid" id="profile">
                  <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage"
            class="form-control d-none">
            <p class="text-danger"><?php echo $img_err;?></p>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="FirstName">First Name</label>
                    <input type="text" class="form-control" id="FirstName" name="firstname">
                    <p class="text-danger"><?php echo $firstname_err;?></p>
                  </div>
                  <div class="col-sm-6">
                    <label for="LastName">Surname</label>
                    <input type="text" class="form-control" id="LastName" name="surname">
                    <p class="text-danger"><?php echo $surname_err;?></p>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="InputEmail">Email</label>
                    <input type="email" class="form-control " id="InputEmail" name="email">
                    <p class="text-danger"><?php echo $email_err;?></p>
                  </div>
                  <div class="col-sm-6">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                    <p class="text-danger"><?php echo $phone_err;?></p>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="Password1">Password</label>
                    <input type="password" class="form-control " id="Password" name="password">
                    <p class="text-danger"><?php echo $password_err;?></p>
                  </div>
                  <div class="col-sm-6">
                    <label for="LastName">Repeat Password</label>
                    <input type="password" class="form-control" id="Password" name="confirm_password">
                    <p class="text-danger"><?php echo $confirm_password_err;?></p>
                  </div>
                </div>

                <div class="form-group">
                  <label for="date">Date of Birth</label>
                  <input placeholder="Date of Birth" class="form-control" type="text" onfocus="(this.type='date')"
                    onblur="(this.type='text')" id="date" name="dob" />
                    <p class="text-danger"><?php echo $dob_err;?></p>
                </div>

                <div class="form-group">
                  <label for="sex">Sex</label>
                  <select class="form-control" name="sex">
                    <option value="male" selected>Male</option>
                    <option value="female">Female</option>
                    <option value="other">Others</option>
                  </select>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label>Occupation</label>
                    <select class="form-control" name="occupation">
                      <option value="0" selected style="margin-top: -5px;">Choose Occupation</option>
                      <option value="Contracts Manager">Contracts Manager</option>
                      <option value="Project Manager">Project Manager</option>
                      <option value="Architect">Architect</option>
                      <option value="Structural Engineer">Structural Engineer</option>
                      <option value="Mechanical Engineer">Mechanical Engineer</option>
                      <option value="Civil Engineer">Civil Engineer</option>
                      <option value="General Operatives">General Operatives</option>
                      <option value="Plumber">Plumber</option>
                      <option value="Electrician">Electrician</option>
                      <option value="Scaffoler">Scaffoler</option>
                      <option value="Plasterer">Plasterer</option>
                      <option value="Lift Installer">Lift Installer</option>
                      <option value="Fireproofing">Fireproofing</option>
                      <optgroup label="Machine Operator">
                        <option value="Excavator Driver">Excavator Driver</option>
                        <option value="Telehandler Driver">Telehandler Driver</option>
                        <option value="Crane Operator">Crane Operator</option>
                        <option value="Specialist Foreman">Specialist Foreman</option>
                      </optgroup>
                      <option value="Other">Other</option>
                    </select>
                    <p class="text-danger"><?php echo $occupation_err;?></p>
                  </div>

                  <div class="col-sm-6">
                    <label for="position">Position</label>
                    <select id="position" class="form-control" data-size="1" name="position">
                      <option selected value="0">Choose Position...</option>
                      <option>General</option>
                      <option>Manager</option>
                      <option>Foreman</option>
                      <option>Other</option>
                    </select>
                    <p class="text-danger"><?php echo $position_err;?></p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="nationality">Nationality</label>
                  <select id="nationality" class="form-control" name="nationality">
                    <option selected value="0">Choose Nationality...</option>
                    <option value="irish">Irish</option>
                    <option value="british">British</option>
                    <option value="latvian">Latvian</option>
                    <option value="lithuanian">Lithuanian</option>
                    <option value="polish">Polish</option>
                    <option value="afghan">Afghan</option>
                    <option value="albanian">Albanian</option>
                    <option value="algerian">Algerian</option>
                    <option value="american">American</option>
                    <option value="andorran">Andorran</option>
                    <option value="angolan">Angolan</option>
                    <option value="antiguans">Antiguans</option>
                    <option value="argentinean">Argentinean</option>
                    <option value="armenian">Armenian</option>
                    <option value="australian">Australian</option>
                    <option value="austrian">Austrian</option>
                    <option value="azerbaijani">Azerbaijani</option>
                    <option value="bahamian">Bahamian</option>
                    <option value="bahraini">Bahraini</option>
                    <option value="bangladeshi">Bangladeshi</option>
                    <option value="barbadian">Barbadian</option>
                    <option value="barbudans">Barbudans</option>
                    <option value="batswana">Batswana</option>
                    <option value="belarusian">Belarusian</option>
                    <option value="belgian">Belgian</option>
                    <option value="belizean">Belizean</option>
                    <option value="beninese">Beninese</option>
                    <option value="bhutanese">Bhutanese</option>
                    <option value="bolivian">Bolivian</option>
                    <option value="bosnian">Bosnian</option>
                    <option value="brazilian">Brazilian</option>
                    <option value="bruneian">Bruneian</option>
                    <option value="bulgarian">Bulgarian</option>
                    <option value="burkinabe">Burkinabe</option>
                    <option value="burmese">Burmese</option>
                    <option value="burundian">Burundian</option>
                    <option value="cambodian">Cambodian</option>
                    <option value="cameroonian">Cameroonian</option>
                    <option value="canadian">Canadian</option>
                    <option value="cape verdean">Cape Verdean</option>
                    <option value="central african">Central African</option>
                    <option value="chadian">Chadian</option>
                    <option value="chilean">Chilean</option>
                    <option value="chinese">Chinese</option>
                    <option value="colombian">Colombian</option>
                    <option value="comoran">Comoran</option>
                    <option value="congolese">Congolese</option>
                    <option value="costa rican">Costa Rican</option>
                    <option value="croatian">Croatian</option>
                    <option value="cuban">Cuban</option>
                    <option value="cypriot">Cypriot</option>
                    <option value="czech">Czech</option>
                    <option value="danish">Danish</option>
                    <option value="djibouti">Djibouti</option>
                    <option value="dominican">Dominican</option>
                    <option value="dutch">Dutch</option>
                    <option value="east timorese">East Timorese</option>
                    <option value="ecuadorean">Ecuadorean</option>
                    <option value="egyptian">Egyptian</option>
                    <option value="emirian">Emirian</option>
                    <option value="equatorial guinean">Equatorial Guinean</option>
                    <option value="eritrean">Eritrean</option>
                    <option value="estonian">Estonian</option>
                    <option value="ethiopian">Ethiopian</option>
                    <option value="fijian">Fijian</option>
                    <option value="filipino">Filipino</option>
                    <option value="finnish">Finnish</option>
                    <option value="french">French</option>
                    <option value="gabonese">Gabonese</option>
                    <option value="gambian">Gambian</option>
                    <option value="georgian">Georgian</option>
                    <option value="german">German</option>
                    <option value="ghanaian">Ghanaian</option>
                    <option value="greek">Greek</option>
                    <option value="grenadian">Grenadian</option>
                    <option value="guatemalan">Guatemalan</option>
                    <option value="guinea-bissauan">Guinea-Bissauan</option>
                    <option value="guinean">Guinean</option>
                    <option value="guyanese">Guyanese</option>
                    <option value="haitian">Haitian</option>
                    <option value="herzegovinian">Herzegovinian</option>
                    <option value="honduran">Honduran</option>
                    <option value="hungarian">Hungarian</option>
                    <option value="icelander">Icelander</option>
                    <option value="indian">Indian</option>
                    <option value="indonesian">Indonesian</option>
                    <option value="iranian">Iranian</option>
                    <option value="iraqi">Iraqi</option>
                    <option value="israeli">Israeli</option>
                    <option value="italian">Italian</option>
                    <option value="ivorian">Ivorian</option>
                    <option value="jamaican">Jamaican</option>
                    <option value="japanese">Japanese</option>
                    <option value="jordanian">Jordanian</option>
                    <option value="kazakhstani">Kazakhstani</option>
                    <option value="kenyan">Kenyan</option>
                    <option value="kittian and nevisian">Kittian and Nevisian</option>
                    <option value="kuwaiti">Kuwaiti</option>
                    <option value="kyrgyz">Kyrgyz</option>
                    <option value="laotian">Laotian</option>
                    <option value="lebanese">Lebanese</option>
                    <option value="liberian">Liberian</option>
                    <option value="libyan">Libyan</option>
                    <option value="liechtensteiner">Liechtensteiner</option>
                    <option value="luxembourger">Luxembourger</option>
                    <option value="macedonian">Macedonian</option>
                    <option value="malagasy">Malagasy</option>
                    <option value="malawian">Malawian</option>
                    <option value="malaysian">Malaysian</option>
                    <option value="maldivan">Maldivan</option>
                    <option value="malian">Malian</option>
                    <option value="maltese">Maltese</option>
                    <option value="marshallese">Marshallese</option>
                    <option value="mauritanian">Mauritanian</option>
                    <option value="mauritian">Mauritian</option>
                    <option value="mexican">Mexican</option>
                    <option value="micronesian">Micronesian</option>
                    <option value="moldovan">Moldovan</option>
                    <option value="monacan">Monacan</option>
                    <option value="mongolian">Mongolian</option>
                    <option value="moroccan">Moroccan</option>
                    <option value="mosotho">Mosotho</option>
                    <option value="motswana">Motswana</option>
                    <option value="mozambican">Mozambican</option>
                    <option value="namibian">Namibian</option>
                    <option value="nauruan">Nauruan</option>
                    <option value="nepalese">Nepalese</option>
                    <option value="new zealander">New Zealander</option>
                    <option value="ni-vanuatu">Ni-Vanuatu</option>
                    <option value="nicaraguan">Nicaraguan</option>
                    <option value="nigerien">Nigerien</option>
                    <option value="north korean">North Korean</option>
                    <option value="northern irish">Northern Irish</option>
                    <option value="norwegian">Norwegian</option>
                    <option value="omani">Omani</option>
                    <option value="pakistani">Pakistani</option>
                    <option value="palauan">Palauan</option>
                    <option value="panamanian">Panamanian</option>
                    <option value="papua new guinean">Papua New Guinean</option>
                    <option value="paraguayan">Paraguayan</option>
                    <option value="peruvian">Peruvian</option>
                    <option value="portuguese">Portuguese</option>
                    <option value="qatari">Qatari</option>
                    <option value="romanian">Romanian</option>
                    <option value="russian">Russian</option>
                    <option value="rwandan">Rwandan</option>
                    <option value="saint lucian">Saint Lucian</option>
                    <option value="salvadoran">Salvadoran</option>
                    <option value="samoan">Samoan</option>
                    <option value="san marinese">San Marinese</option>
                    <option value="sao tomean">Sao Tomean</option>
                    <option value="saudi">Saudi</option>
                    <option value="scottish">Scottish</option>
                    <option value="senegalese">Senegalese</option>
                    <option value="serbian">Serbian</option>
                    <option value="seychellois">Seychellois</option>
                    <option value="sierra leonean">Sierra Leonean</option>
                    <option value="singaporean">Singaporean</option>
                    <option value="slovakian">Slovakian</option>
                    <option value="slovenian">Slovenian</option>
                    <option value="solomon islander">Solomon Islander</option>
                    <option value="somali">Somali</option>
                    <option value="south african">South African</option>
                    <option value="south korean">South Korean</option>
                    <option value="spanish">Spanish</option>
                    <option value="sri lankan">Sri Lankan</option>
                    <option value="sudanese">Sudanese</option>
                    <option value="surinamer">Surinamer</option>
                    <option value="swazi">Swazi</option>
                    <option value="swedish">Swedish</option>
                    <option value="swiss">Swiss</option>
                    <option value="syrian">Syrian</option>
                    <option value="taiwanese">Taiwanese</option>
                    <option value="tajik">Tajik</option>
                    <option value="tanzanian">Tanzanian</option>
                    <option value="thai">Thai</option>
                    <option value="togolese">Togolese</option>
                    <option value="tongan">Tongan</option>
                    <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                    <option value="tunisian">Tunisian</option>
                    <option value="turkish">Turkish</option>
                    <option value="tuvaluan">Tuvaluan</option>
                    <option value="ugandan">Ugandan</option>
                    <option value="ukrainian">Ukrainian</option>
                    <option value="uruguayan">Uruguayan</option>
                    <option value="uzbekistani">Uzbekistani</option>
                    <option value="venezuelan">Venezuelan</option>
                    <option value="vietnamese">Vietnamese</option>
                    <option value="welsh">Welsh</option>
                    <option value="yemenite">Yemenite</option>
                    <option value="zambian">Zambian</option>
                    <option value="zimbabwean">Zimbabwean</option>
                  </select>
                  <p class="text-danger"><?php echo $nationality_err;?></p>
                </div>
                <div class="form-group">
                  <label for="english">English</label>
                  <select class="form-control" name="english">
                    <option value="0" selected>Select english level...</option>
                    <option value="Poor">Poor</option>
                    <option value="Good">Good</option>
                    <option value="Fluent">Fluent</option>
                  </select>
                  <p class="text-danger"><?php echo $english_err;?></p>
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Register Account
                </button>

              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgot-password.html">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="../login.php">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<script>
function triggerClick(e) {
  document.querySelector('#profileImage').click();
}
function displayImage(e) {
  if (e.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      document
        .querySelector('#profileDisplay')
        .setAttribute('src', e.target.result);
    };
    reader.readAsDataURL(e.files[0]);
  }
}

</script>