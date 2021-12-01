<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>
<?php
    
    $editSuccess = "Item successfully edited!";

    // path to the SQLite database file
    $db_file = './myDB/grocery.db';

    try {
        // open connection to the airport database file
        $db = new PDO('sqlite:' . $db_file);

        // set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare to update food item info
        $qry = $db->prepare('UPDATE fooditem SET foodID = ?, foodName = ?, price = ?, category = ? WHERE foodID = ?');
        $qry->bindParam(1, $foodID);
        $qry->bindParam(2, $foodName);
        $qry->bindParam(3, $price);
        $qry->bindParam(4, $category);
        $qry->bindParam(5, $foodID);

        // set values of input fields
        $foodID = $_GET['foodID'];
        $foodName = $_POST['foodName'];
        $price = $_POST['price'];
        $category = $_POST['category'];

        // update food item info
        $qry->execute();

        // set success message
        $_SESSION['success'] = $editSuccess;

        // disconnect from db
        $db = null;

        // redirect to editItemSearch.php
        header("Location: editItemSearch.php");

        exit();
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
?>

</body>
</html>