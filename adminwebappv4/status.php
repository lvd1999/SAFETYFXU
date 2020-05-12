<?php
// Initialize the session
session_start();
require_once 'includes/functions.php';
require_once 'includes/config.php';

//variables
$unreadDocuments = GOunreadDocument($_SESSION['admin']['adminID']);
$sites = get_sites($_SESSION['admin']['adminID']);
$members = AllMembersByAdminGroupByUser($_SESSION['admin']['adminID']);

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

	<?php $page='status'; include 'includes/head.php'; echo'<style>.sat h4{  background-color: #FFE400;
  color: #282828 !important;}</style>'?>
  <script type="text/javascript"  src="https://code.jquery.com/jquery-1.5.2.js" integrity="sha256-4hB8js20ecNtgi2CvaKoyvRCmrLSz58g1ckx91J1QDw=" crossorigin="anonymous"></script>
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
          <h3>Documents Status</h3>
        </div>
        <div class="row">
					<div class="col-md-5 col-lg-12">
						<div class="card card-user">
							<h3 class="stripe-1">Company Information</h3>
							<div class="card-header">
								<h3 class="card-title">Unread Documents</h3>
							</div>
							<div class="card-body">
              <table class="table table-striped" style="margin-top:-10%; text-align:center;">
              <tbody>
        <?php 
        // for each site by admin
          foreach($sites as $site) {
            // all unread documents by each site
            $unreadDocumentsV3 = GOunreadDocumentV3($site['buildingsiteID']); 
            // if more than one unread document exsits,
            if(count($unreadDocumentsV3) > 0) { ?>
              <tr class="tr" style="text-align:center; font-size:25px; background-color:#d6dbcb;"><th><strong><?php echo $site['code']; ?></strong></th></tr>
              
              <!-- for each unread document -->
              <?php foreach($unreadDocumentsV3 as $documentV3) {
                // count document with same title
                $count = count(unreadDocumentByTitle($documentV3['title']));?>
                
                <!-- make card -->
                <tr>
                  <th style="font-size:24px;"><a data-toggle="collapse" aria-expanded="false" aria-controls="collapseExample" style="color:black; font-size:24px;"> <?php echo $documentV3['title']; ?> <span class="badge badge-danger" style="font-size: 25px;"><?php echo $count; ?></span></a></th>
                </tr>
                <!-- document name as title of card -->
                <div class="collapse">
                <?php 
                // all unread member by documentID
                $unreadMembers = unreadDocumentMembersBySite($documentV3['documents_documentID']);
                foreach($unreadMembers as $unreadMember) { ?>
                 <tr style=""><th style="font-size:24px; text-align:center;" class="re"><a style="color:black;"  href="view-user.php?userid=<?php echo $unreadMember['userID'];?>"><?php echo $unreadMember['firstname'] . ' ' .$unreadMember['surname'];?></a></th></tr>
                  
                  <?php
                } ?>
               
                </div><br>
                    <?php
              } echo '<br>';
            } 
          }
        ?>
    </tbody>
</table>
</div>
</div>
</div>

<div class="col-lg-12">
<div class="card card-user">
  <h3 class="stripe-1">Company Information</h3>
  <div class="card-header">
    <h3 class="card-title">Safepass Expired members</h3>
  </div>
    <div class="card-body">
          <!-- Show members that safepass is expired or expiring within a month -->
          <table class="comic">
            <tbody>
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
                  echo '<tr><td><a style="color:black; font-size:25px;" href="view-user.php?userid='.$member['userID'].'">'.$member['firstname'] . ' ' . $member['surname']. '</a>\'s safepass expired <span style="font-size: 28px;" class="badge badge-warning">' . floor($difference / 86400) . '</span> days ago. </td></tr>';
                
                }
              }

              
            }
            
          ?>
          </tbody>
          </table>
          </div>
          </div>
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
