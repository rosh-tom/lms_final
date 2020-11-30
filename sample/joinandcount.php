<?php 

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "lms_final";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $sql = "SELECT tbl_questionnaire.*, COUNT(tbl_question.question) as question FROM tbl_questionnaire, tbl_question";

$sql = "SELECT tbl_questionnaire.* FROM tbl_questionnaire
UNION ALL
SELECT COUNT(tbl_question.question) FROM tbl_question WHERE tbl_questionnaire.qstnnr_id = tbl_";
// SELECT * FROM [DB01].[dbo].[myTable]
// UNION ALL
// SELECT * FROM [DB02].[dbo].[myTable]
// UNION ALL
// SELECT * FROM [DB03].[dbo].[myTable]

$statement = $conn->prepare($sql);
$statement->execute();
$data = $statement->fetchAll();

print("<pre>");
echo json_encode($data);
print("</pre>");
?>