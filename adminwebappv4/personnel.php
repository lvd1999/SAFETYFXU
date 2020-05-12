<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';

//variables
$_SESSION['admin'] = adminDetails($_SESSION['adminid']);
$company_name = $_SESSION['admin']['companyName'];
$username = $_SESSION['username'];

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["adminloggedin"]) || $_SESSION["adminloggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <?php $page='personnel'; include 'includes/head.php'; echo'<style>.per h4{  background-color: #FFE400;
  color: #282828 !important;}</style>' ?>


</head>



<body>

<?php $page='dashboard'; include 'includes/sidebar.php'; ?>
 <div id="right-panel" class="right-panel">
   <div class="wrapper" id="wrapper">
      <!-- Page Content -->
        <?php include 'includes/menubar.php'; ?>
     <div class="main-panel">  
      <!-- /#page-content-wrapper -->
      <div class="content">
        <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: -2%">
          <h3>Personnel</h3>
        </div>
      <!-- all members by site -->
        <!-- <?php
          foreach($sites as $site) {
            $siteMembers = membersBySite($site['buildingsiteID']); ?>
        <div class="card bg-dark" style="width: 18rem;">
          <div class="card-header text-white bg-dark">
            <?php echo $site['sitename']; ?>
          </div>
          <ul class="list-group list-group-flush">
            <?php
            foreach($siteMembers as $siteMember) { 
              echo '<li class="list-group-item">'.$siteMember['firstname']. ' '.$siteMember['surname'].'</li>';
            }?>
          </ul>
        </div>
        <?php 
          } echo '<br>';
        ?> -->

      <!-- new personnel -->
      <?php
      $members = AllMembersByAdminGroupByUser($_SESSION['admin']['adminID']);
      if(count($members) > 1) { ?>
        <table class="comic2">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Occupation</th>
            <th scope="col">Site</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($members as $member) { ?>
            <tr>
              <td><a href="view-user.php?userid=<?php echo $member['userID'];?>" style="color:black; font-size:25px;"><?php echo $member['firstname'] . ' ' . $member['surname'];?></a></td>
              <td><?php echo $member['occupation'];?></td>
              <!-- for sites -->
              <?php $workingsites = workingSitesByUserToAdmin($member['userID'], $_SESSION['admin']['adminID']);?>
              <td><?php foreach($workingsites as $workingsite) {
                echo '<span>'.$workingsite['sitename'].'</span><br>';
        } ?></td>
              
            </tr>
            <?php
          } 
        ?>
        </tbody>
          </table>
      <?php } ?>
        </div>
         
</div>

    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <?php include 'includes/footer.php'; ?>
  <script src="./js/demo.js"></script>

</body>

</html>