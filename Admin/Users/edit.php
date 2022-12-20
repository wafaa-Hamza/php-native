<?php

require '../helpers/dbConnection.php';
require '../helpers/functions.php';

$id = $_GET['id'];
$sql = "SELECT * FROM `admin` Where id = $id";
$op  = mysqli_query($con,$sql);
$adminData = mysqli_fetch_assoc($op);


if ($_SERVER['REQUEST_METHOD'] == "POST") {


    $name   = Clean($_POST['name']);
    $email  = Clean($_POST['email']);


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


    # Check Errors 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {
        $sql = "UPDATE `admin` SET `name`='$name',`email`='$email' WHERE  id = $id";
        $op  = mysqli_query($con, $sql);

        if ($op) {
            $message = ["Raw Updated"];
            $_SESSION['Message'] = $message;

            header("Location: index.php");
            exit();
        } else {
            $message = ["Error Try Again"];
            $_SESSION['Message'] = $message;
        }
    }
}


require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';

?>




<main>
    <div class="container-fluid">
        <h1 class="mt-4">Admin</h1>
        <ol class="breadcrumb mb-4">



            <?php

            displayMessage('Dashboard/Edit Admin');
            ?>



        </ol>



        <div class="container">


            <form action="edit.php?id=<?php echo  $adminData['id']; ?>" method="post">

                <div class="form-group">
                    <label for="exampleInputName">Name</label>
                    <input type="name" class="form-control" id="exampleInputName" aria-describedby="" name="name" value="<?php echo $adminData['name'] ?>" placeholder="Enter Name">
                </div>



                <div class="form-group">
                    <label for="exampleInputEmail">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="<?php echo $adminData['email'] ?>" placeholder="Enter email">
                </div>

                <br>

                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
        </div>




    </div>
</main>


<?php

require '../layouts/footer.php';

?>