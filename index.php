<?php
session_start();
include("koneksi.php");
if(isset($_POST['loginok'])){
	$temp_username = $_POST['txtusername'];
	$pass = $_POST['txtpassword'];
	$sql = "SELECT * FROM users WHERE id='$temp_username'";
	$hasil = mysqli_query($con, $sql);
	if(mysqli_num_rows($hasil)>0){
		$baris = mysqli_fetch_array($hasil);
		if(password_verify($pass, $baris['password']))
		{
			$_SESSION['login'] = 1;
			header("Location: admin.php");
			//exit();
		}
		else
		{
			setcookie("error", "Username atau Password Salah.", time()+10);
			$a="1";
		}
	}
	else{
		$msg = "Password tidak sesuai!";
	}
} ?>
<!DOCTYPE html>
<html>
<head>
	<!--<meta charset="UTF-8">-->
    <title>Material Login Form</title>    
    <link rel="stylesheet" href="css/reset.css">
    <meta name="viewport" content="width=device-width; initial-scale=1.5; maximum-scale=1.0;">
    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
	<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
	<link rel="stylesheet" href="css/style.css">   
</head>
<body>
	<div class="pen-title">
		<h1>Login Admin</h1>
	</div>
	<div class="container">
		<div class="card"></div>
		<div class="card">
			<form method="POST" action="index.php">
				<h1 class="title">Login</h1>
				<div class="input-container">
					<input type="text" id="Username" name="txtusername" required="required"/>
					<label for="Username">Username</label>
					<div class="bar"></div>
				</div>
				<div class="input-container">
					<input type="password" id="Password" name="txtpassword" required="required"/>
					<label for="Password">Password</label>
					<div class="bar"></div>
				</div>
				<div class="input-container">
					<?php
						if(isset($msg)){
							echo "<div align = 'center' class ='alert alert-warning'>";
							echo $msg;
							echo "</div>";
						}
					?>
				</div>
			    <div class="button-container">
			    	<button type="submit" name="loginok"><span>Go</span></button>
			    </div>
			</form>
		</div>
	</div>
</body>
</html>