<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="body/css" href="css/style.css">
</head>
<body ><div class="bg-dark bg-gradient ">

    <div class="d-flex justify-content-center align-items-center vh-100">
	 
    	<form class="bg-white shadow-lg p-3 mb-5 bg-body rounded w-450 p-3" 
    	      action="php/login.php" 
    	      method="post">
			  
    		<h4 class="text-wrap  display-4  fs-0 text-primary =">LOGIN</h4><br>
    		<?php if(isset($_GET['error'])){ ?>
    		<div class="alert alert-danger" role="alert">
			  <?php echo $_GET['error']; ?>
			</div>
		    <?php } ?>

		  <div class="mb-3">
		    <label class="form-label fw-bolder ">User name</label>
		    <input placeholder="User name" type="text" 
		           class="form-control"
		           name="uname"
		           value="<?php echo (isset($_GET['uname']))?$_GET['uname']:"" ?>">
		  </div>

		  <div class="mb-3">
		    <label class="form-label fw-bolder">Password</label>
		    <input placeholder="Password" type="password" 
		           class="form-control"
		           name="pass">
		  </div>
		  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
		  <button type="submit" class="btn btn-primary">Login</button>
		  <a href="register.php" class="btn btn-danger me-md-2">Register</a>
		</form>
	</div>
    </div>
</body>
</html>