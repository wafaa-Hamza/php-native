<?php

require '../helpers/dbConnection.php';
require '../helpers/functions.php';

$sql = "select * from admin";
$adminOp  = mysqli_query($con, $sql);


 if($_SERVER['REQUEST_METHOD'] == "POST"){
  
    $name     = Clean($_POST['name']);
    $admin_id = Clean($_POST['admin_id']);

    
    $errors = [];

    # Validate Name ... 
    if (!validate($name, 1)) {
        $errors['Name'] = " Name Required";
    }

    # Validate Admin_id  ... 
    if (!validate($admin_id, 1)) {
        $errors['Admin'] = " Admin Required";
    } elseif (!validate($admin_id, 4)) {
        $errors['Admin'] = " Admin Invalid";
    }
     

    # Validate Image ... 
    if (!validate($_FILES['image']['name'], 1)) {
        $errors['Image']  = "Image Required";
    } elseif (!validate($_FILES['image']['name'], 5)) {
        $errors['Image']  = "Image : Invalid Extension";
    }

   # Check Errors 
   if (count($errors) > 0) {
    $_SESSION['Message'] = $errors;
     } else {

    $image = uploadFile($_FILES);

    if (empty($image) ) {
        $_SESSION['Message'] = ["Error In Uploading File Try Again"];
    } else {

        $sql = "INSERT INTO `category`( `name`, `image`, `admin_id`) VALUES ('$name','$image',$admin_id)";
        $op  = mysqli_query($con, $sql);

        if ($op) {
            $message = ["Raw Inserted"];
        } else {
            $message = ["Error Try Again"];
        }

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
        <h1 class="mt-4">Categories</h1>
        <ol class="breadcrumb mb-4">
            

          
            <?php 
           
               displayMessage('Dashboard/Add Category');

            ?>



        </ol>



        <div class="container">


            <form action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                    <label for="exampleInputName">Name</label>
                    <input type="text" class="form-control" id="exampleInputName" aria-describedby="" name="name" placeholder="Enter Name">
                </div>


                <div class="form-group">
                    <label for="exampleInputPassword">Admin Type</label>
                    <select class="form-control" name="admin_id">

                        <?php
                        while ($Admin_data = mysqli_fetch_assoc($adminOp)) {
                        ?>

                            <option value="<?php echo $Admin_data['id']; ?>"><?php echo $Admin_data['name']; ?></option>


                        <?php }  ?>

                    </select>
                </div>
                

                <div class="form-group">
                    <label for="exampleInputPassword">Image</label>
                    <input type="file" name="image">
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>




    </div>
</main>


<?php

require '../layouts/footer.php';

?>