<?php 

include 'db.php';

$tablename = "tbl_questionnaire";

$result = "create table ". $tablename ." (
    qstnnr_id int(11) unsigned auto_increment primary key,
    qstnnr_title varchar(255),
    qstnnr_description varchar(255),
    qstnnr_type varchar(100),
    qstnnr_item varchar(5), 
    usr_id int(11),
    crs_id int(11), 
    active varchar(2),
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
)";

$result = DB::query($result); 
echo print_r($result); 

?>