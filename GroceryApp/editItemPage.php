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

<?php

// get foodID from URL
$foodID = $_GET['foodID'];
$iderror = "Invalid food ID (please select an item from the list below).";

// path to the SQLite database file
$db_file = './myDB/grocery.db';

try {
    // open connection to the airport database file
    $db = new PDO('sqlite:' . $db_file);

    // set errormode to use exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare to fetch info of food item with this id
	$stmt = $db->prepare("select * from fooditem where foodID = ?");

	// fetch info of food item with this id
	$stmt->execute([$foodID]);
	$tuple = $stmt->fetch(PDO::FETCH_ASSOC);

	// if foodID was invalid (if no food item with this id)
	if (empty($tuple)){
		$_SESSION['error'] = $iderror;
		$db = null;
		header("Location: editItemSearch.php");
	}

	// if foodID was valid, define variables
	$foodName = $tuple['foodName'];
	$price = $tuple['price'];
	$category = $tuple['category'];

	// disconnect from db
    $db = null;
}
catch(PDOException $e){
	die('Exception : '.$e->getMessage());
}

?>
	<head>
		<meta charset="UTF-8" />
		<title>Edit Grocery Item</title>
		<link rel="stylesheet" href="styles.css" />
	</head>
	<body>
		<div class="page">
			<header class="menu-container">
				<h1 class="logo">455: Database Systems</h1>
				<nav class="menu">
			        <?php

	                if($_SESSION['userType'] == "Admin"){
	                    echo '<li><a href="editAvailableItems.php">Edit Available Grocery Items</a></li>';
	                }

	                ?>
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
					<li><a href="signOut.php">Sign Out</a></li>
				</nav>
			</header>

			<!--Title and Form-->
			<article class="content">
				<header class="title">
					<h2>Edit Grocery Item</h2>
				</header>

				<!-- Form -->
				<form
					class="groceryForm"
					method="post"
					action="editItem.php?foodID=<?php echo "$foodID"; ?>"
				>
					<!-- firstName, lastName, username, password, email-->
					<label for="foodName">Food Name</label>
					<input
						class="textInput"
						type="text"
						name="foodName"
						value= "<?php echo "$foodName"; ?>"
						pattern="^[a-zA-Z_ ]*${1,}"
						required
					/>

					<label for="price">Price (enter as decimal)</label>
					<input
						class="textInput"
						type="text"
						name="price"
						value= "<?php echo "$price"; ?>"
						pattern="^[+-]?[0-9]{1,3}(?:,?[0-9]{3})*\.[0-9]{1,2}$"
						required
					/>

					<div>Category:</div><hr style="height:10px; visibility:hidden;" />
					<div><input type="radio" name="category" value="Beverages" 
						<?php echo ($category == "Beverages") ? 'checked="checked"':'';?>
    					required><label for="Beverages"> Beverages</label></div>
					<div><input type="radio" name="category" value="Cookies, Snacks, and Candy" 
						<?php echo ($category == "Cookies, Snacks, and Candy") ? 'checked="checked"':'';?>>
    					<label for="Cookies, Snacks, and Candy"> Cookies, Snacks, and Candy</label><br></div>
					<div><input type="radio" name="category" value="Frozen Foods" 
						<?php echo ($category == "Frozen Foods") ? 'checked="checked"':'';?>>
    					<label for="Frozen Foods"> Frozen Foods</label></div>
					<div><input type="radio" name="category" value="Fruits" 
						<?php echo ($category == "Fruits") ? 'checked="checked"':'';?>>
    					<label for="Fruits"> Fruits</label></div>
					<div><input type="radio" name="category" value="Vegetables" 
						<?php echo ($category == "Vegetables") ? 'checked="checked"':'';?>>
    					<label for="Vegetables"> Vegetables</label></div>
					<div><input type="radio" name="category" value="Grains and Pasta" 
						<?php echo ($category == "Grains and Pasta") ? 'checked="checked"':'';?>>
    					<label for="Grains and Pasta"> Grains and Pasta</label></div>
					<div><input type="radio" name="category" value="Meat and Seafood" 
						<?php echo ($category == "Meat and Seafood") ? 'checked="checked"':'';?>>
    					<label for="Meat and Seafood"> Meat and Seafood</label></div>
    				<div><input type="radio" name="category" value="Dairy" 
						<?php echo ($category == "Dairy") ? 'checked="checked"':'';?>>
    					<label for="Dairy"> Dairy</label></div>

					<input type="submit" value="Edit Food Item" />

				</form>
			</article>
		</div>
	</body>
</html>