<?php
require "config.php";

if(isset($_SESSION['loggedin'])){
	header('location: index.php');
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(empty($_POST['login-user'])){
		$usernameErr = "Please enter your username";
	} else {
		$username = clean($_POST['login-user']);
	}
	if(empty($_POST['login-pass'])){
		$passwordErr = "Please enter your password";
	} else {
		$password = clean($_POST['login-pass']);
	}
	if(empty($usernameErr) && empty($passwordErr)){
		$sql = "SELECT id, username, email, password, date_joined FROM users WHERE username = :username";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		$user = $stmt->fetch();
		if($user){
			if(password_verify($password, $user['password'])){
				setcookie('last_login', time(), time() + (86400 * 30), "/");
				$_SESSION['loggedin'] = true;
				$_SESSION['id'] = $user['id'];
				$_SESSION['username'] = $user['username'];
				$_SESSION['email'] = $user['email'];
				$_SESSION['verified'] = $user['verified'];
				$_SESSION['date_joined'] = $user['date_joined'];
				$_SESSION['success']['message'] = "You are now logged in!";

				header('location: account.php');
			} else {
				$loginErr = "Invalid Username or Password";
			}
		} else {
			$loginErr = "Invalid Username or Password";
		}
	}
}

genHeader("Example.com | User Login Form Account Login");
include "navbar.php";
?>
<div class="container">
	<div class="row d-flex justify-content-center">
		<div class="col-lg-6 col-sm-12">
			<div class="card">
				<div class="card-body">
					<h2 class="text-center">Login</h2>
					<p class="text-center">Please enter your Username and Password.</p>
					<form id="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
						<div class="mb-3">
							<input type="text" class="form-control" name="login-user" id="login-user" placeholder="Username" required="" />
							<?php
							if(!empty($usernameErr)){
								echo "<div class='text-danger form-text mt-3'>".$usernameErr."</div>";
							}
							?>
						</div>
						<div class="mb-3">
							<input type="password" class="form-control" name="login-pass" id="login-pass" placeholder="Password" required="" />
							<?php
							if(!empty($passwordErr)){
								echo "<div class='text-danger form-text mt-3'>".$passwordErr."</div>";
							}
							?>
						</div>
						<div class="mb-3 text-center">
							<a href="forgot-password.php">Forgot Password?</a>
						</div>
						<div class="mb-3">
							<input type="submit" class="btn btn-primary w-100" value="Login"/>
							<?php
							if(!empty($loginErr)){
								echo "<div class='text-danger form-text mt-3'>".$loginErr."</div>";
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
