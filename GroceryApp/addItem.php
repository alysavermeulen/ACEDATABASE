<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>
<?php
    
    $addSuccess = "Item successfully added! <a href='showGroceryItems.php' style='color: #0b6fa6'>See updated list of available foods?</a></span>";

    // path to the SQLite database file
    $db_file = './myDB/grocery.db';

    try {
        // open connection to the airport database file
        $db = new PDO('sqlite:' . $db_file);

        // set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare to insert new info into foodItem 
        $qry = $db->prepare('INSERT INTO fooditem (foodID, foodName, price, category) VALUES (?, ?, ?, ?)');
        $qry->bindParam(1, $foodID);
        $qry->bindParam(2, $foodName);
        $qry->bindParam(3, $price);
        $qry->bindParam(4, $category);

        // find current max foodID to find next available foodID
        $result = $db->query("SELECT MAX(foodID) AS max_foodID FROM fooditem");
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // set values of input fields
        $foodID = $row['max_foodID'] + 1;
        $foodName = $_POST['foodName'];
        $price = $_POST['price'];
        $category = $_POST['category'];


        // insert new info into fooditem
        $qry->execute();

        // set success message
        $_SESSION['success'] = $addSuccess;

        // disconnect from db
        $db = null;

        // redirect to addItemPage.php
        header("Location: addItemPage.php");

        exit();
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
?>

</body>
</html>