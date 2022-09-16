<?php  
session_start();
include "../db_conn.php";

if (isset($_SESSION['id']) && isset($_SESSION['fname'])) {



if(isset($_POST['fname']) && 
   isset($_POST['Lname'])&& 
   isset($_POST['pass'])){

    include "../db_conn.php";

    $fname = $_POST['fname'];
    $Lname = $_POST['Lname'];
    $pass = $_POST['pass'];
    $old_pp = $_POST['old_pp'];
    $id = $_SESSION['id'];
    

    if (empty($fname)) {
    	$em = "Full name is required";
    	header("Location: ../edit.php?error=$em");
	    exit;
    }else if(strlen($fname)> 60){
      $em = " Full name cannot be greater than 60  characters  ";
      header("Location: ../edit.php?error=$em&$data");
      exit;
   }else if(strlen($Lname)> 60){
      $em = " Last name cannot be greater than 60  characters  ";
      header("Location: ../edit.php?error=$em&$data");
      exit;
   }
    else {
      if ($pass!="") { 
         if (!preg_match("/^(?=.*[0-9])(?=.*[a-zA-Z])(?!.*\W)(?!.* ).{6,}$/",$pass)){
             $em  = 'Password must contain letters and numbers more than 6 characters ';
            header("Location: ../edit.php?error=$em&$data");
               exit;
               }	       

               $sql = "SELECT * FROM users WHERE id = ?";
               $stmt = $conn->prepare($sql);
               $stmt->execute([$id]);
        
              if($stmt->rowCount() == 1){
                  $user = $stmt->fetch();
        
                 
                  $password =  $user['password'];
                  $id =  $user['id'];
                  
        
                  if($id === $id){
                     if(password_verify($pass, $password)){
                        $em  = 'New Password cannot same as Old Password';
                        header("Location: ../edit.php?error=$em&$data");
                           exit;
                     }
                  }
        
              }
              
         // hashing the password	
         $pass = password_hash($pass, PASSWORD_DEFAULT);
         $sql = "UPDATE users 
          SET password=? 
             WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$pass,$id]);
   
            header("Location: ../edit.php?success=Your password has been updated successfully");
            exit;
            
      }
      
     
      
      if (isset($_FILES['pp']['name']) AND !empty($_FILES['pp']['name'])) {
         
        
         $img_name = $_FILES['pp']['name'];
         $tmp_name = $_FILES['pp']['tmp_name'];
         $error = $_FILES['pp']['error'];
         
         if($error === 0){
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_to_lc = strtolower($img_ex);

            $allowed_exs = array('jpg', 'jpeg', 'png','bmp');
            if(in_array($img_ex_to_lc, $allowed_exs)){
               $new_img_name = uniqid($fname, true).'.'.$img_ex_to_lc;
               $img_upload_path = '../upload/'.$new_img_name;
               // Delete old profile pic
               $old_pp_des = "../upload/$old_pp";
               if(unlink($old_pp_des)){
               	  // just deleted
               	  move_uploaded_file($tmp_name, $img_upload_path);
               }else {
                  // error or already deleted
               	  move_uploaded_file($tmp_name, $img_upload_path);
               }
               

               // update the Database
               $sql = "UPDATE users 
                       SET fname=?, Lname=? , pp=? 
                       WHERE id=?";
               $stmt = $conn->prepare($sql);
               $stmt->execute([$fname, $Lname, $new_img_name, $id]);
               $_SESSION['fname'] = $fname;
               header("Location: ../edit.php?success=Your account has been updated successfully");
                exit;
            }else {
               $em = "You can't upload files of this type";
               header("Location: ../edit.php?error=$em&$data");
               exit;
            }
         }else {
            $em = "unknown error occurred!";
            header("Location: ../edit.php?error=$em&$data");
            exit;
         }

        
      }else {
       	$sql = "UPDATE users 
       	        SET fname=?, Lname=? 
                WHERE id=?";
       	$stmt = $conn->prepare($sql);
       	$stmt->execute([$fname, $Lname, $id]);

       	header("Location: ../edit.php?success=Your account has been updated successfully");
   	    exit;
      }
    }


}else {
	header("Location: ../edit.php?error=error");
	exit;
}


}else {
	header("Location: login.php");
	exit;
} 

