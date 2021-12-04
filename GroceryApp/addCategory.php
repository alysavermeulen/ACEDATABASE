<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>
<?php
    
    $categoryName = $_POST['name'];
    $addSuccess = "Category successfully added!";
    $categoryError = "Category name already taken. Please choose a unique category name.";

    // path to the SQLite database file
    $db_file = './myDB/grocery.db';

    try {
        // open connection to the grocery database file
        $db = new PDO('sqlite:' . $db_file);

        // set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare to fetch category info
        $stmt = $db->prepare("select * from category where name = ?");

        // fetch info of category with this name (if category exists)
        $stmt->execute([$categoryName]);
        $tuple = $stmt->fetch(PDO::FETCH_ASSOC);

        // if category with this name already exists
        if (!empty($tuple)){
            $_SESSION['error'] = $categoryError;
            $db = null;
            header("Location: addCategoryPage.php");
        }

        // if category name is available
        else{

            // prepare to insert new info into category 
            $qry = $db->prepare('INSERT INTO category (name, description) VALUES (?, ?)');
            $qry->bindParam(1, $name);
            $qry->bindParam(2, $description);

            $name = $_POST['name'];
            $description = 'NULL';
            if (!empty($_POST['description'])){
                $description = $_POST['description'];
            }

            // insert new info into fooditem
            $qry->execute();

            // set success message
            $_SESSION['success'] = $addSuccess;

            // disconnect from db
            $db = null;

            // redirect to addItemPage.php
            header("Location: addCategoryPage.php");
        }

        exit();
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
?>

</body>
</html>