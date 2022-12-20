<?php

require '../helpers/dbConnection.php';
require '../helpers/functions.php';

// Fetch data .... 
$id = $_GET['id'];
$sql = "select * from category where id = $id";
$op = mysqli_query($con, $sql);
$categoryData = mysqli_fetch_assoc($op);


$sql = "select * from admin";
$admin_op  = mysqli_query($con, $sql);



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name     = Clean($_POST['name']);
    $admin_id  = Clean($_POST['admin_id']);

    # Validate Input ... 

    $errors = [];
    # Validate Name ... 
    if (!validate($name, 1)) {
        $errors['Name'] = " Name Required";
    }


    # Validate admin_id  ... 
    if (!validate($admin_id, 1)) {
        $errors['Admin'] = " Admin Required";
    } elseif (!validate($admin_id, 4)) {
        $errors['Admin'] = " Admin Invalid";
    }

    #Validate Image ... 
    if (!validate($_FILES['image']['name'], 1)) {
        $errors['Image']  = "Image Required";
    } elseif (!validate($_FILES['image']['name'], 5)) {
        $errors['Image']  = "Image : Invalid Extension";
    }


    # Check Errors 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else { 

        if (validate($_FILES['image']['name'], 1)) {

            $image = uploadFile($_FILES);

            if (!empty($image)) {
                unlink('./uploads/' . $categoryData['image']);
            }
        } else {
            $image = $categoryData['image'];
        }




        $sql = "update category  set name =  '$name' , admin_id = $admin_id , image = '$image' where id = $id";
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
        <h1 class="mt-4">category</h1>
        <ol class="breadcrumb mb-4">  </ol>


        <div class="container">


            <form action="edit.php?id=<?php echo  $categoryData['id']; ?>" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="exampleInputName">Name</label>
                    <input type="text" class="form-control" id="exampleInputName" aria-describedby="" name="name" value="<?php echo $categoryData['name'] ?>" placeholder="Enter Name">
                </div>


                <div class="form-group">
                    <label for="exampleInputPassword">Admin Type</label>
                    <select class="form-control" name="admin_id">

                        <?php
                        while ($admin_data = mysqli_fetch_assoc($admin_op)) {
                        ?>

                            <option value="<?php echo $admin_data['id']; ?>" <?php if ($categoryData['admin_id'] == $admin_data['id']) {
								
                                                                                echo 'selected';
																				
                                                        } ?>><?php echo $admin_data['name']; ?></option>

                        <?php }  ?>

                    </select>
                </div>


                <div class="form-group">
                    <label for="exampleInputPassword">Image</label>
                    <input type="file" name="image">
                </div>
                <br>
                <img src="./uploads/<?php echo $categoryData['image']; ?>" height="50" width="50" alt="">
                <br>



                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
        </div>




    </div>
</main>


<?php

require '../layouts/footer.php';

?>

