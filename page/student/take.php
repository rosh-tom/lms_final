<?php include '../_includes/header.php'; ?>
<?php 
    $course_info = "SELECT * FROM tbl_course WHERE crs_id=:crs_id";
    $course_info = DB::query($course_info, array(':crs_id'=>$_GET['course']))[0]; 

    $questionnaire_info = "SELECT * FROM tbl_questionnaire WHERE qstnnr_id=:qstnnr_id";
    $questionnaire_info = DB::query($questionnaire_info, array(':qstnnr_id'=>$_GET['questionnaire']))[0]; 

    if(count($course_info) == 0 || count($questionnaire_info) == 0){
        header("location: index.php");
    }

    $user_info = "SELECT * FROM tbl_user WHERE usr_id=:usr_id";
    $user_info = DB::query($user_info, array(':usr_id'=>$_SESSION['loggedID']))[0];  
?> 

<title>View Post - <?= $course_info['descriptitle'] ?> | SDSSU LMS</title>  
</head>
<body> 

<div class="container">
    <?php include '../_includes/navigation.php'; ?> 
    <a href="questionnaire.php?course=<?= $_GET['course'] ?>" class="btn btn-info btn-sm"><b><</b> Back</a> 
    <br><br>
    <hr>

<div id="content">  
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->    
<div class="row">  
        <div class="col-sm-12">   
            <label for=""><?= $questionnaire_info['title'] ?></label>
            <p class="paragraph"><b>Instruction: </b> <?= $questionnaire_info['descript'] ?></p>
        </div>
    </div>
<?php 
    $questions = "SELECT * FROM tbl_question WHERE crs_id=:crs_id and qstnnr_id=:qstnnr_id";
    $questionsData = [
        'crs_id'=> $_GET['course'],
        'qstnnr_id'=> $_GET['questionnaire']
    ];
    $questions = DB::query($questions, $questionsData);

    $row = count($questions);
    $itemNumber = 1;
?>
    <div class="row">  
        <div class="col-sm-12 margin-b-20">   
            <h3>Questions</h3>
        </div>
    </div>
 
<?php foreach($questions as $question){ ?>
    <div class="row">  
        <div class="col-sm-12">  
            <div class="well well-sm">
                <p> <?= $itemNumber++ ?>. <?= $question['question'] ?> </p> 
<?php 
    $recoverAnswer = "SELECT answer FROM tbl_answer where qstn_id=:qstn_id AND usr_id=:usr_id";
    $recoverAnswer = DB::query($recoverAnswer, array(':qstn_id'=>$question['qstn_id'], ':usr_id'=>$user_info['usr_id'])); 
    if(count($recoverAnswer) > 0){ 
        $countRecoverAnswer = 1;
        $recoverAnswer = $recoverAnswer[0]['answer'];
    }else{
        $countRecoverAnswer = 0; 
    }
?>

                <div style="margin-left: 10px;">
                    <div class="radio">
                        <label>
                            <input 
                                type="radio" 
                                name="<?= $question['qstn_id'] ?>"
                                @click="choose('<?= $question['qstn_id'] ?>', 'a')"
                            <?php if($countRecoverAnswer > 0){ ?>
                                    <?= ($recoverAnswer == 'a')? 'checked':'' ?>
                            <?php } ?>
                                >A. <?= $question['a'] ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio"
                            name="<?= $question['qstn_id'] ?>"
                            @click="choose('<?= $question['qstn_id'] ?>', 'b')"
                        <?php if($countRecoverAnswer > 0){ ?>
                            <?= ($recoverAnswer == 'b')? 'checked':'' ?>
                        <?php } ?>
                            >B. <?= $question['b'] ?> 
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" 
                            name="<?= $question['qstn_id'] ?>" 
                            @click="choose('<?= $question['qstn_id'] ?>', 'c')"
                        <?php if($countRecoverAnswer > 0){ ?>
                            <?= ($recoverAnswer == 'c')? 'checked':'' ?>
                        <?php } ?>
                            >C. <?= $question['c'] ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" 
                            name="<?= $question['qstn_id'] ?>" 
                            @click="choose('<?= $question['qstn_id'] ?>', 'd')"
                        <?php if($countRecoverAnswer > 0){ ?>
                            <?= ($recoverAnswer == 'd')? 'checked':'' ?>
                        <?php } ?>
                            >D. <?= $question['d'] ?>
                        </label>
                    </div> 
                </div> 
                <!-- /radio  -->
            </div>
        </div> 
    </div> 
<?php } ?>
   
<div class="row">
    <div class="col-sm-12">
        <div class="well well-sm">
            <button 
                class ="btn btn-primary"
                @click ="submitQuestionnaire()"
                >Submit</button>
        </div>
    </div>
</div>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->  
</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   

<script>
 
    
    var app = new Vue({
       el: "#content",
       data: { 

       },
       methods: {
        choose: function (id, answer){
                axios.post("../../controller/students/take.controller.php", {
                    action: 'choose',
                    qstn_id: id,
                    std_answer: answer,
                    qstnnr_id: '<?= $_GET['questionnaire']?>',
                    crs_id: '<?= $_GET['course']?>'
                }).then(function(response){
                   
                });
            },
            submitQuestionnaire: function(){
                axios.post("../../controller/students/take.controller.php",{
                    action: 'submitQuestionnaire',
                    crs_id: '<?= $_GET['course'] ?>',
                    qstnnr_id: '<?= $_GET['questionnaire'] ?>'
                }).then(function(response){
                    if(!response.data){ 
                        alert("Please answer all the items");
                    }else{ 
                        window.location.replace("questionnaire.php?course=<?= $_GET['course'] ?>");
                    }
                });
            },
           

       }
    });
 
  
</script>

 
<?php include '../_includes/footer.php'; ?>