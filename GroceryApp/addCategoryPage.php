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
		<title>Add Food Category</title>
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
							echo '<li><a class="nav-link" href="editAvailableItems.php">Admin</a></li>';
						}
					?>
					<li><a class="nav-link" href="./groceryList.php">My Cart</a></li>
                    <li><a class="nav-link" href="./editProfilePage.php">My Profile</a></li>
					<li><a class="nav-link" href="./signOut.php">Sign Out</a></li>
				</nav>
			</header>

			<!--Title and Form-->
			<article class="content">
				<header class="title">
					<h2>Add Food Category</h2>
				</header>

				<!-- Form -->
				<form
					class="groceryForm"
					method="post"
					action="addCategory.php"
				>

					<!-- name, description-->
					<label for="name">Category Name</label>
					<input
						class="textInput"
						type="text"
						name="name"
						pattern="^[a-zA-Z_ ]*${1,}"
						required
					/>

					<label for="description">Category Description (optional, can leave empty)</label>
					<input
						class="textInput"
						type="text"
						name="description"
						pattern="^[a-zA-Z_ ]*${1,}"
					/>

					<input type="submit" value="Add Category" />

					<?php

		                if(isset($_SESSION['error'])){
		                    $error = $_SESSION['error'];
		                    echo "<br><span><b>$error</b></span><br>";
		                }

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
                        $description = "";
                        foreach($result_set as $tuple){
                        		if ($tuple['description'] == 'NULL'){
                        			$description = "[no description]";
                        		}
                        		else{
                        			$description = $tuple['description'];
                        		}
                                echo '<tr>
                                        <td>'.$tuple['name'].'</td>
                                        <td>'.$description.'</td>
                                        <td><a class="strong-button small" href="editCategoryPage.php?name='.$tuple['name'].'">Edit</a></td>
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
	unset($_SESSION['error']);
	unset($_SESSION['success']);
?>