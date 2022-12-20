<?php

  require './Admin/helpers/dbConnection.php';
  require './Admin/helpers/functions.php';




  if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name =  Clean($_POST['name']);
    $email = Clean($_POST['email']);
    $password = Clean($_POST['password'] ,1);
    $phone = Clean($_POST['phone']);
    $address =  Clean($_POST['address']);



    $errors = [];

    # Validate Name ... 
    if (!validate($name, 1)) {
        $errors['Name'] = " Name Required";
    }

    # Validate Email .... 
    if (!validate($email, 1)) {
        $errors['Email'] = " Email Required";
    } elseif (!validate($email, 2)) {
        $errors['Email'] = " Email Invalid Field";
    }

    # Validate Password 
    if (!validate($password, 1)) {
        $errors['Password'] = " Password Required";
    } elseif (!validate($password, 3)) {
        $errors['Password'] = " Password Length Must be >= 6 Chars";
    }


    # Validate Phone .... 
    if (!validate($phone, 1)) {
        $errors['Phone'] = " Phone Required";
  }

    # Validate Address .... 
    if (!validate($address, 1)) {
        $errors['address'] = " address Required";
  }


  if(count($errors) > 0){
      $_SESSION['Message'] = $errors;
  }else{

    $password = md5($password);
    $sql = "INSERT INTO `customer`(`name`, `email`, `password`, `phone`, `address`) VALUES ('$name','$email','$password','$phone','$address')";
    $op = mysqli_query($con , $sql);

    if ($op) {
        $message = ["Raw Inserted"];
    } else {
        $message = ["Error Try Again"];
    }

    $_SESSION['Message'] = $message;
   }
  }


?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap Simple Login Form</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
<style>
	.login-form {
		width: 340px;
    	margin: 50px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }
</style>
</head>
<body>
<div class="login-form">
    <form action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <h2 class="text-center">ٌRegister</h2>       
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter Name"  name = "name" required="required">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter Email" name = "email" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name = "password" required="required">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter Phone" name = "phone" required="required">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter Address" name = "address" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
           
    </form>

</div>
</body>
</html> 