<?php
	session_start();

	if(empty($_SESSION['username'])){
		header("Location: groceryLogin.php");
	}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>Index Webpage</title>
		<link rel="stylesheet" href="styles.css" />
	</head>

	<script src="groceryList.js"></script>
	<body>
		<div class="page">
			<header class="menu-container">
				<h1 class="logo">
					<a class="logo-link" href="./index.php">Grocery App</a>
				</h1>
				<nav class="menu">
					<?php
						if($_SESSION['userType'] == "Admin"){
							echo '<li><a class="nav-link" href="./editAvailableItems.php">Admin</a></li>';
						}
					?>
					<li><a class="nav-link" href="./showStore.php">Add Item to Cart</a></li>
                    <li><a class="nav-link" href="./editProfilePage.php">My Profile</a></li>
					<li><a class="nav-link" href="./signOut.php">Sign Out</a></li>
				</nav>
			</header>

			<div class="groceryListContainer">
				<form action="updateList.php" class="tableContainer" method="post">
					<table id="groceryList">
                        <thead>
                            <tr>
                            	<th></th>
                            	<th>Quantity</th>
                                <th>Item</th>
                                <th>Item Price</th>
								<th></th>
								<th>Total Price</th>
                            </tr>
                        </thead>
                    	<tbody id="groceryList-body">
							<tr id="listTotal">
                            	<td></td>
                            	<td></td>
                                <td></td>
                                <td></td>
								<td></td>
								<td id="totalPrice">$0.00</td>
                            </tr>
						</tbody>


						<?php

							//path to the SQLite database file
							$db_file = './myDB/grocery.db';

							try {
								//open connection to the grocery database file
								$db = new PDO('sqlite:' . $db_file);

								//set errormode to use exceptions
								$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								if (!isset($_GET['s'])){
									//retrieve food items from all categories
									$username = $_SESSION['username'];
									$qry = "select * from UserCart natural join foodItem where username is '".$username."';";
									$result_set = $db->query($qry);


									// if cart is empty
									if (empty($result_set)){
										echo("<br>Cart is empty.");
									}
									else{
										foreach($result_set as $tuple){
											//addItem("#groceryList", inputNode.value, 1.0);
											echo '<script type="text/javascript"> 
											addItem("'.$tuple['foodID'].'", "'.$tuple['foodName'].'", '.$tuple['price'].', '.$tuple['quantity'].'); 
											</script>';
										}

									}
								}
								

								//disconnect from db
									$db = null;
							}
							catch(PDOException $e) {
								die('Exception : '.$e->getMessage());
							}
						?>
					</table>
					
					<input class="submit-button" type="submit" value=" Update " />
                </form>
				
				


			</div>
		</div>
	</body>
</html>
