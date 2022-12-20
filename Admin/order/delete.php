<?php 

require '../helpers/dbConnection.php';

$id = $_GET['id'];

$sql = "select * from order where id = $id";
$op  = mysqli_query($con,$sql);
$orderData = mysqli_fetch_assoc($op);


$sql = "delete from order where id = $id"; 
$op = mysqli_query($con,$sql);

if($op){


    $message = ["Raw Removed"];
}else{
    $message = ["Error Try Again"];
}

   $_SESSION['Message'] = $message;

   header("location: index.php"); 


?>