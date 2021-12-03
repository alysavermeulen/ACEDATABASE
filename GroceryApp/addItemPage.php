<?php
session_start();
?>

<?php

if($_SESSION['userType'] != "Admin"){
    header("Location: showStore.php");
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Add Grocery Item</title>
		<link rel="stylesheet" href="styles.css" />
	</head>
	<body>
		<div class="page">
			<header class="menu-container">
				<h1 class="logo">
					<a class="logo-link" href="./index.html">Grocery App</a>
				</h1>
				<nav class="menu">
					<?php
						if($_SESSION['userType'] == "Admin"){
							echo '<li><a class="nav-link" href="editAvailableItems.php">Edit Available Grocery Items</a></li>';
						}
					?>
					<li><a class="nav-link" href="./groceryList.php">My Cart</a></li>
					<li><a class="nav-link" href="./groceryLogin.php">Sign Out</a></li>
				</nav>
			</header>

			<!--Title and Form-->
			<article class="content">
				<header class="title">
					<h2>Add Grocery Item</h2>
				</header>

				<!-- Form -->
				<form
					class="groceryForm"
					method="post"
					action="addItem.php"
				>
					<!-- firstName, lastName, username, password, email-->
					<label for="foodName">Food Name</label>
					<input
						class="textInput"
						type="text"
						name="foodName"
						pattern="^[a-zA-Z_ ]*${1,}"
						required
					/>

					<label for="price">Price (enter as decimal)</label>
					<input
						class="textInput"
						type="text"
						name="price"
						pattern="^[+-]?[0-9]{1,3}(?:,?[0-9]{3})*\.[0-9]{1,2}$"
						required
					/>

					<div>Category:</div><hr style="height:10px; visibility:hidden;" />
					<div><input type="radio" name="category" value="Beverages" required><label for="Beverages"> Beverages</label></div>
					<div><input type="radio" name="category" value="Cookies, Snacks, and Candy"><label for="Cookies, Snacks, and Candy"> Cookies, Snacks, and Candy</label><br></div>
					<div><input type="radio" name="category" value="Frozen Foods"><label for="Frozen Foods"> Frozen Foods</label></div>
					<div><input type="radio" name="category" value="Fruits"><label for="Fruits"> Fruits</label></div>
					<div><input type="radio" name="category" value="Vegetables"><label for="Vegetables"> Vegetables</label></div>
					<div><input type="radio" name="category" value="Grains and Pasta"><label for="Grains and Pasta"> Grains and Pasta</label></div>
					<div><input type="radio" name="category" value="Meat and Seafood"><label for="Meat and Seafood"> Meat and Seafood</label></div>
					<div><input type="radio" name="category" value="Dairy"><label for="Dairy"> Dairy</label></div>

					<input type="submit" value="Add Food Item" />

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
	unset($_SESSION['success']);
?>