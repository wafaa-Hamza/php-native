<?php 

require '../helpers/dbConnection.php';

$id = $_GET['id'];

$sql = "select image from category where id = $id";
$op  = mysqli_query($con,$sql);
$catData = mysqli_fetch_assoc($op);


$sql = "delete from category where id = $id"; 
$op = mysqli_query($con,$sql);

if($op){

     unlink('./uploads/'.$catData['image']);

    $message = ["Raw Removed"];
}else{
    $message = ["Error Try Again"];
}

   $_SESSION['Message'] = $message;

   header("location: index.php"); 


?>