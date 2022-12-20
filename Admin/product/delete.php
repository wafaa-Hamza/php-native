<?php 

require '../helpers/dbConnection.php';

$id = $_GET['id'];

$sql = "select image from product where id = $id";
$op  = mysqli_query($con,$sql);
$productData = mysqli_fetch_assoc($op);


$sql = "delete from product where id = $id"; 
$op = mysqli_query($con,$sql);

if($op){

     # Remove Image Of User 
     unlink('./uploads/'.$productData['image']);

    $message = ["Raw Removed"];
}else{
    $message = ["Error Try Again"];
}

   $_SESSION['Message'] = $message;

   header("location: index.php"); 


?>