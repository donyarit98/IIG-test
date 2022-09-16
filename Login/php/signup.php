<?php 



if(isset($_POST['fname']) && 
   isset($_POST['Lname']) &&
   isset($_POST['uname']) &&  
   isset($_POST['pass'])){

    include "../db_conn.php";

   

    $fname = $_POST['fname'];
    $Lname = $_POST['Lname'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];

    $data = "fname=".$fname."&uname=".$uname;
    
    if (empty($fname)) {
    	$em = "Full name is required";
    	header("Location: ../register.php?error=$em&$data");
      exit;
    }else if(strlen($fname)> 60){
      $em = " Full name cannot be greater than 60  characters  ";
      header("Location: ../register.php?error=$em&$data");
      exit;
   }else if(strlen($Lname)> 60){
      $em = " Last name cannot be greater than 60  characters  ";
      header("Location: ../register.php?error=$em&$data");
      exit;
   }
    else if(empty($uname)){
    	$em = "User name is required";
    	header("Location: ../register.php?error=$em&$data");
	    exit;
    }else if(strlen($uname)< 4){
      $em = " Username must be at least 4 characters  ";
      header("Location: ../register.php?error=$em&$data");
      exit;
   }else if(strlen($uname)> 12){
      $em = " Username cannot be greater than 12  characters  ";
      header("Location: ../register.php?error=$em&$data");
      exit;
   } if (!preg_match("/^[0-9a-zA-Z_]*$/",$uname)){
         $em  = 'only letters,numbers and underscore allowed in Username ';
         header("Location: ../register.php?error=$em&$data");
         exit;
      } //check user in db
      $check = $conn->prepare("SELECT * FROM users WHERE username=?");
      $check->execute([$uname]); 
      $user = $check->fetch();
      if ($user) {
         $em  = 'Username already exits ';
         header("Location: ../register.php?error=$em&$data");
         exit;
      }    
   if(empty($pass)){
    	$em = "Password is required";
    	header("Location: ../register.php?error=$em&$data");
	    exit;
    }
    if (!preg_match("/^(?=.*[0-9])(?=.*[a-zA-Z])(?!.*\W)(?!.* ).{6,}$/",$pass)){
      $em  = 'Password must contain letters and numbers more than 6 characters ';
      header("Location: ../register.php?error=$em&$data");
      exit;
   }
  
    else {
      
      

      if (isset($_FILES['pp']['name']) AND !empty($_FILES['pp']['name'])) {
         
         $img_name = $_FILES['pp']['name'];
         $tmp_name = $_FILES['pp']['tmp_name'];
         $error = $_FILES['pp']['error'];
         
         if($error === 0){

          

            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_to_lc = strtolower($img_ex);

            $allowed_exs = array('jpg', 'jpeg', 'png','bmp');
            
            
            if(in_array($img_ex_to_lc, $allowed_exs)){
               $new_img_name = uniqid($uname, true).'.'.$img_ex_to_lc;
               $img_upload_path = '../upload/'.$new_img_name;
               move_uploaded_file($tmp_name, $img_upload_path);

               // hashing the password
           $pass = password_hash($pass, PASSWORD_DEFAULT);
               // Insert into Database
               $sql = "INSERT INTO users(fname,Lname, username, password, pp) 
                 VALUES(?,?,?,?,?)";
               $stmt = $conn->prepare($sql);
               $stmt->execute([$fname,$Lname, $uname, $pass, $new_img_name]);

               header("Location: ../register.php?success=Your account has been created successfully");
                exit;
            }
            
           else{
               $em = "You can only upload  this type (.jpg, .jpeg, .png, .bmp)";
             
               header("Location: ../register.php?error=$em&$data");
               exit;
            }
         }else {
            $em = "error";
            header("Location: ../register.php?error=$em&$data");
            exit;
         }

        
      }else {
         if(empty($_FILES['pp']['name'])){
            $em = "image is required";
            header("Location: ../register.php?error=$em&$data");
            exit;
         }
      }
    }


}else {
	header("Location: ../register.php?error=error");
	exit;
}
