<?php include '../_includes/header.php'; ?>
<?php 
    $course_info = "SELECT * FROM tbl_course WHERE crs_id=:crs_id";
    $course_info = DB::query($course_info, array(':crs_id'=>$_GET['course']))[0]; 


    if(count($course_info) == 0){
        header("location: course.php");
    }

    $user_info = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0]; 
 
?> 

<title>Questionnaire - <?= $course_info['descriptitle'] ?> | SDSSU LMS</title> 
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
            <h4>Questionnaire</h4>
        </div>
    </div> 

    <?php  

    $fclty_id = "SELECT usr_id FROM tbl_course WHERE crs_id=:crs_id";
    $fclty_id = DB::query($fclty_id, array(':crs_id'=>$_GET['course']))[0]['usr_id'];

    $questionnaires = "SELECT * FROM tbl_questionnaire WHERE usr_id=:fclty_id and crs_id=:crs_id and active = '1' ORDER BY created_at DESC";
    $questionnairesData = [
        'fclty_id'  => $fclty_id,
        'crs_id'    => $_GET['course']
    ];
    $questionnaires = DB::query($questionnaires, $questionnairesData);
    
    if(count($questionnaires) == 0){
        echo "No Questionnaire Available";
    }else{ 
        foreach($questionnaires as $questionnaire){ 
?> 
    <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default"> 
                    <div class="panel-heading">  
                        <p style="margin-bottom: -5px; "> <span class="qstnnr_title"><?= $questionnaire['title']?></p> 
                    </div> 

                    <div class="panel-body"> 
                        <p> - <?= $questionnaire['descript']?></p>
                        <p> - <?= $questionnaire['types']?></p> 
                    </div>
<?php 
    $studentProgress = "SELECT * FROM tbl_answer WHERE qstnnr_id = :qstnnr_id";
    $studentProgress = DB::query($studentProgress, array('qstnnr_id'=>$questionnaire['qstnnr_id']));
    $studentProgress = count($studentProgress);

    $questionItems = "SELECT * FROM tbl_question WHERE qstnnr_id=:qstnnr_id and usr_id=:faculty";
    $questionItems = DB::query($questionItems, array('qstnnr_id'=>$questionnaire['qstnnr_id'], 'faculty'=>$questionnaire['usr_id']));
    $questionItems = count($questionItems);

    $checkIfAnswered = "SELECT * FROM tbl_score WHERE qstnnr_id=:qstnnr_id and usr_id=:usr_id";
    $checkIfAnswered = DB::query($checkIfAnswered, array('qstnnr_id'=>$questionnaire['qstnnr_id'], 'usr_id'=>$_SESSION['loggedID'])); 
    $checkIfAnswered = count($checkIfAnswered);
    
?>
                    <div class="panel-footer"> 
        <?php  if($checkIfAnswered == 0){ ?>
                <?php if($questionItems > 0){ ?>
                            <a href="take.php?course=<?= $_GET['course']?>&&questionnaire=<?= $questionnaire['qstnnr_id'] ?>" class="btn btn-primary">
                                <?= ($studentProgress == $questionItems)? 'View and Submit': 'Take'?>
                            </a>
                <?php } ?>
        <?php }else{ ?>
                            <a class="btn btn-success" @click="showScore('<?= $questionnaire['qstnnr_id'] ?>')">
                                Show Score
                            </a>
        <?php } ?>
                        <span style="margin-left: 20px;">Progress: <?= $studentProgress ?> / <?= $questionItems ?> items</span>
                        <span style="float: right; margin-top: 5px;"><?= $questionnaire['created_at'] ?></span>
                    </div>  
                </div>  
            </div>
        </div>

<?php  }   } ?>
   


<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->  
</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   

<script>
      var app = new Vue({
          el: "#content",
          methods: {
            showScore: function(id){
                axios.post("../../controller/students/questionnaire.controller.php", {
                    action: 'showScore',
                    qstnnr_id: id
                }).then(function(response){
                    alert(response.data);
                });
            }
          }
      });
  
</script>

 
<?php include '../_includes/footer.php'; ?>
