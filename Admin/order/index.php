<?php

require '../helpers/dbConnection.php';
require '../helpers/functions.php';


$sql = "select order.*,customer.name as CatName from order inner join customer on order.customer_id =customer.id";
$op  = mysqli_query($con, $sql);

require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>



<main>
    <div class="container-fluid">
    <h1 class="mt-4">Order</h1>
        <ol class="breadcrumb mb-4">
		
		 <?php

           
              displayMessage('Dashboard/Display Order');

            ?>
            
        </ol>





        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                DataTable Example
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Customer Type</th>
                                <th>Action</th>


                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                            <th>ID</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Customer Type</th>
                                <th>Action</th>

                            </tr>
                        </tfoot>

                        <tbody>

                            <?php

                            while ($data = mysqli_fetch_assoc($op)) {

                            ?>
                                <tr>
                                    <td><?php echo $data['id']; ?></td>
                                    <td><?php echo $data['date']; ?></td>
                                    <td><?php echo $data['price'];?></td>
                                    <td><?php echo $data['CatName'];?></td>

                                    <td>
                                        <a href='delete.php?id=<?php echo $data['id'];  ?>' class='btn btn-danger m-r-1em'>Delete</a>

                                    </td>

                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


<?php

require '../layouts/footer.php';

?>