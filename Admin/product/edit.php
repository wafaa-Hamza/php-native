<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../helpers/checkLogin.php';


$id = $_GET['id'];

$sql = "select * from product where id = $id";
$op = mysqli_query($con, $sql);



    $productData = mysqli_fetch_assoc($op);

      if(!(($_SESSION['User']['id'] == $productData['admin_id']))){
        header('Location: index.php');
        exit();

      }

$sql = 'select * from category';
$categoryOp = mysqli_query($con, $sql);



# Code .....

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name    = Clean($_POST['name']);
    $price   = Clean($_POST['price']);
    $description = Clean($_POST['description']);
    $category_id  = Clean($_POST['category_id']);


$errors = [];
# Validate Name ... 
if (!validate($name, 1)) {
    $errors['Name'] = " Name Required";
}

# Validate Price ...
if (!validate($price, 1)) {
    $errors['Price'] = " Price Required";
}

#Validate Image ... 
if (!validate($_FILES['image']['name'], 1)) {
    $errors['Image']  = "Image Required";
} elseif (!validate($_FILES['image']['name'], 5)) {
    $errors['Image']  = "Image : Invalid Extension";
}

# Validate Description
if (!validate($description, 1)) {
    $errors['Description'] = " Description Required";
}

# Validate category_id  ... 
if (!validate($category_id, 1)) {
    $errors['Category'] = " Category Required";
} elseif (!validate($category_id, 4)) {
    $errors['Category'] = " Category Invalid";
}

    if (count($errors) > 0) {
        $Message = $errors;
    } else {
        // DB CODE .....

        if (Validate($_FILES['image']['name'], 1)) {
            $disPath = './uploads/' . $FinalName;

            if (!move_uploaded_file($ImgTempPath, $disPath)) {
                $Message = ['Message' => 'Error  in uploading Image  Try Again '];
            } else {
                unlink('./uploads/' . $productData['image']);
            }
        } else {
            $FinalName = $productData['image'];
        }

        if (count($Message) == 0) {

            $sql = "update product set name='$name' , price='$price' , image ='$FinalName' , description= $description , category_id = $category_id  where id = $id";

            $op = mysqli_query($con, $sql);

            if ($op) {
                $Message = ['Message' => 'Raw Updated'];
            } else {
                $Message = ['Message' => 'Error Try Again ' . mysqli_error($con)];
            }
        }
        # Set Session ......
        $_SESSION['Message'] = $Message;
        header('Location: index.php');
        exit();
    }
    $_SESSION['Message'] = $Message;
}

require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>



<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard/Update product</li>

            <?php
            echo '<br>';
            if (isset($_SESSION['Message'])) {
                displayMessage($_SESSION['Message']);
            
                # Unset Session ...
                unset($_SESSION['Message']);
            }
            
            ?>

        </ol>


        <div class="card mb-4">

            <div class="card-body">

                <form action="edit.php?id=<?php echo $productData['id']; ?>" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputName">Name</label>
                        <input type="text" class="form-control" id="exampleInputName" name="name" aria-describedby=""
                            placeholder="Enter name" value="<?php echo $productData['name']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputName">Price</label>
                        <input type="text" class="form-control" id="exampleInputName" name="price" aria-describedby=""
                            placeholder="Enter name" value="<?php echo $productData['price']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName">Image</label>
                        <input type="file" name="image">
                    </div>

                    <img src="./uploads/<?php echo $productData['image']; ?>" alt="" height="50px" width="50px"> <br>



                    <div class="form-group">
                        <label for="exampleInputName"> Description</label>
                        <textarea class="form-control" id="exampleInputName"
                            name="content"> <?php echo $productData['description']; ?></textarea>
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword">Category</label>
                        <select class="form-control" id="exampleInputPassword1" name="category_id">

                            <?php
                               while($data = mysqli_fetch_assoc($categoryOp)){
                            ?>

                            <option value="<?php echo $data['id']; ?>" <?php if ($data['id'] == $productData['category_id']) {
                                     echo 'selected';
                                  } ?>><?php echo $data['name']; ?></option>

                            <?php }
                            ?>

                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>



            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>