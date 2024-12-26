<?php
	session_start();
	date_default_timezone_set('Asia/Kolkata');
	ob_start();
?>
<html>
<head>
	<title>AES Encryption and Decryption Tool</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/Login.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
	<!-- <script src="js/Navigation.js"></script> -->
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/Login.js"></script>
</head>
<body>
	<?php
		if (isset($_GET['Admin'])) {
			echo "<script type='text/javascript'>$(document).ready(function(){showRegistration();});</script>";
		}
	?>	
	<div id="background">
		<?php include "Header.html" ?>
		<div id="body"><div><div>
			<center>
				<div class="login-form" id="login" style="display: none;"> 
					<div class="text">LET'S LOGIN</div>
					<form method="POST" onsubmit="return ValidateLogin();">
							<div class="field">
									<div class="fas fa-envelope"></div>
									<input type="text" id="email" placeholder="Email" name="email" required>
							</div>
							<div class="field">
								<div class="fas fa-lock"></div>
								<input type="password" id="password" placeholder="Password" name="password" required>
								<span class="eye" onclick="togglePassword('password');">
										<i class="fas fa-eye" id="eyeIconpassword"></i>
								</span>
							</div>
							<div style="float:left;margin-top:20px;font-size:20px;">
									<input type="checkbox" id="rememberme" name="rememberme" style="height: 20px;width: 50px;">
									<label for="rememberme" style="vertical-align: top;">Remember Me</label>
							</div>
							<button type="submit" name="login">LOGIN</button>
							<div class="link" style="font-size: 20px;">
									Not a member?
									<a href="javascript:void(0);" onclick="showRegistration();">Signup now</a>
							</div>
					</form>
				</div>
				<div class="registration-form" id="registration" style="display: none;">
						<div class="text">REGISTER</div>
						<?php
							if (isset($_GET['Admin'])) {
								echo "<span><a href='/CipherNest/User.php' style='color:red;'>Go Back To Admin</a></span>";
							}
						?>
						<form method="POST" onsubmit="return ValidateRegister();">
								<div class="field">
										<div class="fas fa-user"></div>
										<input type="text" id="name" placeholder="Full Name" name="name" required>
								</div>
								<div class="field">
										<div class="fas fa-envelope"></div>
										<input type="email" id="Remail" placeholder="Email" name="email" required>
								</div>
								<div class="field">
										<div class="fas fa-lock"></div>
										<input type="password" id="Rpassword" placeholder="Password" name="password" required>
										<span class="eye" onclick="togglePassword('Rpassword');">
												<i class="fas fa-eye" id="eyeIconRpassword"></i>
										</span>
								</div>
								<div class="field">
										<div class="fas fa-lock"></div>
										<input type="password" id="confirmPassword" placeholder="Confirm Password" name="confirmPassword" required>
										<span class="eye" onclick="togglePassword('confirmPassword');">
												<i class="fas fa-eye" id="eyeIconconfirmPassword"></i>
										</span>
								</div>
								<button type="submit" name="register">REGISTER</button>
								<div class="link" style="font-size: 20px;">
										Already a member?
										<a href="javascript:void(0);" onclick="showLogin();">Login now</a>
								</div>
						</form>
				</div>
			</center>
	</div></div></div>
	<?php include "Footer.html" ?>
	</div>
</body>
</html>

<?php
	if(isset($_REQUEST['register'])){
		require 'DB.php';

		$name = trim($_POST['name']);
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$cpwd = trim($_POST['confirmPassword']);
		$currentDateTime = date('Y-m-d H:i:s');

		$user = "select * from tblUser where UserID='$email' and PassWD='$password'";
		$Ures = mysqli_query($mysql,$user);

		if (mysqli_num_rows($Ures) > 0) {
			echo "<script>swal('Oops!', 'User Already Registered, Please use a different account.', 'error');</script>";
		}else{
			$q = "insert into tblUser values(null,'$email','$name','$password','$cpwd','$currentDateTime','')";
			if(mysqli_query($mysql,$q)){
				if (isset($_GET['Admin'])) {
					header("location:/CipherNest/User.php");
				}
				echo "<script type='text/javascript'>showLogin();</script>";
			}else{
				echo "<script>swal('Oops!', 'Registration failed. Please try again.', 'error');</script>";
			}
		}

	}else if (isset($_POST['login'])) {
		require 'DB.php';

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
		$remember = isset($_POST['rememberme']);
		$LoginDateTime = date('Y-m-d H:i:s');

		$user = "select * from tblUser where UserID='$email' and PassWD='$password'";
    $admin = "select * from tblAdmin where UserID='$email' and PassWD='$password'";

    $Ures = mysqli_query($mysql,$user) or die("User Login Failed");
    $Ares = mysqli_query($mysql,$admin) or die("Admin Login Failed");

		if (mysqli_num_rows($Ures) == 1) {
			$_SESSION['email'] = $email;

			$q = "insert into tblUserActivity(SID,UID,LastLoginDateTime,Status,RoleID) values(null,'$email','$LoginDateTime','Active',2)"; //2 = User
			if(!mysqli_query($mysql,$q))
				error_log("Database error: " . mysqli_error($mysql));

			if ($remember) {
				$token = bin2hex(random_bytes(16));
				$expires = time() + (30*24*60*60);
				setcookie('rememberme', $token, $expires, "/", "", true, true);

				$q = "update tblUser set RememberToken='$token' WHERE UserID='$email'";
				if(mysqli_query($mysql,$q)){
					header("Location: index.php");
					exit();
				}
			}
			header("Location: index.php");
			exit();
		}elseif(mysqli_num_rows($Ares) == 1){
      $_SESSION['email'] = $email;

			$q = "insert into tblUserActivity(SID,UID,LastLoginDateTime,Status,RoleID) values(null,'$email','$LoginDateTime','Active',1)"; //1 = Admin
			if(!mysqli_query($mysql,$q))
				error_log("Database error: " . mysqli_error($mysql));

			if ($remember) {
				$token = bin2hex(random_bytes(16));
				$expires = time() + (30*24*60*60);
				setcookie('rememberme', $token, $expires, "/", "", true, true);

				$q = "update tblAdmin set RememberToken='$token' WHERE UserID='$email'";
				if(mysqli_query($mysql,$q)){
					header("Location: Aindex.php");
        	exit();
				}
			}
      header("Location: Aindex.php");
      exit();
    }else{
			echo "<script>swal('Oops!', 'Login failed. Please try again.', 'error');</script>";
		}
}
?>

