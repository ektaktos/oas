<?php
// Validating that the Student is really logged in and authorized
session_start();

require_once 'Admin/connect.php';

if (!empty($_SESSION['oas_tutorId'])) {

$tutorId = $_SESSION['oas_tutorId'];
$link = "tutor.php";

// Mysql Query to select all the available announcements based on tutorid
$selectAnnouncement = "SELECT* FROM announcement WHERE tutor_id = '$tutorId' AND visible='1'";
$resultAnnouncement = $conn->query($selectAnnouncement); 

  $queryTutor = "SELECT Name FROM tutor WHERE StaffId = '$tutorId'";
  $resultTutor = $conn->query($queryTutor);

    while ($row = $resultTutor->fetch_assoc()) {
        $Name = $row['Name'];
    }
 }
 elseif (!empty($_SESSION['oas_studmatricNum'])) {
  $matricNum = $_SESSION['oas_studmatricNum'];
  $link = "student.php";

// Mysql Query to select all the available announcements based on tutorid
$selectAnnouncement = "SELECT* FROM announcement";
$resultAnnouncement = $conn->query($selectAnnouncement); 

  $queryStudent = "SELECT Name FROM student WHERE MatricNum = '$matricNum'";
  $resultStudent = $conn->query($queryStudent);

 while ($row = $resultStudent->fetch_assoc()) {
        $Name = $row['Name'];
    }

 }
 else{
  echo "Sorry You are not Authorized to view this page";
  header("Location:index.php");
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

    <title>Announcement - OAS</title>

    <!-- Bootstrap core CSS-->
    <link href="Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="Admin/dashboard/css/sb-admin.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

<!--       <a class="navbar-brand mr-1" href="tutor.php">Home</a>--> 

          <a class="nav-brand mr-1" href="tutor.php" style="color: #ffffff;">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span >Dashboard</span>
          </a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>


      <!-- Navbar Dispaly Search bar and User Name -->
      
      <form class="d-none d-md-inline-block form-inline ml-auto ">
          <input type="text" name="matricNum" class="form-control" placeholder="Enter Matric Number">
          <input type="submit" value="Search" name="submit" class="btn">
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i><?php echo $Name;?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            <a class="dropdown-item" href="profile.php">Profile</a>
          </div>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

       <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
      <?php if (!empty($_SESSION['oas_tutorId'])) { ?>
        <li class="nav-item">
            <a href="scoresheet.php" class="nav-link">
              <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Scoresheet</span>
            </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="searchStudent.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Search Student</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="checkSubmission.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Check Submission</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="creategroup.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Create Group</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="newAssignment.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>New Assignment</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="groupAssignment.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>New Group Assignment</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="articleEntry.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Article Entry</span>
          </a>
        </li>

         <li class="nav-item active">
          <a class="nav-link" href="announcement.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Announcement</span>
          </a>
        </li>
        
      <?php } elseif(!empty($_SESSION['oas_studmatricNum'])){?>

        <li class="nav-item">
          <a class="nav-link" href="registerCourse.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Register Course</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="announcement.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Announcement</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="viewscores.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>View Scores</span>
          </a>
        </li>

       <li class="nav-item active">
          <a class="nav-link" href="articleEntry.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Article Entry</span>
          </a>
        </li>
        <?php } ?>

      </ul>


      <div id="content-wrapper">

        <div class="container">
          <h4 style="margin: 10px 0px 20px 0px; text-align: center;">Announcements</h4>
          <?php if (!empty($_SESSION['oas_tutorId'])) { ?>
          <div class="col-sm-7" style="border:2px solid #dddddd;">
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" placeholder="Enter Announcement Title" class="form-control">
          </div>
          <div class="form-group">
            <label>Announcement Content</label>
            <textarea class="form-control" name="content"></textarea>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary">
          </div>
         </form>
         </div>
       <?php }?>
         <!-- Table to dispaly all current articles -->
            <table class="table table-responsive" style="margin-top: 40px;">
              <thead>
                <tr>
                  <th>Sn</th>
                  <th>Title</th>
                  <th>Content</th>
                  <th>Date</th>
                  <th>Tutor Id</th>
                  <?php if(isset($tutorId)){?>
                  <th>Action</th>
                  <?php } ?>
                </tr>
              </thead>

              <tbody>
                <?php
                  
                   $sn = 1;
                    while ($row = $resultAnnouncement->fetch_assoc()) {
                      
                      echo"<tr>";
                      echo "<td>".$sn.".</td>";
                      echo "<td>".$row['title']."</td>";
                      echo "<td>".$row['content']."</td>";
                      echo "<td>".date("M j, Y",strtotime($row['date']))."</td>";
                      echo "<td>".$row['tutor_id']."</td>";
                      if(isset($tutorId)){
                      echo "<td><a href='#' onclick='deletesn(".$row['sn'].")'>Delete</a></td>";
                      } 
                      echo "</tr>";
                      $sn+=1;
                    }
                ?>

              </tbody>
            </table>
  

        </div>
        <!-- /.container-fluid -->

        

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->
<!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © Your Website 2018</span>
            </div>
          </div>
        </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="Admin/dashboard/vendor/jquery/jquery.min.js"></script>
    <script src="Admin/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="Admin/dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>

  </body>
</html>
<script>
  function deletesn(id){
     $.ajax({
            type:"post",
            url: "delete.php",
            data:{id:id ,db : 'announcement'},
            success: function(res) { 
                alert(res);
                setTimeout(() => {
                    location.reload();
                }, 500);
            },
            error: function() { 
            }
        })
  }
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (!empty($_POST['title']) && !empty($_POST['content'])) {
  
  $title = fix_string($_POST['title']);
  $content = fix_string($_POST['content']);
  $date = date("Y-m-d h:i:sa");

  $stmt = $conn->prepare("INSERT INTO announcement (title,content,tutor_id,date,visible) VALUES (?,?,?,?,?)");
  $stmt->bind_param("sssss",$title,$content,$tutorId,$date,'1');

  if($stmt->execute()){
     echo "Data Inserted Successfully";
     ?><script>window.location.href = 'announcement.php'</script><?php
  }
  else{
      echo "Data not Successfully Inserted" . $stmt->error;
  }

}//End of validating that the POST variables are not empty

}//End of validating that the request method is a POST method



function fix_string($string)
{
if (get_magic_quotes_gpc()) $string = stripslashes($string);
return htmlentities ($string);
}




?>
