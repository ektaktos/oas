<nav class="navbar navbar-expand navbar-dark bg-dark nav-fixed-top">
   
      <a class="nav-brand mr-1" href="<?php echo $link; ?>" style="color: #ffffff;">
        <img src="Admin/dashboard/image/logo.gif" width="50" height="50" alt="AU">
        <span style="color: white;">ASG System</span>
      </a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>


      <!-- Navbar Dispaly Search bar and User Name -->
      
       <?php if (!empty($_SESSION['oas_tutorId'])) { ?>  
      <form class="d-none d-md-inline-block form-inline ml-auto" method="post" action="searchStudent.php">
          <input type="text" name="matricNum" class="form-control" placeholder="Enter Matric Number">
          <input type="submit" value="Search" name="submit" class="btn">
      </form>
    <?php } ?>
      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i><?php echo $Name;?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            <a class="dropdown-item" href="#">Profile</a>
          </div>
        </li>
      </ul>

    </nav>