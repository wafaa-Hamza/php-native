 <?php 

  
  if(!isset($_SESSION['User'])){
      header("Location: ".url('login.php'));
  }


?> 