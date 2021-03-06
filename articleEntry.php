<?php
// Validating that the Student is really logged in and authorized
session_start();

require_once 'Admin/connect.php';

if (!empty($_SESSION['oas_tutorId'])) {

$tutorId = $_SESSION['oas_tutorId'];
$link = "tutor.php";

  $queryTutor = "SELECT Name FROM tutor WHERE StaffId = '$tutorId'";
  $resultTutor = $conn->query($queryTutor);

    while ($row = $resultTutor->fetch_assoc()) {
        $Name = $row['Name'];
    }
 }
 elseif (!empty($_SESSION['oas_studmatricNum'])) {
  $matricNum = $_SESSION['oas_studmatricNum'];
  $link = "student.php";

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
<!--    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no>-->
    <link href="Admin/dashboard/image/logo.gif" rel="shortcut icon"/>
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Article Entry - ASG</title>

    <!-- Bootstrap core CSS-->
    <link href="Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="Admin/dashboard/css/sb-admin.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
   
      <a class="nav-brand mr-1" href="<?php echo $link; ?>" style="color: #ffffff;">
        <img src="Admin/dashboard/image/logo.gif" width="50" height="50" alt="AU">
        <span style="color: white;">ASG System</span>
      </a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <form class="d-none d-md-inline-block form-inline ml-auto">
         
      </form>

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
            <a class="dropdown-item" href="profile.php">Profile</a>
          </div>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <?php include 'sidebar.php'; ?>

      <div id="content-wrapper">
        <div class="container-fluid">
            <h3>Article Entry</h3>
            <div id="message" style="text-align: center; margin-top: 5px;"></div>
        <!-- Ensuring only the tutor has access to upload article -->
        <?php if (!empty($_SESSION['oas_tutorId'])) { ?>
          <div style="background-color: #343a40; padding: 10px 0px 0px 5px; border: 2px solid silver; border-radius: 5px; color: #FFF;" class="col-sm-10">
          <form method="post" class="form-inline" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                       
              <div class="form-group" style="margin: 10px 5px 10px 15px;">
                <label>Article Name:&nbsp; </label> 
                <input type="text" name="articleName" placeholder="Enter Article name" class="form-control">
              </div>

              <div class="form-group" style="margin: 10px 5px 10px 15px;">
                <label>Article File:&nbsp; </label> 
                <input type="file" name="articleFile" class="form-control">
              </div>

              <div style="margin: 10px 5px 10px 15px;">
              <input type="submit" value="Upload" name="submit" class="btn btn-primary">
              </div>            
            </form>
            </div>
          <?php } ?>
            <!-- Table to dispaly all current articles -->
            <table class="table table-responsive" style="margin-top: 40px;">
              <thead>
                <tr>
                  <th>Sn</th>
                  <th>Article Name</th>
                  <th>Author</th>
                  <th>Date Uploaded</th>
                  <?php
                  if (!empty($_SESSION['oas_tutorId'])) {
                  echo "<th>Action</th>";
                  }
                  ?>
                </tr>
              </thead>

              <tbody>
                <?php
                   $query = "SELECT* FROM article WHERE visible='1'";
                   $result = $conn->query($query);
                   $sn = 1;
                    while ($row = $result->fetch_assoc()) {
                      
                      echo"<tr>";
                      echo "<td>".$sn.".</td>";
                      echo "<td><a href='".$row['articlePath']."'>".$row['articleName']."</a></td>";
                      echo "<td>".$row['tutorName']."</td>";
                      echo "<td>".date("M j, Y",strtotime($row['uploadedDate']))."</td>";
                      if (!empty($_SESSION['oas_tutorId'])) {
                      echo "<td><button onclick='deletearticle(".$row['sn'].")'>Delete</button></td>";
                       }
                      echo "</tr>";
                      $sn+=1;
                    }
                ?>

              </tbody>
            </table>



        </div>
      </div>
        <!-- /.container-fluid -->

      </div>
      <!-- /.content-wrapper -->
<!-- Sticky Footer -->
        <footer class="sticky-footer container-fluid">
          <div class="container my-auto">
            <div class="copyright my-auto">
              <span>Assignment Submission & Grading System &copy; All rights reserved <?=date('Y')?></span>
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

    <!-- Custom scripts for all pages-->
    <script src="Admin/dashboard/js/sb-admin.min.js"></script>


  </body>

</html>
<script>

  function deletearticle(id){
     $.ajax({
            type:"post",
            url: "delete.php",
            data:{id:id ,db : 'article'},
            success: function() { 
                alert('Article deleted Successfully');
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

// Confirming that post data was sent from the same page
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Confirming that submitted variables are not empty
    if (!empty($_POST['articleName']) && !empty($_FILES['articleFile']['tmp_name'])) {

      $name = $_POST['articleName'];
      $uploadedDate = date("Y-m-d h:i:sa");
      $target_dir = "articles/";
      $target_file = $target_dir . basename($_FILES["articleFile"]["name"]);
      $visible = 1;

      // Checking if the article exists in record already
      $selectArticle = "SELECT* FROM article WHERE articleName='$name' AND articlePath='$target_file'";
      $resultArticle = $conn->query($selectArticle);
      $num = $resultArticle->num_rows;
      if ($num >=1 ) {
        ?>
    <script>
        document.getElementById("message").innerHTML = "Sorry, Article exists already";
        document.getElementById("message").style.color = "red";
    </script>
    <?php
        return;
      }
      
      move_uploaded_file($_FILES["articleFile"]["tmp_name"], $target_file);
      // Inserting the new article to database
      $stmt = $conn->prepare("INSERT INTO article(articleName,articlePath,tutorName,uploadedDate,visible) value (?,?,?,?,?)");
      $stmt->bind_param('sssss',$name,$target_file,$Name,$uploadedDate,$visible);
      if($stmt->execute()){
       ?>
     <script>
      alert("Article saved successfully");
     window.location.href = 'articleEntry.php'
     </script>
     <?php
      }
      else{
      ?>
    <script>
        document.getElementById("message").innerHTML = "Article not saved, Please try again.";
        document.getElementById("message").style.color = "red";
    </script>
    <?php
      }
    }
    else{
        ?>
    <script>
        document.getElementById("message").innerHTML = "Sorry, Fill in all fields.";
        document.getElementById("message").style.color = "red";
    </script>
    <?php
    } 
}

?>