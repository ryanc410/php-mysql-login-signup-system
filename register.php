<?php
require "config.php";

if(isset($_SESSION['loggedin'])){
	header('location: index.php');
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(empty(trim($_POST['username']))){
		$usernameErr = "Please enter a username.";
	} elseif(!preg_match("/^[a-zA-Z0-9-_]+$/", trim($_POST['username']))){
		$usernameErr = "Username may only contain letters, numbers, dashes and underscores.";
	} else {
		$username = clean($_POST['username']);
	}

	if(empty(trim($_POST['email']))){
		$emailErr = "Please enter your Email Address.";
	}  elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$emailErr = "Please enter a valid email address.";
	} else {
		$email = clean($_POST['email']);
	}

	if(empty(trim($_POST['password']))){
		$passwordErr = "Please enter a password.";
	} elseif(strlen(trim($_POST['password'])) < 8){
		$passwordErr = "Your password must be at least 8 characters long.";
	} else {
		$password = clean($_POST['password']);
	}

	if(empty(trim($_POST['confirm']))){
		$confirmErr = "Please confirm your password.";
	} elseif($password != $_POST['confirm']){
		$confirmErr = "Passwords do not match.";
	}

	if(empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmErr)){
		$sql = "INSERT INTO users(username, email, password) VALUES(:username, :email, :password)";
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		
		if($stmt = $pdo->prepare($sql)){
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
			if($stmt->execute()){
				$to = $email;
				$subject = "Welcome to Example.com!";
				$message = "<html><head><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'></head><body><div class='container'><div class='row d-flex justify-content-center'><div class='col-6'><h2 class='text-center'>Your Account was successfully created!</h2><div class='card'><div class='card-body'><p>Welcome $username!</p><p>Thank you for signing up with us. If you have any questions feel free to contact us via the Contact Page.</p><div class='d-flex justify-content-end'><p>Thanks again for joining,</p><p>Example.com Admin</p></div></div></div></div></div></div></body></html>";

				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: noreply@example.com' . "\r\n"; // Sender's email address
				$headers .= 'Reply-To: noreply@example.com' . "\r\n"; // Reply-To email address
				$headers .= 'X-Mailer: PHP/' . phpversion(); // PHP version

				if(mail($to, $subject, $message, $headers)){
					// Set the success message
					$_SESSION['success']['message'] = "Registration successful! You can now login to your account.";
					// Send an Email to site admin Informing them of the new user
					include "mail_admin.php";
					header('location: login.php');
				}
			} else {
				$signupErr = "Registration failed. Please try again later.";
			}
		}
		unset($stmt);
	}
}

genHeader("Example.com | New Account Form");
include "navbar.php";
?>
<div class="container">
	<div class="row d-flex justify-content-center">
		<div class="col-lg-6 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h1 class="card-title text-center" style="text-align: center;">Sign Up</h1>
					<p class="text-center">Already have an account?<a href="register.php" style="text-decoration: none;">&nbsp; Sign In</a></p>
				</div>
				<div class="card-body">
					<form id="signup-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
						<div class="form-floating mb-3">
							<input type="text" class="form-control" name="username" id="username" style="border-top-style: none;border-right-style: none;border-bottom-style: solid;border-bottom-color: var(--bs-emphasis-color);border-left-style: none;border-radius: 0;">
							<label class="form-label" for="username" data-bs-toggle="tooltip" data-bss-tooltip="" title="Username can contain letters numbers underscores and dashes">Username</label>
							<?php
							if(!empty($usernameErr)){
								echo "<div class='text-danger form-text'>".$usernameErr."</div>";
							}
							?>
						</div>
						<div class="form-floating mb-3">
							<input class="form-control" type="email" id="email" name="email" style="border-top-style: none;border-right-style: none;border-bottom-style: solid;border-bottom-color: var(--bs-emphasis-color);border-left-style: none;border-radius: 0;">
							<label class="form-label" for="email" data-bs-toggle="tooltip" data-bss-tooltip="" title="Must be a valid Email Address">Email</label>
							<?php
							if(!empty($emailErr)){
								echo "<div class='text-danger form-text'>".$emailErr."</div>";
							}
							?>
						</div>
						 <div class="form-floating mb-3">
							<input class="form-control" type="password" id="password" name="password" style="border-top-style: none;border-right-style: none;border-bottom-style: solid;border-bottom-color: var(--bs-emphasis-color);border-left-style: none;border-radius: 0;">
							<label class="form-label" for="password" data-bs-toggle="tooltip" data-bss-tooltip="" title="Must be at least 8 characters with uppercase and lowercase letters and numbers">Password</label>
							<?php
							if(!empty($passwordErr)){
								echo "<div class='text-danger form-text'>".$passwordErr."</div>";
							}
							?>
						</div>
						<div class="form-floating mb-3">
							<input class="form-control" type="password" id="confirm" name="confirm" style="border-top-style: none;border-right-style: none;border-bottom-style: solid;border-bottom-color: var(--bs-emphasis-color);border-left-style: none;border-radius: 0;">
							<label class="form-label" for="confirm" data-bs-toggle="tooltip" data-bss-tooltip="" title="Passwords must match">Confirm</label>
							<?php
							if(!empty($confirmErr)){
								echo "<div class='text-danger form-text'>".$confirmErr."</div>";
							}
							?>
						</div>
						<div class="mb-3">
							<input type="submit" class="btn btn-primary" name="signup-btn" id="signup-btn" value="Register" style="width="100%"/>
							<?php
							if(!empty($signupErr)){
								echo "<div class='text-danger form-text'>".$signupErr."</div>";
							}
							?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
genFooter();
?>
