<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>Index Webpage</title>
		<link rel="stylesheet" href="styles.css" />
	</head>

	<body>
		<div class="page">
			<header class="menu-container">
				<h1 class="logo">
					<a class="logo-link" href="./index.html">Grocery App</a>
				</h1>
				<nav class="menu">
					<li><a class="nav-link" href="./groceryLogin.php">Sign Out</a></li>
				</nav>
			</header>

			<div>
				<ul id="groceryList">
					<li class="list-item" id="total">
						<div class="checkboxAndName">
							<span></span>
						</div>
						<p id="totalPrice">$0.00</p>
					</li>
				</ul>
				
				<script src="groceryList.js"></script>
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
							$username = 'cmonaghan';
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
									console.log("'.$tuple['foodName'].'");
									addItem("#groceryList","'.$tuple['foodName'].'", '.$tuple['price'].'); 
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

			</div>
			<footer>
				<p>Authored by: Colin Monaghan and Alysa Vermeulen.</p>
			</footer>
		</div>
	</body>
</html>
