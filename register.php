<?php
require "config.php";

if(isset($_SESSION['loggedin'])){
	header('location: account.php');
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(empty(trim($_POST['username']))){
		$usernameErr = "Please enter a username.";
	} elseif(!preg_match("/^[a-zA-Z0-9-_]+$/", trim($_POST['username']))){
		$usernameErr = "Username may only contain letters, numbers, dashes and underscores.";
	} else {
		$username = trim($_POST['username']);
	}

	if(empty(trim($_POST['email']))){
		$emailErr = "Please enter your Email Address.";
	}  elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$emailErr = "Please enter a valid email address.";
	} else {
		$email = trim($_POST['email']);
	}

	if(empty(trim($_POST['password']))){
		$passwordErr = "Please enter a password.";
	} elseif(strlen(trim($_POST['password'])) < 8){
		$passwordErr = "Your password must be at least 8 characters long.";
	} else {
		$password = trim($_POST['password']);
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
				$_SESSION['success']['message'] = "Registration successful! You can now login to your account.";
				header('location: login-form.php');
			} else {
				$signupErr = "Registration failed. Please try again later.";
			}
		}
		unset($stmt);
	}
}

genHeader(SITE_NAME." | New Account Form");
include "navbar.php";
?>
<div class="container">
	<div class="row d-flex justify-content-center">
		<div class="col-lg-6 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title">Create your Account</h2>
					<p class="form-text">Fill in the form below to create a new account.</p>
				</div>
				<div class="card-body">
					<form id="signup-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
						<div class="mb-3">
							<input type="text" class="form-control <?php echo (!empty($usernameErr)) ? 'is-invalid' : '';?>" name="username" id="username" placeholder="Username" value="<?php echo (!empty(htmlspecialchars($_POST['username'])) ? htmlspecialchars($_POST['username']) : ''); ?>" required="" />
							<?php
							if(!empty($usernameErr)){
								echo "<div class='text-danger form-text'>".$usernameErr."</div>";
							}
							?>
						</div>
						<div class="mb-3">
							<input type="email" class="form-control <?php echo (!empty($emailErr)) ? 'is-invalid' : '';?>" name="email" id="email" placeholder="Email Address" value="<?php echo (!empty(htmlspecialchars($_POST['email'])) ? htmlspecialchars($_POST['email']) : ''); ?>" required="" />
							<?php
							if(!empty($emailErr)){
								echo "<div class='text-danger form-text'>".$emailErr."</div>";
							}
							?>
						</div>
						<div class="mb-3">
							<input type="password" class="form-control <?php echo (!empty($passwordErr)) ? 'is-invalid' : '';?>" name="password" id="password" placeholder="Password" value="<?php echo (!empty(htmlspecialchars($_POST['password'])) ? htmlspecialchars($_POST['password']) : ''); ?>" required="" />
							<?php
							if(!empty($passwordErr)){
								echo "<div class='text-danger form-text'>".$passwordErr."</div>";
							}
							?>
						</div>
						<div class="mb-3">
							<input type="password" class="form-control" name="confirm" id="confirm" placeholder="Confirm Password" required="" />
							<?php
							if(!empty($confirmErr)){
								echo "<div class='text-danger form-text'>".$confirmErr."</div>";
							}
							?>
						</div>
						<div class="mb-3">
							<input type="submit" class="btn btn-primary w-100" name="signup-btn" id="signup-btn" value="SignUp"/>
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

