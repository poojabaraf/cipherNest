<?php
	session_start();
	date_default_timezone_set('Asia/Kolkata');
?>
<html>
<head>
	<title>AES Encryption and Decryption Tool</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/Feedback.css" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
	<!-- <script src="js/Navigation.js"></script> -->
	<script src="js/jquery-3.7.1.min.js"></script>
</head>
<body>
	<div id="background">
	<?php include "Header.html" ?>
		<div id="body"><div><div>
			<center>
			<div class="feedback-form">
					<div class="text">FEEDBACK
						<?php
							if (isset($_SESSION['email'])) {
								$admin = ['idkhushirana@gmail.com','poojabarafwala09@gmail.com','prachichahhan@gmail.com'];
								if(in_array(strtolower($_SESSION['email']), $admin)){
									echo "<span><a href='/CipherNest/Aindex.php'><img src='images/Admin.png' title='Go Back To Admin' height='30px' width='30px'></a></span>";
								}	
							}
						?>
					</div>	
					<form method="POST">
							<div class="field">
									<div class="fas fa-user"></div>
									<input type="text" placeholder="Name" name="name" required>
							</div>
							<div class="field">
									<div class="fas fa-envelope"></div>
									<input type="email" placeholder="Email" name="email" required>
							</div>
							<div class="field">
									<div class="fas fa-comments"></div>
									<textarea placeholder="Your Feedback" name="feedback" required></textarea>
							</div>
							<button type="submit" name="submit">SUBMIT</button>
							<div class="link" style="margin-top: 15px;font-size: 20px;">
									Want to contact us directly?
									<a href="mailto:poojabarafwala09@gmail.com"><img style="vertical-align:middle;" src="images/ContactUs3.png" height="25px" width="25px" alt="Contact Us"></a>
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
	if(isset($_REQUEST['submit']))
	{
		require 'DB.php';
		$name = trim($_POST['name']);
		$email = trim($_POST['email']);
		$feedback = trim($_POST['feedback']);
		$FDateTime = date('Y-m-d H:i:s');

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			echo "<script>swal('Oops!', 'Please enter a valid email address.', 'error');</script>";

		$q = "insert into tblFeedBack values(null,'$email','$name','$feedback','$FDateTime')";

		if(mysqli_query($mysql,$q)){
			echo "<script type='text/javascript'>swal('Thank you!', 'Your feedback has been submitted successfully!','success');</script>";
		}else{
			echo "<script>swal('Oops!', 'There was an error submitting your feedback. Please try again.', 'error');</script>";
		}
	}
?>