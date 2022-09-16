<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['fname'])) {

include "db_conn.php";
include 'php/User.php';
$user = getUserById($_SESSION['id'], $conn);


 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
	<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body><div class="bg-dark bg-gradient" >
    <?php if ($user) { ?>
    <div class="d-flex justify-content-center align-items-center vh-100">
    	
    	<div class= " bg-light text-dark  shadow w-850 p-5 mb-5 text-center">
    		<img src="upload/<?=$user['pp']?>"
    		     class="img-fluid rounded-circle p-1 shadow p-1  bg-body">
            <h3 class="display-4  "><?=$user['fname']?></h3>
            <h3 class="display-4 "><?=$user['Lname']?></h3>
            <a href="edit.php" class="btn btn-primary shadow p-2 ">
            	Edit Profile
            </a>
             <a href="logout.php" class="btn btn-danger me-md-2 shadow p-2  ">
                Logout
            </a>
		</div>
    </div>
    <?php }else { 
     header("Location: login.php");
     exit;
    } ?>
</body>
</html>

<?php }else {
	header("Location: login.php");
	exit;
} ?></div>