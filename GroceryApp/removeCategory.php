<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>
<?php

    $categoryName = $_GET['name'];
    $removeSuccess = "Category successfully removed!";

    // path to the SQLite database file
    $db_file = './myDB/grocery.db';

    try {
        // open connection to the airport database file
        $db = new PDO('sqlite:' . $db_file);

        // set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare to delete this food item
        $stmt = $db->prepare("DELETE FROM category WHERE name = ?");

	// delete food item
	$stmt->execute([$categoryName]);

        // set success message
        $_SESSION['success'] = $removeSuccess;

        // disconnect from db
        $db = null;

        // redirect to addCategoryPage.php
        header("Location: addCategoryPage.php");

        exit();
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
?>

</body>
</html>