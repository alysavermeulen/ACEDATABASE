<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>
<?php
    
    $username = $_SESSION['username'];

    // path to the SQLite database file
    $db_file = './myDB/grocery.db';

    try {
        // open connection to the airport database file
        $db = new PDO('sqlite:' . $db_file);

        // set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare to fetch food item info from user cart
        $qry = "select * from UserCart natural join foodItem where username is '".$username."';";
        $result_set = $db->query($qry);
        

        foreach($result_set as $tuple){
            //get the name of the food in the user's cart
            $foodID = $tuple['foodID'];
            //use the name to retrieve the new quantity from the cart
            $newQuantity = $_POST[$foodID];
            $oldQuantity = $tuple['quantity'];
            
            // if quantity == 0, delete the item from the cart
            if($newQuantity == 0) {
                // prepare to delete the item from usercart 
                $stmt = $db->prepare('DELETE FROM usercart where foodId = ? AND username = ?');

                $stmt->execute([$foodID, $username]);
            }
            // otherwise update the cart with the new quantity
            else if($newQuantity != $oldQuantity) {

                // prepare to update the new quantity into usercart 
                $stmt = $db->prepare('UPDATE usercart SET quantity = ? WHERE foodId = ? AND username = ?');

                $stmt->execute([$newQuantity, $foodID, $username]);
            }



        }
        // disconnect from db
        $db = null;

        // redirect to groceryList.php
        header("Location: groceryList.php");
        exit();
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
?>

</body>
</html>