<nav class="navbar navbar-expand-lg">
	<div class="container-fluid">
		<h1 class="navbar-brand">Example.com</h1>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link" href="index.php">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="about.php">About</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="contact.php">Contact</a>
				</li>
			</ul>
			<div class="d-flex">
				<?php
				if(isset($_SESSION['loggedin'])){
				?>
				<div class="dropdown" style="margin-right: 75px;">
					<button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="bi bi-person-circle me-3"></i><?php echo ucfirst($_SESSION['username']); ?>
					</button>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="account.php">Account</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="logout.php">Logout</a></li>
					</ul>
				</div>
				<?php
				} else {
				?>
					<a class="btn btn-primary me-3" href="register.php">Signup</a>
					<a class="btn btn-secondary me-3" href="login.php">Login</a>
				<?php
				}
				?>
            </div>
		</div>
	</div>
</nav>
<main>
<?php
if(!empty($_SESSION['error'])){
	echo "<div class='alert alert-danger w-50 mx-auto text-center'><i class='bi bi-exclamation-triangle'></i>".$_SESSION['error']['message']."</div>";
	unset($_SESSION['error']['message']);
}
if(!empty($_SESSION['success'])){
	echo "<div class='alert alert-success w-50 mx-auto text-center'><i class='bi bi-circle-check'></i>".$_SESSION['success']['message']."</div>";
	unset($_SESSION['success']['message']);
}
?>