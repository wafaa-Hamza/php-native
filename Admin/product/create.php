<?php

require '../helpers/dbConnection.php';
require '../helpers/functions.php';



$sql =  "SELECT * FROM category";
$categoryOp = mysqli_query($con , $sql);


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


   # Check Errors ... 


   if (count($errors) > 0) {
    $_SESSION['Message'] = $errors;
     } else {

    $image = uploadFile($_FILES);  
 

    if (empty($image) ) {
        $_SESSION['Message'] = ["Error In Uploading File Try Again"];
    } else {


        $user_id = $_SESSION['User']['id'];
        $sql = "INSERT INTO `product`( `name`, `price`, `image`, `description`,`admin_id` , `category_id`) VALUES
         ('$name','$price','$image','$description',$user_id ,$category_id)";
         
        $op  = mysqli_query($con, $sql);

        if ($op) {
            $message = ["Raw Inserted"];
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
          <h1 class="mt-4">Dashboard</h1>
          <ol class="breadcrumb mb-4">
  
  
  
              <?php
  
              displayMessage('Dashboard/Add Product');
  
              ?>
  
  
  
          </ol>
  
  
  
          <div class="container">
  
  
              <form action="<?php echo  htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
  
                  <div class="form-group">
                      <label for="exampleInputName">Name</label>
                      <input type="text" class="form-control" id="exampleInputName" aria-describedby="" name="name" placeholder="Enter Name">
                  </div>

                  <div class="form-group">
                      <label for="exampleInputPrice">Price</label>
                      <input type="text" class="form-control" id="exampleInputPrice" aria-describedby="" name="price" placeholder="Enter Price">
                  </div>
  
  
  
                  <div class="form-group">
                      <label for="exampleInputPassword">Image</label>
                      <input type="file" name="image">
                  </div>
  


                  <div class="form-group">
                      <label for="exampleInputEmail">Description</label>
  
                      <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>
                  </div>
  

                  <div class="form-group">
                      <label for="exampleInputPassword">Category</label>
                      <select class="form-control" name="category_id">
  
                          <?php
                          while ($Cat_data = mysqli_fetch_assoc($categoryOp)) {
                          ?>
  
                              <option value="<?php echo $Cat_data['id']; ?>"><?php echo $Cat_data['name']; ?></option>
  
                          <?php }  ?>
  
                      </select>
                  </div>
  
  
  
                  <button type="submit" class="btn btn-primary">Save</button>
              </form>
          </div>
  
  
  
  
      </div>
  </main>
  
  
  <?php
  
  require '../layouts/footer.php';


?>