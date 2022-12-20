<?php
 
 function Clean($input, $flag = 0){

    $input =  trim($input);

    if ($flag == 0) {
        $input =  filter_var($input, FILTER_SANITIZE_STRING);   
    }
    return $input;
}

function validate($input , $flag){
    $status = true ;

    switch ($flag){
        case 1:
            if(empty($input)){
                $status = false;
            }

            break ;
        case 2:
            if(!filter_var($input,FILTER_VALIDATE_EMAIL)){
                $status = false ;
            }
            break;

        case 3:
            if(strlen($input)<10){
                $status = false;
            }
            break;

        case 4;
           if(!filter_var($input,FILTER_VALIDATE_INT)){
               $status = false;
           }
           break;

        case 5: 
           
            $nameArray =  explode('.', $input);
            $imgExtension =  strtolower(end($nameArray));
      
            $allowedExt = ['png', 'jpg'];
    
            if (!in_array($imgExtension, $allowedExt)) {
                $status = false;
            }
          break;

    }

    return $status;
}



function displayMessage($text = null){

    if(isset($_SESSION['Message'])){

        foreach($_SESSION['Message'] as $key => $value){
            echo '*'.$value.'</br>';
        }
        unset($_SESSION['Message']);
    }else{
        echo   '<li class="breadcrumb-item active">'.$text.'</li>';
    }
}





function uploadFile($input){

    $result = '';

    $imgName  = $input['image']['name'];
    $imgTemp  = $input['image']['tmp_name'];

    $nameArray =  explode('.', $imgName);
    $imgExtension =  strtolower(end($nameArray));
    $imgFinalName = time() . rand() . '.' . $imgExtension;

     
    $disPath = 'uploads/' . $imgFinalName;

    if (move_uploaded_file($imgTemp, $disPath)) {
      $result =  $imgFinalName ;
       }

      return $result;  
      
  
}



function url($input){
    return "http://".$_SERVER['HTTP_HOST']."/fashion/Admin/".$input;
}

?>