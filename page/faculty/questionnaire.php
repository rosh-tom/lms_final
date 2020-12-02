<?php include '../_includes/header.php'; ?>
<?php 
    $course_info = "SELECT * FROM tbl_course WHERE crs_id=:crs_id";
    $course_info = DB::query($course_info, array(':crs_id'=>$_GET['course']))[0];
    if(count($course_info) == 0){
        header("location: course.php");
    }
?> 

<title>Questionnaire - <?= $course_info['descriptitle'] ?> | SDSSU LMS</title> 
 
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
    <?php include '../_includes/breadcrumbs.php'; ?>

<div id="content">  
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->   
<div class="row">  
    <div class="col-sm-12 margin-b-20">   
        <h3>Questionnaires <button class="btn btn-primary btn-sm" @click="modal_qstnnr.toggled=true"> Add + </button></h3>
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

 
<template v-for="qstnnr in questionnaires"> 
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-primary"> 
                <div class="panel-heading">  
                    <p style="margin-bottom: -5px; "> <span class="qstnnr_title">{{qstnnr.title}}</p>

                    <div class="qstnnr_manage"> 
                        <div class="dropdown">
                            <button class="btn btn-default btn-sm" @click="toggle_drpdwn(qstnnr.id)">
                                <img v-if="drpdwn.arrow == 'up' &&  drpdwn.id == qstnnr.id" src=" ../../icons/caret-up.svg" alt="" width="10px">
                                <img v-else src=" ../../icons/caret-down.svg" alt="" width="10px"> 
                            </button>
                            <div class="dropdown-content" v-if="drpdwn.toggled && drpdwn.id == qstnnr.id">
                                <a :href="'question.php?course='+crs_id+'&&questionnaire='+qstnnr.qstnnr_id" class="anchor btn btn-sm btn-default">Questions</a>
                                <button class="anchor btn btn-sm btn-default" @click="toggle_editQstnnr(qstnnr.qstnnr_id)">Edit</button>
                                <button class="anchor btn btn-sm btn-default" @click="delete_qstnnr(qstnnr.qstnnr_id, qstnnr.title)">Delete</button>
                            </div>
                        </div>
                    </div>
   
                </div> 
                <div class="panel-body"> 
                    <p class="paragraph">Instruction: {{qstnnr.descript}}</p>
                    <p class="paragraph">Type: &emsp; &emsp; {{qstnnr.types}}</p>
                    <p class="paragraph">Items: &emsp; &emsp;<a class="numberOfQuestion" @click="numberOfQuestion(qstnnr.qstnnr_id)">show created</a> / {{qstnnr.items}} Items </p>
                    <p class="paragraph">
                        Status:&emsp; &emsp;<span v-bind:class = "{'text-danger' : (qstnnr.status == 'inactive'), 'text-success': (qstnnr.status == 'active')}">{{qstnnr.status}}</span>  
                    </p> 
                    <button 
                        class="btn btn-sm"
                        v-bind:class = "{'btn-danger' : (qstnnr.status == 'inactive'), 'btn-success': (qstnnr.status == 'active')}"
                        @click="updateStatus(qstnnr.qstnnr_id)"
                        >{{(qstnnr.status == 'inactive')? 'Activate': 'Deactivate'}}
                    </button>
                </div>  
        </div>
    </div>
</template>

<template v-if="!questionnaires.length"> 
    <div class="row">
        <div class="col-sm-12">
            <h1 class="text-center">No Questionnaire Found.</h1>
        </div>
    </div>
</template>  
 



 <!-- ================================================= Modal  -->
    <!-- modal -->  
<template v-if="modal_qstnnr.toggled">
    <div class="popup" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" @click="modal_qstnnr.toggled = false"><span>&times;</span></button>
            <h4 class="modal-title">{{(modal_qstnnr.mode == 'add') ? 'Create Questionnaire' : 'Update Questionnaire'}}</h4>
        </div>
        <div class="modal-body">   
                
        <div class="row"> 
            <div class="col-sm-12">
                <div class="form-group"> 
                    <label>Title</label>
                    <input type="text" class="form-control" v-model="modal_qstnnr.title">
                </div>
            </div>
        </div> 

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group"> 
                    <label for="email">Instruction / Description</label> 
                    <textarea cols="30" rows="3" class="form-control" v-model="modal_qstnnr.description" ></textarea> 
                </div> 
            </div> 
        </div>
        
        <div class="row">
<template v-if="modal_qstnnr.mode == 'add'">
        <div class="col-sm-6">
            <div class="form-group"> 
                <label>Type</label> 
                <select v-model="modal_qstnnr.types" class="form-control">
                    <option>Multiple Choice</option>
                </select>
            </div> 
        </div>  
</template>
            
            <div class="col-sm-6">
                <div class="form-group"> 
                    <label>Items</label> 
                    <input type="number" class="form-control" v-model="modal_qstnnr.items">
                </div> 
            </div> 
        </div>
        
        <!-- /. modal body  -->
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" @click="close_ediQstnnr()">Close</button> 
            <template v-if="modal_qstnnr.mode == 'add'"> 
                <button type="button" class="btn btn-primary btn-sm" @click="save_qstnnr()">Save</button> 
            </template>
            <template v-else> 
                <button type="button" class="btn btn-primary btn-sm" @click="update_qstnnr()">Update</button> 
            </template>
        </div>
        <!-- /footer  -->
        </div>
        </div>
    </div>
</template>
        <!-- /modal  -->   
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ CONTENT  -->  
</div>
    <!-- /#index  --> 

</div>
<!-- /.container  -->   


<script>
    let url = new URL(window.location.href);
    let searchParams = new URLSearchParams(url.search); 

    var app = new Vue({
        el: '#content',
        data: {
            crs_id: searchParams.get('course'),
            questionnaires: '', 
            num: '',
            alerts: {
                'message': '',
                'type'  : '',
                'toggled': false 
            },
            drpdwn: {
                'toggled': false,
                'arrow': 'down',
                'id': ''
            },
            modal_qstnnr: {
                'toggled': false,
                'title': '',
                'description': '',
                'types': 'Multiple Choice',
                'items': '',
                'mode': 'add',
                'qstnnr_id': ''
            }
        },
        methods: {
            setDefault_modal_qsttnr: function(){
                this.modal_qstnnr.toggled = false;
                this.modal_qstnnr.title = '';
                this.modal_qstnnr.description = '';
                this.modal_qstnnr.types = 'Multiple Choice';
                this.modal_qstnnr.items = '';
                this.modal_qstnnr.mode = 'add';
                this.modal_qstnnr.qstnnr_id = '';
            },
            setDefault_drpdwn: function (){
                this.toggled = false;
                this.arrow = 'down';
                this.id = '';
            },

            setAlerts: function(message, type, toggled){
                this.alerts.message = message;
                this.alerts.type = type;
                this.alerts.toggled = toggled; 
            }, 

            toggle_drpdwn: function(id){
                this.drpdwn.toggled = !this.drpdwn.toggled;
                this.drpdwn.id = id;
                if(this.drpdwn.arrow != 'down'){
                    this.drpdwn.arrow = 'down'
                }else{
                    this.drpdwn.arrow = 'up'
                }
            },  

            save_qstnnr: function (){
                if(this.modal_qstnnr.title == '' || this.modal_qstnnr.description == '' || this.modal_qstnnr.types == '' || this.modal_qstnnr.items == ''){
                    alert("Please fill up the form");
                }else{
                        axios.post("../../controller/faculty/questionniare.controller.php", {
                            action: 'save_qstnnr',
                            title: this.modal_qstnnr.title,
                            description: this.modal_qstnnr.description,
                            types: this.modal_qstnnr.types,
                            items: this.modal_qstnnr.items,
                            crs_id: this.crs_id
                        }).then(function(response){
                            if(response.data.success){
                                app.fetchAllQstnnr();
                                app.setDefault_modal_qsttnr(); 
                                app.setAlerts("Questionnaire successfully Created!. ", "success", true);
                            }else{
                                app.setAlerts("An error occur while creating Questionnaire. Please try again later. ", "danger", true);
                            }
                        });
                }
               
            },
            fetchAllQstnnr: function(){
                axios.post("../../controller/faculty/questionniare.controller.php", {
                    action: 'fetchAllQstnnr', 
                    crs_id: this.crs_id
                }).then(function(response){
                   app.questionnaires = response.data;
                });
            },
            delete_qstnnr: function (id , title){
                if(confirm("Are you sure you want to delete questionnaire "+ title + " ?")){
                    axios.post("../../controller/faculty/questionniare.controller.php", {
                        action: 'delete_qstnnr', 
                        qstnnr_id: id
                    }).then(function(response){
                        if(response.data.success){
                            app.fetchAllQstnnr();
                            app.setDefault_modal_qsttnr();
                            app.setDefault_drpdwn();
                            app.setAlerts("Questionnaire successfully Updated! ", "success", true);
                        }else{
                            app.setAlerts("An error occur while Deleting the Questionnaire. Please try again later. ", "danger", true);
                        }
                    });
                } 
            }, 

            toggle_editQstnnr: function (id){  
                this.toggle_drpdwn(id); 
                this.modal_qstnnr.mode = 'edit';
                this.modal_qstnnr.toggled = true;  
                this.modal_qstnnr.qstnnr_id = (id);
                // this.modal_qstnnr.title = "Hello";
                // this.modal_qstnnr.description = 'Description';
                axios.post("../../controller/faculty/questionniare.controller.php", {
                        action: 'fetchSingle', 
                        qstnnr_id: id
                    }).then(function(response){
                        app.modal_qstnnr.title = response.data.title;
                        app.modal_qstnnr.description = response.data.descript;
                        app.modal_qstnnr.items = response.data.items;
                    });
            },
            update_qstnnr: function (){
                if(this.modal_qstnnr.title == '' || this.modal_qstnnr.description == '' || this.modal_qstnnr.types == '' || this.modal_qstnnr.items == ''){
                    alert("Please fill up the form");
                }else{
                        axios.post("../../controller/faculty/questionniare.controller.php", {
                            action: 'update_qstnnr',
                            title: this.modal_qstnnr.title,
                            description: this.modal_qstnnr.description,
                            types: this.modal_qstnnr.types,
                            items: this.modal_qstnnr.items,
                            qstnnr_id: this.modal_qstnnr.qstnnr_id
                        }).then(function(response){
                            if(response.data.success){
                                app.fetchAllQstnnr();
                                app.setDefault_modal_qsttnr(); 
                                app.setAlerts("Questionnaire successfully Created!. ", "success", true);
                            }else{
                                app.setAlerts("An error occur while creating Questionnaire. Please try again later. ", "danger", true);
                            }
                        });
                }
            },
            updateStatus: function(id){
                axios.post("../../controller/faculty/questionniare.controller.php", {
                            action: 'updateStatus', 
                            qstnnr_id: id
                        }).then(function(response){
                            if(response.data.success){
                                app.fetchAllQstnnr();
                                app.setDefault_modal_qsttnr();  
                            }else{
                                app.setAlerts("An error occur. Please try again later. ", "danger", true);
                                
                            }
                        });
            },

            close_ediQstnnr: function(){
                this.setDefault_modal_qsttnr(); 
            },

            numberOfQuestion: function(id){
                axios.post("../../controller/faculty/questionniare.controller.php", {
                        action: 'getnumQuestion', 
                        qstnnr_id: id
                    }).then(function(response){
                       alert("Question Created: "+ response.data );
                    });
            }

        },
        created: function(){
            this.fetchAllQstnnr(); 
        }
    });
</script>
 
<?php include '../_includes/footer.php'; ?>