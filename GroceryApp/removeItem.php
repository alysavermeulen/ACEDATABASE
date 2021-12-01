<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>
<?php

    $foodID = $_GET['foodID'];
    $removeSuccess = "Item successfully removed!";

    // path to the SQLite database file
    $db_file = './myDB/grocery.db';

    try {
        // open connection to the airport database file
        $db = new PDO('sqlite:' . $db_file);

        // set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare to delete this food item
        $stmt = $db->prepare("DELETE FROM fooditem WHERE foodID = ?");

	// delete food item
	$stmt->execute([$foodID]);

        // set success message
        $_SESSION['success'] = $removeSuccess;

        // disconnect from db
        $db = null;

        // redirect to removeItemPage.php
        header("Location: removeItemPage.php");

        exit();
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
?>

</body>
</html>