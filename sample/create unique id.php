<?php 
$id = uniqid();
$id .= uniqid();

echo $id;

?>

 
 
 <script>
 var ID = function () {
  // Math.random should be unique because of its seeding algorithm.
  // Convert it to base 36 (numbers + letters), and grab the first 9 characters
  // after the decimal.
  return Math.random().toString(36).substr(2, 9);
 }

 console.log(ID());
  </script>