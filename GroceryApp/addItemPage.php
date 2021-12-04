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
					<li><a class="nav-link" href="./signOut.php">Sign Out</a></li>
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

                            foreach($result_set as $tuple){
                                echo '<div><input type="radio" name="category" value="'.$tuple['name'].'" required>
                                	<label for="'.$tuple['name'].'"> '.$tuple['name'].'</label></div>';
                            }

                            //disconnect from db
                            $db = null;
                        }
                        catch(PDOException $e) {
                            die('Exception : '.$e->getMessage());
                        }

					?>

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