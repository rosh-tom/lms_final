<?php include 'includes/header.php'; ?>
        <title>Login to SDSSU CANTILAN LMS</title> 
    </head>
    <body>
        <div id="index">
            <div class="container">
<?php include 'includes/navigation.php'; ?>
 
            <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ content  -->
<form class="form-signin" action=" " method="post" autocomplete=" " >
                <h2 class="form-signin-heading text-center">Recovery</h2>
                <br>
                <h4 class="text-center">Enter Your Email</h4> 


                <input 
                type="email" 
                class="form-control" 
                placeholder="Email Address" 
                required  
                name = "email"  
                <?= (isset($_SESSION['temp']['email'])) ? "value='". $_SESSION['temp']['email'] ."'" : 'autofocus' ?> 
                />  

      
                <button class="btn btn-lg btn-info btn-block last" type="submit" name="">Recover</button>

                <br>  
                <br>
                <br>
                <a href="login.php" class="deco-none text-center text-success"><h4>Log in</h4></a>
                <hr>
                <a href="create.php" class="deco-none text-center"><h4>Create Student Account?</h4></a>
            </form> 
            <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++ /content  -->
            </div>
            <!-- /.container  -->   
        </div>
        <!-- /#index  --> 
<br><br>
<?php include 'includes/footer.php'; ?>
