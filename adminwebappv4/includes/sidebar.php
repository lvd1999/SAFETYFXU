    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading"> Admin </div>
      <div class="list-group list-group-flush">
        <a href="admin-dashboard.php" class="list-group-item list-group-item-action <?php if ($page=='dashboard'){echo 'active bg-primary';} else{'bg-light';}?>">Profile</a>
        <a href="sites.php" class="list-group-item list-group-item-action <?php if ($page=='sites'){echo 'active bg-primary';} else{'bg-light';}?>">Sites</a>
        <a href="status.php" class="list-group-item list-group-item-action <?php if ($page=='status'){echo 'active bg-primary';} else{'bg-light';}?>" >Status</a>
        <a href="documents.php" class="list-group-item list-group-item-action <?php if ($page=='documents'){echo 'active bg-primary';} else{'bg-light';}?> ">Documents</a>
        <a href="tooltalks.php" class="list-group-item list-group-item-action <?php if ($page=='tooltalks'){echo 'active bg-primary';} else{'bg-light';}?>">Tooltalks</a>
        <a href="personnel.php" class="list-group-item list-group-item-action <?php if ($page=='personnel'){echo 'active bg-primary';} else{'bg-light';}?>">Personnel</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->