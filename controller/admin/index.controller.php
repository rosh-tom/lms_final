<?php 
    session_start();

    include '../../classes/db.php';
    $received_data = json_decode(file_get_contents("php://input"));

    if($received_data->action == 'saveFaculty'){  
        $data = [
            'usr_id'    => uniqid(),
            'std_id'    => $received_data->id, 
            'firstname' => $received_data->firstname,
            'middlename'=> $received_data->middlename,
            'lastname'  => $received_data->lastname,
            'email'     => $received_data->email,
            'pass'      => password_hash($received_data->password, PASSWORD_DEFAULT),
            'profilepic'=> 'icons/user.svg', 
            'department'=> $received_data->department,
            'types'      => $received_data->type
        ];  
        $result = "INSERT INTO tbl_user(usr_id, std_id, firstname, middlename, lastname, email, pass, profilepic, department, types) VALUES(
            :usr_id, :std_id, :firstname, :middlename, :lastname, :email, :pass, :profilepic, :department, :types
        )";
        $result = DB::query($result, $data);
        unset($data);
        if($result){ 
            $data = [
                'success'   => true, 
            ];
        }else{
            // $hello = $result;
            $data = [
                'success'   => false, 
            ];
        } 
        echo json_encode($data);
    }

?>