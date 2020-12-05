<?php include '../_includes/header.php'; 

    $faculty = "SELECT * FROM tbl_user WHERE types='Faculty'";
    $faculty = DB::query($faculty); 
    $number_of_faculty = count($faculty);

    $student = "SELECT * FROM tbl_user WHERE types='Student'";
    $student = DB::query($student);
    $number_of_student = count($student);


?>  

<title>Narrow Jumbotron Template for Bootstrap</title> 
</head>

  <body>

    <div class="container admin">
    <?php include '../_includes/navigation.php'; ?>  
    <?php include '../_includes/admin_navigation.php';  ?>
    
      <div class="row text-center"> 
        <div class="col-sm-6" style="position: static">
          <div class="well">
          <img src="../../icons/avatar_faculty.svg" style="width: 100px; height: 100px !important;">
          <h2>Faculty</h2> 
          <p class="lead"><span class="label label-default"><?= $number_of_faculty ?></span></p>
          
          <p><a class="btn btn-lg btn-success" href="faculty.php" role="button">View Faculties</a></p>
          </div>
        </div>

        <div class="col-sm-6" style="position: static">
        <div class="well">
          <img src="../../icons/student.svg" style="width: 100px; height: 100px !important;">
          <h2>Student</h2> 
          <p class="lead"><span class="label label-default"><?= $number_of_student ?></span></p>
          <p><a class="btn btn-lg btn-success" href="student.php" role="button">View Students</a></p>
          </div>
        </div> 
      </div>
      <!-- /row  -->
     

      <div class="row">
        <div class="col-lg-12" style="position: static">
            <h3 class="sub-header">Announcement <button class="btn btn-primary">Add</button></h3>
      </div> 
    </div> <!-- /container -->
 
  

  
<?php include '../_includes/footer.php'; ?>