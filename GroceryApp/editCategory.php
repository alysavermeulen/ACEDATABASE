<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>
<?php
 
    $editSuccess = "Description successfully edited!";


    // path to the SQLite database file
    $db_file = './myDB/grocery.db';

    try {
        // open connection to the grocery database file
        $db = new PDO('sqlite:' . $db_file);

        // set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare to update category info
        $qry = $db->prepare('UPDATE category SET name = ?, description = ? WHERE name = ?');
        $qry->bindParam(1, $name);
        $qry->bindParam(2, $description);
        $qry->bindParam(3, $name);

        $name = $_GET['name'];
        $description = 'NULL';
        if (!empty($_POST['description'])){
            $description = $_POST['description'];
        }

        // update category info
        $qry->execute();

        // set success message
        $_SESSION['success'] = $editSuccess;

        // disconnect from db
        $db = null;

        // redirect to editCategoryPage.php
        header("Location: addCategoryPage.php");

        exit();
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
?>

</body>
</html>