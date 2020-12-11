<?php include '../_includes/header.php'; ?>
<?php 
    $crs_id = $_GET['course'];
    $course_info = "SELECT * FROM tbl_course WHERE crs_id=:crs_id";
    $course_info = DB::query($course_info, array(':crs_id'=>$crs_id ))[0]; 


    if(count($course_info) == 0){
        header("location: course.php");
    }

    $user_info = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0]; 

    $studentcourse = "SELECT * FROM tbl_studentcourse WHERE crs_id=:crs_id";
    $studentcourse_data = [
        'crs_id'  => $crs_id
    ];
    $studentcourse = DB::query($studentcourse, $studentcourse_data);  
 
?> 

<title>Students - <?= $course_info['descriptitle'] ?> | SDSSU LMS</title> 
</head>
<body> 

<div class="container">
    <?php include '../_includes/navigation.php'; ?> 
    <?php include '../_includes/studentnav.php' ?>
    <?php include '../_includes/breadcrumbs.php'; ?>

<div id="content">  
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->   
    <div class="row">  
        <div class="col-sm-12 margin-b-20">   
            <h4>Classmates</h4>
        </div>
    </div>  

    <template v-if="alerts.toggled">
    <div class="row">
        <div class="col-sm-12">
            <div 
                class="alert"
                v-bind:class="{'alert-danger': (alerts.type == 'error'), 'alert-success': (alerts.type == 'success')}"
                >
                <a class="close" @click="alerts.toggled=false">&times;</a>
                <strong>{{(alerts.type == 'success')? 'Success: ': 'Error: '}} </strong> {{ alerts.message }}
            </div>
        </div> 
    </div>
    <!-- /.row  --> 
</template> 

    <?php 
        foreach($studentcourse as $stdCourse){
            $classmates = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
            $classmates_data = [
                'usr_id'  => $stdCourse['usr_id']
            ];

            $classmates = DB::query($classmates, $classmates_data)[0]; 
    
    ?>
    <div class="row">
        <div class="col-sm-4">
            <img src="../../<?= $classmates['profilepic'] ?>" alt="Prifile Pic" class="cmmnt-pp">
             <label>
                <?= $classmates['firstname'] ?> 
                <?= $classmates['middlename'] ?> 
                <?= $classmates['lastname'] ?>   
            </label>
        </div>
        <div class="col-sm-4">
            <button 
                class="btn btn-danger btn-sm" 
                @click="remove_student('<?= $classmates['usr_id'] ?>', '<?= $classmates['firstname']." ". $classmates['lastname'] ?>')"
                >Remove
            </button>
        </div>
    </div>  
    <hr>   
<?php } ?>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->  
</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   
<br>
<script>
      var app = new Vue({
          el: "#content",
          data: {
            alerts: {
                'message': '',
                'type'  : '',
                'toggled': false 
            },
          },
          methods: {
            setAlerts: function(message, type, toggled){
                this.alerts.message = message;
                this.alerts.type = type;
                this.alerts.toggled = toggled; 
            }, 

            remove_student: function(id, fullname){
                if(confirm("Are you sure you want to remove "+ fullname)){
                    axios.post("../../controller/faculty/student.controller.php", {
                        action: 'remove_student',
                        usr_id: id
                    }).then(function(response){
                        if(response.data.success){
                            location.reload();
                        }else{
                            app.setAlerts("Something went wrong. Please try again later. ", "error", true); 
                        }
                    });
                }
            }
          }
      });
  
</script>

 
<?php include '../_includes/footer.php'; ?>
