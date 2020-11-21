<?php include '../_includes/header.php'; ?>
<?php 
    $course_info = "SELECT * FROM tbl_course WHERE crs_id=:crs_id";
    $course_info = DB::query($course_info, array(':crs_id'=>$_GET['course']))[0];
?> 
<input type="hidden" v-model="crs_id">
<title>Faculty - <?= $course_info['descriptitle'] ?> | SDSSU LMS</title> 
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
    <?php include '../_includes/facultynav.php' ?>


<div id="content"> 
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->   
<div class="row" >
    <div class="col-sm-12">
        <ol class="breadcrumb">
            <li>
                <button  
                    @click="tabPost()" 
                    v-bind:class="{'btn-uniqueActive': (tab=='post'), 'btn-unique': (tab!='post')}"
                    > Post
                </button>
            </li>
            <li>
                <button  
                    v-bind:class="{'btn-uniqueActive': (tab=='questionnaire'), 'btn-unique': (tab!='questionnaire')}" 
                    @click="tabQuestionnaire()"
                     > Questionnaire
                </button>
            </li>
            <li>
                <button 
                    v-bind:class="{'btn-uniqueActive': (tab=='forum'), 'btn-unique': (tab!='forum')}" 
                    @click="tabForum()"  
                    > Forums
                </button>
            </li>
            <li>
                <button 
                    v-bind:class="{'btn-uniqueActive': (tab=='student'), 'btn-unique': (tab!='student')}" 
                    @click="tabStudent()" 
                    > Students
                </button>
            </li>
        </ol>
    </div>
</div>

<template v-if="tab=='post'">
    <div class="row">  
        <div class="col-sm-12 margin-b-20">   
            <h3>Posts <button class="btn btn-primary btn-sm" @click="addPost=true"> Add + </button></h3>
        </div>
    </div> 
</template>

<!-- modal post  -->
<template v-if="addPost">  
            <div class="popup" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" @click="addPost=false"><span>&times;</span></button>
                  <h4 class="modal-title">Post</h4>
                </div>
                <div class="modal-body">    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group"> 
                                <label>Upload</label>
                                <input type="file" class="form-control" @change="handleFileUpload" ref="file" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf, video/*, image/*">
                            </div>
                        </div>
                    </div> 
                  <div class="row"> 
                      <div class="col-sm-12">
                        <div class="form-group"> 
                          <label>Title</label>
                          <input type="text" class="form-control" v-model="title">
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group"> 
                          <label for="email">Post Description</label> 
                          <textarea v-model="description" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                      </div> 
                  </div> 
                </div> 
                <!-- /. modal body  -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-sm" @click="addPost=false">Close</button>
                  <button type="button" class="btn btn-primary btn-sm" @click="save_post()">Post</button>
                </div>
                <!-- /footer  -->
                </div>
              </div>
            </div>
</template>
        <!-- /modal post  -->
<!-- ========================================================================================================== Questionnaire  -->
<template v-if="tab=='questionnaire'">
    <div class="row">  
        <div class="col-sm-12 margin-b-20">   
            <h3>Questionnaire <button class="btn btn-primary btn-sm" @click="toggleshowAddPost()"> Add + </button></h3>
        </div>
    </div> 
</template>


<template v-if="tab=='forum'">
    <div class="row">  
        <div class="col-sm-12 margin-b-20">   
            <h3>Forum <button class="btn btn-primary btn-sm" @click="toggleshowAddPost()"> Add + </button></h3>
        </div>
    </div> 
</template>


<template v-if="tab=='student'">
    <div class="row">  
        <div class="col-sm-12 margin-b-20">   
            <h3>Student <button class="btn btn-primary btn-sm" @click="toggleshowAddPost()"> Add + </button></h3>
        </div>
    </div> 
</template>



<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->  
</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   

<script>
    var app = new Vue({
        el: "#content",
        data: {
            tab: '', 
            crs_id: '<?= $_GET['course']?>',
            // tab = 'post' 
            addPost: false,
            file: '',
            title: '',
            description: ''
        },
        methods: {
            tabPost: function (){
                this.tab = 'post' 
            },
            tabQuestionnaire: function(){
                this.tab = 'questionnaire'
            },
            tabForum: function(){
                this.tab = 'forum'
            },
            tabStudent: function(){
                this.tab = 'student'
            },
            // POST 
            handleFileUpload: function(){
                this.file = this.$refs.file.files[0];
            },
            save_post: function(){ 
                let formData = new FormData(); 
                formData.append('file', this.file);
                formData.append('title', this.title);
                formData.append('description', this.description);
                formData.append('crs_id', this.crs_id);
                axios.post("../../controller/faculty/post.controller.php", formData, {  

                }).then(function(response){  
                    if(response.data = 'false'){
                        alert("Something Went Wrong.");
                    }else{
                        // alert("Success");
                    }
                });
            }


        }


    });
</script> 
<?php include '../_includes/footer.php'; ?>