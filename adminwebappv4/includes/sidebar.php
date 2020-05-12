 <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
           <br>
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                  <li style="text-align: center;">
                    <h4 href="#" style="color: #FFE400;">Admin</h4>
                  </li>                    
                    <li style="margin-left:23%;">
                      <a class="navbar-brand" href="#"><img src="images/logo2.png" alt="Logo"></a>
                    </li>
                    <li>
                      <a href="./admin-dashboard.php" class="adminsidebar"> <h4 style="text-align:center;">Profile </h4></a>
                    </li>
                   
                    <li>
                      <a href="./sites.php" class=" <?php if ($page=='sites'){echo 'active';} else{'bg-light';}?>"><h4 style="text-align:center;">Sites </h4></a>
                    </li>

                    <li>
                      <a href="./status.php" class="sat"><h4 style="text-align:center;">Status </h4></a>
                    </li>

                    <li>
                      <a href="./documents.php" class="doc"><h4 style="text-align:center;">Documents </h4></a>
                    </li>

                    <li>
                    <a href="./tooltalks.php" class="<?php if ($page=='tooltalks'){echo 'active';} else{'bg-light';}?>"><h4 style="text-align:center;">Tooltalks </h4></a>
                    </li>
                   
                    <li>
                    <a href="./personnel.php" class="per"><h4 style="text-align:center;">Personnel</h4></a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->