<?php include '../_includes/header.php'; ?> 
<title>Faculty Courses - SDSSU CANTILAN LMS</title> 
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
    <?php include '../_includes/navigation.php'; ?>


    <div id="">

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 
<a href="index.php" class="btn btn-info btn-sm"><b><</b> Back</a>

    <div class="row">  
        <div class="col-sm-12 margin-b-20">   
            <h3>Enrolled Courses: <button class="btn btn-primary btn-sm">Add</button></h3>
        </div>
    </div>
    <!-- /.row   -->


    <div class="row"> 
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-body">
                    <h3 class="text-center"> 
                    Handled Courses  
                    </h3>
                </div> 

                <div class="panel-footer">
                    <center>
                    <a href="course.php" class="btn btn-success ">
                    Manage Course
                    </a>
                    </center>
                </div>
            </div>
        </div>
    </div>
<!-- /.row  -->




<!-- modal  -->
<form action="controller/course.controller.php" method="post">
          z
            <div class="popup" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" @click="toggleShowAddNewCourse()"><span>&times;</span></button>
                  <h4 class="modal-title">Add New Course</h4>
                </div>
                <div class="modal-body">  
                  <div class="row"> 
                      <div class="col-sm-6">
                        <div class="form-group"> 
                          <label>Course Number</label>
                          <input type="text" class="form-control" name="crs_number">
                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="form-group"> 
                          <label>Course Section</label>
                          <input type="text" class="form-control" name="crs_section">
                        </div>
                      </div> 
                  </div>

                    <div class="row"> 
                        <div class="col-sm-12">
                          <div class="form-group"> 
                            <label>Descriptive Title</label>
                            <input type="text" class="form-control" name="crs_descriptitle">
                          </div>
                        </div> 
                    </div>

                    <div class="row"> 
                        <div class="col-sm-6">
                          <div class="form-group"> 
                            <label>Time (from - to)</label> 
                                <div class="row">
                                    <div class="col-sm-6">  
                                        <input type="time" class="form-control" name="crs_time">
                                    </div>
                                   
                                      
                                    <div class="col-sm-6">  
                                        <input type="time" class="form-control" name="crs_time">
                                    </div>
                                </div> 
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="form-group"> 
                            <label>Days</label>
                                <select name="" class="form-control">
                                    <option>MWF</option>
                                </select>
                          </div>
                        </div> 
                    </div> 
                </div> 
                <!-- /. modal body  -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" @click="toggleShowAddNewCourse()">Close</button>
                    <input type="submit" class="btn btn-primary btn-sm" name="btn_saveCourse" value="Save">
                    </div> 
                
                <!-- /footer  -->
                </div>
              </div>
            </div> 
          <!-- /end add modal  -->
          </form> 
<!-- /.modal  -->
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  --> 
    
</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   

<script>
  
</script> 
<?php include '../_includes/footer.php'; ?>