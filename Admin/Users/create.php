<?php

require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidnav.php';



$sql = "SELECT * FROM `admin`";
$adminOp = mysqli_query($con , $sql);


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name     = Clean($_POST['name']);
    $email    = Clean($_POST['email']);
    $password = Clean($_POST['password']);

    $errors = [];

    # Validate Name .... 
    if (!validate($name, 1)) {
        $errors['Name'] = " Title Required";
    }

    # Validate Email .... 
    if (!validate($email, 1)) {
        $errors['Email'] = " Email Required";
    } elseif (!validate($email, 2)) {
        $errors['Email'] = " Email Invalid Field";
    }

    # Validate password .... 
    if (!validate($password, 1)) {
        $errors['Password'] = " Password Required";
    } elseif (!validate($password , 3)) {
        $errors['Password'] = " Password Length Must be >= 10 Chars";
    }


    # Check Errors ... 
    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    } else{
        $password = md5($password);
        $sql = "INSERT INTO `admin`(`name`, `email`, `password`) VALUES ('$name','$email','$password')" ;
        $op = mysqli_query($con , $sql);

        if($op){
            $message = ["Row Inserted"];
        }else{
            $message = ["Error Try Again"];
        }

        $_SESSION['Message'] = $message;
    }

}
?>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Admin</h1>
        <ol class="breadcrumb mb-4">



            <?php

              displayMessage('Dashboard/Add Admin');

            ?>



        </ol>



        <div class="container">


            <form action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <div class="form-group">
                    <label for="exampleInputName">Name</label>
                    <input type="text" class="form-control" id="exampleInputName" aria-describedby="" name="name" placeholder="Enter Name">
                </div>



                <div class="form-group">
                    <label for="exampleInputEmail">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword"> Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>




    </div>
</main>
                

                <?php
                
                require '../layouts/footer.php';
                ?>