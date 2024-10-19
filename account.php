<?php
require "config.php";
// If not logged in send to login page
if(!isset($_SESSION['loggedin'])){
	header('location: login.php');
}
// Include Header links and set Page title
genHeader("Account");
include "navbar.php";
?>
<div class="container">
	<div class="row d-flex justify-content-center">
		<div class="col-lg-10">
			<div class="card">
				<div class="card-header d-flex justify-content-between">
					<h2 class="card-title">Welcome Back, <?php echo ucfirst($_SESSION['username']); ?></h2>
					<?php
					// Get last login time and display it
					if(!empty($_COOKIE['last_login'])){
						echo "<p><strong>Last Login:</strong> ". timeElapsed($_COOKIE['last_login']) ."</p>";
					}
					?>
				</div>
				<div class="card-body">
					<?php
					// If username is admin, show all the registered users in a table
					if($_SESSION['username'] === "admin"){
					?>
					<table class="table">
						<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Username</th>
							<th scope="col">Email Address</th>
							<th scope="col">Date Joined</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$sql = "SELECT * FROM users";
						$stmt = $pdo->prepare($sql);
						$stmt->execute();
						$users = $stmt->fetchAll();
						if($users){
							foreach($users as $user){
						?>
						<tr>
							<th scope="row"><?php echo $user['id']; ?></th>
							<td><?php echo $user['username']; ?></td>
							<td><?php echo $user['email']; ?></td>
							<td><?php echo timeElapsed($user['date_joined']); ?></td>
						</tr>
						<?php
							}
							// If no Registered users show message
						} else {
						?>
						<h2 class="text-center">No Registered Users</h2>
						<?php
						}
						?>
						</tbody>
					</table>
					<?php
					} else {
					?>
					<h2 class="text-center">You are logged in as a normal user</h2>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
genFooter();
?>
