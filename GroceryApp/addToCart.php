<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>
<?php
    
    $foodID = $_GET['foodID'];
    $username = $_SESSION['username'];

    // path to the SQLite database file
    $db_file = './myDB/grocery.db';

    try {
        // open connection to the airport database file
        $db = new PDO('sqlite:' . $db_file);

        // set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare to fetch food item info from user cart
        $stmt = $db->prepare("select * from usercart where foodID = ? AND username = ?");

        // fetch info of food item with this id (if item already exists in user cart)
        $stmt->execute([$foodID, $username]);
        $tuple = $stmt->fetch(PDO::FETCH_ASSOC);

        // if food item with this id already exists in this user's cart
        if (!empty($tuple)){

            $oldQuantity = $tuple['quantity'];

            $stmt = $db->prepare('UPDATE usercart set quantity = ? where foodID = ? AND username = ?');

            $quantity = $_POST['quantity'] + $oldQuantity;
            $foodID = $_GET['foodID'];
            $username = $_SESSION['username'];

            $stmt->execute([$quantity, $foodID, $username]);

            // disconnect from db
            $db = null;

            // redirect to groceryList.php
            header("Location: groceryList.php");
        }

        // if food item with id does not already exist in this user's cart
        else{

            // prepare to insert new info into usercart 
            $qry = $db->prepare('INSERT INTO usercart (foodID, username, quantity) VALUES (?, ?, ?)');
            $qry->bindParam(1, $foodID);
            $qry->bindParam(2, $username);
            $qry->bindParam(3, $quantity);

            // collect values of input fields
            $foodID = $_GET['foodID'];
            $username = $_SESSION['username'];
            $quantity = $_POST['quantity'];

            // insert new info into usercart
            $qry->execute();

            // disconnect from db
            $db = null;

            // redirect to groceryList.php
            header("Location: groceryList.php");

        }

        exit();
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
?>

</body>
</html>