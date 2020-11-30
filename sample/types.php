

        
<?php if($post['types'] == 'video'){ ?>
                <div class="panel-body">
                    <center>
                        <video width="80%"controls>
                                <source src="../<?= $post['locale'] ?>" type="video/mp4">
                        </video>
                    </center>
                </div>
<?php } ?>

<?php if($post['types'] == 'application'){ ?>
                <div class="panel-body">
                    <center><h4>Document</h4></center>
                <h3><a href="../<?= $post['locate'] ?>"><img src="../icons/document.svg" alt="" width="10%"></a><?= $Post['namefile'] ?></h3>
                </div>
<?php } ?>

<?php if($post['types'] == 'image'){ ?>
                <div class="panel-body"> 
                    <center>
                        <img src="../../<?= $post['locale'] ?>" width="50%" alt=""> 
                    </center>
                </div>
<?php } ?>


<button class="btn btn-warning btn-sm"  @click="remove_filePost(post.pst_id, post.title)">Remove File</button> 
                <button class="btn btn-info btn-sm">Change File</button>
            
           
                <button class="btn btn-info btn-sm" @click="toggle_openAddFile(post.pst_id, post.title)">Add File</button>