<?php 
$server = 'localhost';
$user= 'root';
$password= '';
$dbname = 'nutritioncoach';

$con = new mysqli($server,$user,$password,$dbname);

if (mysqli_connect_errno()) {
   echo "Error Connecting to MYSQL" . mysqli_connect_error();
}
?>