<?php
	if(isset($_POST['username']) && isset($_POST['password'])) {
		echo "true\n";
		
		$username= $_POST['username'];
		$password= $_POST['password'];
		$password_hash= md5($password);

		if(!empty($username) && !empty($password)){
			$query = "SELECT `id` FROM `users` WHERE `username`='$username' AND `password`='$password_hash'";
			
			if($query_run= mysqli_query($con,$query)){
				$query_num_rows=mysqli_num_rows($query_run);

				if($query_num_rows==0){
					echo "Invalid username/password";
				} else if($query_num_rows==1){
					$result=mysqli_fetch_assoc($query_run);
					$user_id=$result['id'];
					$_SESSION['user_id']=$user_id;
					header('Location: index.php');
				}
			} else {
				echo mysqli_error($con);
			}
		}	else {
			echo "you must supply a username and password";
		}
	}

?>

<link rel="stylesheet" type="text/css" href="loginform.css">

<form action= "<?php echo $currentfile; ?>" method="POST">

<div class="login">
    <input type="text" placeholder="Username" id="username" name="username">  
  <input type="password" placeholder="password" id="password" name="password">  
 <!-- <a href="#" class="forgot">forgot password?</a> -->
  <input type="submit" value="Sign in">
</div>

</form>