<?php
session_start();
?>

<!DOCTYPE html>
<html>

<?php

// get current username
$username = $_SESSION['username'];

// path to the SQLite database file
$db_file = './myDB/grocery.db';

try {
    // open connection to the grocery database file
    $db = new PDO('sqlite:' . $db_file);

    // set errormode to use exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare to fetch info of food item with this id
	$stmt = $db->prepare("select * from user where username = ?");

	// fetch info of user with this username
	$stmt->execute([$username]);
	$tuple = $stmt->fetch(PDO::FETCH_ASSOC);

	// define variables
	$firstName = $tuple['firstName'];
	$lastName = $tuple['lastName'];
	$password = $tuple['password'];

	// disconnect from db
    $db = null;
}
catch(PDOException $e){
	die('Exception : '.$e->getMessage());
}

?>

	<head>
		<meta charset="UTF-8" />
		<title>Edit Profile</title>
		<link rel="stylesheet" href="styles.css" />
	</head>
	<body>
		<div class="page">
			<header class="menu-container">
				<h1 class="logo">455: Database Systems</h1>
				<nav class="menu">
					<li class="dropdown">
						<span>Pages &#9662;</span>
						<ul class="features-menu">
							<!-- Start of submenu -->
							<li><a href="index.html">Home</a></li>
							<li><a href="passengerIndex.html">Airplane Passengers</a></li>
						</ul>
						<!-- End of submenu -->
					</li>
					<li><a href="index.html">Home</a></li>
				</nav>
			</header>

			<!--Title and Form-->
			<article class="content">
				<header class="title">
					<h2>Edit Profile</h2>
				</header>

				<div class="groceryForm">Please edit any fields you would like to update.</div>

				<!-- Form -->
				<form
					class="groceryForm"
					method="post"
					action="editProfile.php"
				>
					<!-- firstName, lastName, username, password, email-->
					<label for="firstName">First Name</label>
					<input
						class="textInput"
						type="text"
						name="firstName"
						value= "<?php echo "$firstName"; ?>"
						pattern="[A-Za-z]{1,}"
						required
					/>

					<label for="lastName">Last Name</label>
					<input
						class="textInput"
						type="text"
						name="lastName"
						value= "<?php echo "$lastName"; ?>"
						pattern="[A-Za-z]{1,}"
						required
					/>

					<label for="password">Password (can include numbers and/or letters)</label>
					<input
						class="textInput"
						type="text"
						name="password"
						value= "<?php echo "$password"; ?>"
						pattern="[A-Za-z0-9]{1,}"
						required
					/>

					<input type="submit" value="Update Info" />

					<?php
						if(isset($_SESSION['success'])){
							$success = $_SESSION['success'];
							echo "<br><span><b>$success</b></span>";
						}
					?>

				</form>
			</article>
		</div>
	</body>
</html>

<?php
	unset($_SESSION['error']);
?>