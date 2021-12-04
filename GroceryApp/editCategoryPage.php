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
if (empty($_GET['name'])){
	header("Location: addCategoryPage.php");
}
$categoryName = $_GET['name'];
$categoryError = "Invalid category (please select a category from the list below).";

// path to the SQLite database file
$db_file = './myDB/grocery.db';

try {
    // open connection to the airport database file
    $db = new PDO('sqlite:' . $db_file);

    // set errormode to use exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare to fetch info of food item with this id
	$stmt = $db->prepare("select * from category where name = ?");

	// fetch info of category with this name
	$stmt->execute([$categoryName]);
	$tuple = $stmt->fetch(PDO::FETCH_ASSOC);

	// if category was invalid (if no category with this name)
	if (empty($tuple)){
		$_SESSION['error'] = $categoryError;
		$db = null;
		header("Location: addCategoryPage.php");
	}

	// if category was valid, define variables
	$categoryName = $tuple['name'];
	$description = $tuple['description'];
	if ($description == 'NULL'){
		$description = "";
	}

	// disconnect from db
    $db = null;
}
catch(PDOException $e){
	die('Exception : '.$e->getMessage());
}

?>
	<head>
		<meta charset="UTF-8" />
		<title>Edit Category Description</title>
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
					<h2>Edit Category Description</h2>
				</header>

				<!-- Form -->
				<form
					class="groceryForm"
					method="post"
					action="editCategory.php?name=<?php echo "$categoryName"; ?>"
				>

				<div>Editing description for: <b><?php echo "$categoryName"; ?></b></div><br>

					<!-- description-->

					<label for="description">Category Description (optional, can leave empty)</label>
					<input
						class="textInput"
						type="text"
						name="description"
						value= "<?php echo "$description"; ?>"
						pattern="^[a-zA-Z_ ]*${1,}"
					/>

					<input type="submit" value="Edit Description" />

					<?php

						if(isset($_SESSION['success'])){
							$success = $_SESSION['success'];
							echo "<br><span><b>$success</b></span><br>";
						}
					?>

					<br><div>Current Categories and Descriptions:</div><hr style="height:10px; visibility:hidden;" />
					<?php

                    //path to the SQLite database file
                    $db_file = './myDB/grocery.db';

                    try {
                        //open connection to the grocery database file
                        $db = new PDO('sqlite:' . $db_file);

                        //set errormode to use exceptions
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        //retrieve food items from all categories
                        $qry = "select * from category order by name;";
                        $result_set = $db->query($qry);

                        //print the table
                        echo '<br>
                            <table>
                                <thead>
                                    <tr>
                                    <th>Category Name</th>
                                    <th>Category Description</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        foreach($result_set as $tuple){
                                echo '<tr>
                                        <td>'.$tuple['name'].'</td>
                                        <td>'.$tuple['description'].'</td>
                                        <td><a href="editCategoryPage.php?name='.$tuple['name'].'" style="color: #0b6fa6">Edit Description</a></td>
                                    </tr>';
                        }
                        echo '</tbody>
                            </table>';

                        //disconnect from db
                            $db = null;
                    }
                    catch(PDOException $e) {
                        die('Exception : '.$e->getMessage());
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