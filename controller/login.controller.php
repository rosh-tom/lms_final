<?php session_start();

include '../classes/db.php';


if(isset($_POST['btn_signin'])){
    $data = [
        'email'  => $_POST['email'],
        'pass'  => $_POST['pass'] 
    ];
    
    $result = "SELECT * FROM tbl_user where email = :email";
    $result = DB::query($result, array(':email'=>$data['email']));

   if(count($result) > 0){
       if(password_verify($data['pass'], $result[0]['pass'])){
            $userType = $result[0]['types'];
            if($userType == 'Faculty'){
                $_SESSION['loggedType'] = $userType;
                $_SESSION['loggedID'] = $result[0]['usr_id']; 
                header("location: ../page/faculty/index.php");
            }
            elseif($userType == 'Student'){
                $_SESSION['loggedType'] = $userType;
                $_SESSION['loggedID'] = $result[0]['usr_id']; 
                header("location: ../page/student/index.php");
            }elseif($userType == 'Admin'){
                $_SESSION['loggedType'] = $userType;
                $_SESSION['loggedID'] = $result[0]['usr_id']; 
                header("location: ../page/admin/index.php");
            }
 
       }else{
           $data['message'] = "Password did not match the email"; 
           unset($data['password']);
           $_SESSION['temp'] = $data;
           header("location: ../login.php");
       }
   }else{
        unset($data);
        $data['message'] = "Email not found in our database"; 
        $_SESSION['temp'] = $data;
        header("location: ../login.php");
   }
}   

?>