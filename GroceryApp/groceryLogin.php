<?php
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Grocery Login</title>
		<link rel="stylesheet" href="styles.css" />
	</head>
	<body>
		<div class="page">
			<header class="menu-container">
				<h1 class="logo">
					<a class="logo-link" href="./index.php">Grocery App</a>
				</h1>
			</header>

			<!--Title and Form-->
			<article class="content">
				<header class="title">
					<h2>Grocery Login</h2>
				</header>

				<!-- Form -->
				<form
					class="groceryForm"
					method="post"
					action="userAuthentication.php"
				>
					<!-- username, password-->
					<label for="username">Username</label>
					<input
						class="textInput"
						type="text"
						name="username"
						pattern="[A-Za-z]{1,}"
						required
					/>

					<label for="password">Password</label>
					<input
						class="textInput"
						type="text"
						name="password"
						pattern="[A-Za-z0-9]{1,}"
					/>

					<input type="submit" value="Login" />

					<?php
						if(isset($_SESSION['error'])){
							$error = $_SESSION['error'];
							echo "<br><span>$error</span>";
						}
					?>

				</form>
				<div class="groceryForm">
                <a href="grocerySignup.php" style="color: #0b6fa6">Sign up as new user.</a>
            </div>
			</article>
		</div>
	</body>
</html>

<?php
	unset($_SESSION['error']);
?>