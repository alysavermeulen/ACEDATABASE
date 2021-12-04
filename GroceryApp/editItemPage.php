<?php
	session_start();

	if(empty($_SESSION['username'])){
		header("Location: groceryLogin.php");
	}

	else if($_SESSION['userType'] != "Admin"){
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
				<h1 class="logo">
					<a class="logo-link" href="./index.php">Grocery App</a>
				</h1>
				<nav class="menu">
					<?php
						if($_SESSION['userType'] == "Admin"){
							echo '<li><a class="nav-link" href="editAvailableItems.php">Edit Available Grocery Items</a></li>';
						}
					?>
					<li><a class="nav-link" href="./groceryList.php">My Cart</a></li>
					<li><a class="nav-link" href="./signOut.php">Sign Out</a></li>
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
					<?php

						//path to the SQLite database file
                        $db_file = './myDB/grocery.db';

                        try {
                            //open connection to the grocery database file
                            $db = new PDO('sqlite:' . $db_file);

                            //set errormode to use exceptions
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $qry = "select * from category order by name;";
                            $result_set = $db->query($qry);

                            $checked = "";
                            foreach($result_set as $tuple){
                            	if ($category == $tuple['name']){
                            		$checked = "checked";
                            	}
                                echo '<div><input type="radio" name="category" value="'.$tuple['name'].'" '.$checked.' required>
                                	<label for="'.$tuple['name'].'"> '.$tuple['name'].'</label></div>';
                                if ($category == $tuple['name']){
                            		$checked = "";
                            	}
                            }

                            //disconnect from db
                            $db = null;
                        }
                        catch(PDOException $e) {
                            die('Exception : '.$e->getMessage());
                        }

					?>

					<input type="submit" value="Edit Food Item" />

				</form>
			</article>
		</div>
	</body>
</html>