<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';
//variables
$sites = get_sites($_SESSION['admin']['adminID']);
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <?php $page='personnel'; include 'includes/head.php'; ?>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

  <div class="d-flex" id="wrapper">

    <?php include 'includes/sidebar.php'; ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <?php include 'includes/menubar.php'; ?>



      <div class="container-fluid">
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
        <table class="table">
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
              <td><a href="view-user.php?userid=<?php echo $member['userID'];?>"><?php echo $member['firstname'] . ' ' . $member['surname'];?></a></td>
              <td><?php echo $member['occupation'];?></td>
              <!-- for sites -->
              <?php $workingsites = workingSitesByUserToAdmin($member['userID'], $_SESSION['admin']['adminID']);?>
              <td><?php foreach($workingsites as $workingsite) {
          echo '<span class="badge badge-light">'.$workingsite['sitename'].'</span>';
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
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <?php include 'includes/footer.php'; ?>


</body>

</html>