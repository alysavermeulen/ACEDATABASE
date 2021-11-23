<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Show Grocery Items</title>
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
        <article class="content">

        <!--Title-->
            <header>
                <h2>Grocery Items</h2>
            </header>

            <!-- Show All Food Items -->
            <br>
            <div>
                <a href="showGroceryItems.php" style="color: #0b6fa6">Show all food items</a>
            </div>

            <!-- Search Bar -->
            <br>
            <div>
                <form action="showGroceryItems.php" method="get">
                    <label for="s">Search all food items:</label>
                    <input type="search" name="s" required>
                    <input type="submit" value=" Submit " />
                </form>
            </div>
            
            <!-- Category Selection -->
            <br>
            <div class="dropdown">
                    <span>Category Selection &#9662;</span>
                    <div class="category-menu">
                        <!-- Start of submenu -->
                        <form action="showGroceryItems.php" method="post">
                          <li><input type="checkbox" name="categories[]" value="Beverages" /> Beverages</li>
                          <li><input type="checkbox" name="categories[]" value="Cookies, Snacks, and Candy" /> Cookies, Snacks, and Candy</li>
                          <li><input type="checkbox" name="categories[]" value="Frozen Foods" /> Frozen Foods</li>
                          <li><input type="checkbox" name="categories[]" value="Fruits" /> Fruits</li>
                          <li><input type="checkbox" name="categories[]" value="Vegetables" /> Vegetables</li>
                          <li><input type="checkbox" name="categories[]" value="Grains and Pasta" /> Grains and Pasta</li>
                          <li><input type="checkbox" name="categories[]" value="Meat and Seafood" /> Meat and Seafood</li>
                          <li><input type="submit" value=" Submit " /></li>
                        </form>
                    </div>
                    <!-- End of submenu -->
            </div>

            <!-- Grocery Table -->
            <div>
                <?php

                    //path to the SQLite database file
                    $db_file = './myDB/grocery.db';

                    try {
                        //open connection to the grocery database file
                        $db = new PDO('sqlite:' . $db_file);

                        //set errormode to use exceptions
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        if (isset($_GET['s'])) {
                            $searchTerm = $_GET['s'];
                            $stmt = $db->prepare("select * from foodItem where foodName like ? order by category");
                            $stmt->execute(["%".$_GET["s"]."%"]);
                            $t = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // if no food item similar to search query
                            if (empty($t)){
                                echo("<br>No food item found.");
                            }
                            else{
                                echo '<br>
                                <table>
                                    <thead>
                                        <tr>
                                        <th>Food Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                foreach($t as $tuple){
                                    echo '<tr>
                                            <td>'.$tuple['foodName'].'</td>
                                            <td>'.$tuple['price'].'</td>
                                            <td>'.$tuple['category'].'</td>
                                            <form action="addGroceryItem.php?foodID='.$tuple['foodID'].'" method="post">
                                            <td><input type="number" name = "quantity" value="1" min="1" style="width: 4em"></td>
                                            <td><input type="submit" value=" Add to grocery list "></td>
                                            </form>
                                        </tr>';
                                }
                                echo '</tbody>
                                </table>';

                            }
                        }

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                            //if no food categories selected
                            if(empty($_POST['categories'])){
                                echo("<br>No food categories selected.");
                            }

                            //if categories selected, print the corresponding table
                            else{
                                echo '<br>
                                <table>
                                    <thead>
                                        <tr>
                                        <th>Food Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                //retrieve foods from selected categories
                                $categoriesChosen = $_POST['categories'];
                                $N = count($categoriesChosen);
                                for($i=0; $i < $N; $i++){
                                    $c = $categoriesChosen[$i];
                                    $qry = "select * from foodItem where category = '$c';";
                                    $result_set = $db->query($qry);
                                    foreach($result_set as $tuple){
                                        echo '<tr>
                                                <td>'.$tuple['foodName'].'</td>
                                                <td>'.$tuple['price'].'</td>
                                                <td>'.$tuple['category'].'</td>
                                                <form action="addGroceryItem.php?foodID='.$tuple['foodID'].'" method="post">
                                                <td><input type="number" name = "quantity" value="1" min="1" style="width: 4em"></td>
                                                <td><input type="submit" value=" Add to grocery list "></td>
                                                </form>
                                            </tr>';
                                    }
                                }
                                echo '</tbody>
                                    </table>';
                            }
                        }
                        else if (!isset($_GET['s'])){
                            //retrieve food items from all categories
                            $qry = "select * from foodItem order by category;";
                            $result_set = $db->query($qry);

                            //print the table
                            echo '<br>
                                <table>
                                    <thead>
                                        <tr>
                                        <th>Food Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                            foreach($result_set as $tuple){
                                echo '<tr>
                                        <td>'.$tuple['foodName'].'</td>
                                        <td>'.$tuple['price'].'</td>
                                        <td>'.$tuple['category'].'</td>
                                        <form action="addGroceryItem.php?foodID='.$tuple['foodID'].'" method="post">
                                        <td><input type="number" name = "quantity" value="1" min="1" style="width: 4em"></td>
                                        <td><input type="submit" value=" Add to grocery list "></td>
                                        </form>
                                    </tr>';
                            }
                            echo '</tbody>
                                </table>';
                        }
                        //disconnect from db
                            $db = null;
                    }
                    catch(PDOException $e) {
                        die('Exception : '.$e->getMessage());
                    }
                ?>

            </div>
        </article>
    </div>
</body>
</html>