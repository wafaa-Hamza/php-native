<?php 

require '../helpers/dbConnection.php';

$id = $_GET['id'];

$sql = "SELECT * FROM `admin` Where id = $id";
$op  = mysqli_query($con,$sql);
$adminData = mysqli_fetch_assoc($op);


$sql = "DELETE FROM `admin` WHERE id = $id"; 
$op = mysqli_query($con,$sql);

if($op){

    $message = ["Raw Removed"];
}else{
    $message = ["Error Try Again"];
}

   $_SESSION['Message'] = $message;

   header("location: index.php"); 


?>