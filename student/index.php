<?php include 'includes/header.php'; ?>
    <title>Welcome to SDSSU CANTILAN LMS</title> 
</head>
<body> 
<!-- /==============================================================================  -->
<!-- php  -->
<?php 
    $user_info = "SELECT * FROM tbl_user where usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0]; 

?> 



<!-- / php  -->


<div class="container">
    <?php include 'includes/navigation.php'; ?>


    <div id="index">
    <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 
            <div class="row">  
                <div class="col-sm-12 margin-b-20">   
                    <h3>Enrolled Courses: <button class="btn btn-primary btn-sm">Add</button></h3>
                </div>
            </div> 
            <!-- /.row  -->

            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="text-center"> 
                            Handled Courses  
                        </h3>
                    </div> 

                    <div class="panel-footer">
                        <center>
                        <a href="course.php" class="btn btn-info">
                            View
                        </a>
                        </center>
                    </div>
                </div>
            </div>

    <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 
    </div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   

<script>
  
</script>



<?php include 'includes/footer.php'; ?>