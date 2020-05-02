<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';
//variables
$unreadDocuments = GOunreadDocument($_SESSION['admin']['adminID']);
$sites = get_sites($_SESSION['admin']['adminID']);
$members = AllMembersByAdminGroupByUser($_SESSION['admin']['adminID']);
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <?php $page='status'; include 'includes/head.php'; ?>
  <!-- toggle -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script type="text/javascript"  src="https://code.jquery.com/jquery-1.5.2.js" integrity="sha256-4hB8js20ecNtgi2CvaKoyvRCmrLSz58g1ckx91J1QDw=" crossorigin="anonymous"></script>
  
</head>

<body>

  <div class="d-flex" id="wrapper">

    <?php include 'includes/sidebar.php'; ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <?php include 'includes/menubar.php'; ?>



      <div class="container-fluid">
        <!-- <h1>Unread Documents(ALL):</h1>
        <?php
        foreach($unreadDocuments as $document){
          echo 'name: ' . $document['firstname'] . ' ' . $document['surname'] . ' Title: ' .$document['title'] . '<br>'; 
        }
        ?>

        <h1>Unread Documents by each sites</h1>
        <?php
        foreach($sites as $site) {
          $unreadDocumentsV2 = GOunreadDocumentV2($site['buildingsiteID']);
          if(count($unreadDocumentsV2) > 0) { 
            
            echo $site['code'] . '<br>';
          
            
          
             
            foreach($unreadDocumentsV2 as $documentV2) { 
               echo $documentV2['firstname'] . ': ' . $documentV2['title'] . '<br>';
            }
          }
        }
            ?> -->
            
            

        <br>
        <h1>Unread documents</h1>
        <?php 
        // for each site by admin
          foreach($sites as $site) {
            // all unread documents by each site
            $unreadDocumentsV3 = GOunreadDocumentV3($site['buildingsiteID']); 
            // if more than one unread document exsits,
            if(count($unreadDocumentsV3) > 0) { ?>
            
              <h1><?php echo $site['code']; ?></h1>
              <!-- for each unread document -->
              <?php foreach($unreadDocumentsV3 as $documentV3) {
                // count document with same title
                $count = count(unreadDocumentByTitle($documentV3['title']));?>

                <!-- make card -->
                <div class="card"  style="width: 18rem;">
                <div class="card-header text-light bg-dark">
                <!-- document name as title of card -->
                <?php echo $documentV3['title']; ?>
                <span class="badge badge-danger"><?php echo $count; ?></span>
                </div>
                <ul class="list-group list-group-flush">
                <?php 
                // all unread member by documentID
                $unreadMembers = unreadDocumentMembersBySite($documentV3['documents_documentID']);
                foreach($unreadMembers as $unreadMember) { ?>
                  <li class="list-group-item"><a href="view-user.php?userid=<?php echo $unreadMember['userID'];?>"><?php echo $unreadMember['firstname'] . ' ' .$unreadMember['surname'];?></a></li>
                  
                  <?php
                } ?>
                </ul>
                    </div><br>
                    <?php
              } echo '<br>';
            } 
          }
        ?>


        



          <br>

          <!-- Show members that safepass is expired or expiring within a month -->
          <h1>Safepass Expired members</h1>
          
          <?php 
            foreach($members as $member) {
              
              $safepass = userSafepass($member['userID']);
              
              
              if (isset($safepass[0])) {
                
                $expDate = substr($safepass[0]['regNumber'], -4);
                
                
                $expMonth = substr($expDate, 0,2);
                $expYear = substr($expDate,-2);

                // make real date and calculate difference
                $from = strtotime('20'.$expYear.'-'.$expMonth.'-01');
                $today = time();
                $difference = $today - $from;

                if(floor($difference / 86400) >= -30) { ?>
                  <?php
                  echo '<a href="view-user.php?userid='.$member['userID'].'">'.$member['firstname'] . ' ' . $member['surname']. '</a>\'s safepass expired <span class="badge badge-warning">' . floor($difference / 86400) . '</span> days ago. <br>';

                }
              }

              
            }
            
          ?>
      </div>

    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <?php include 'includes/footer.php'; ?>


</body>

</html>