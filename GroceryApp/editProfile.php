<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>
<?php
    
    $editSuccess = "Profile info successfully updated!";

    // path to the SQLite database file
    $db_file = './myDB/grocery.db';

    try {
        // open connection to the airport database file
        $db = new PDO('sqlite:' . $db_file);

        // set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare to update profile info
        $qry = $db->prepare('UPDATE user SET firstName = ?, lastName = ?, username = ?, password = ?, userType = ? WHERE username = ?');
        $qry->bindParam(1, $firstName);
        $qry->bindParam(2, $lastName);
        $qry->bindParam(3, $inputUsername);
        $qry->bindParam(4, $password);
        $qry->bindParam(5, $userType);
        $qry->bindparam(6, $currentUsername);

        // set values of input fields
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $inputUsername = $_SESSION['username'];
        $password = $_POST['password'];
        $userType = $_SESSION['userType'];
        $currentUsername = $_SESSION['username'];

        // update food item info
        $qry->execute();

        // set success message
        $_SESSION['success'] = $editSuccess;

        // disconnect from db
        $db = null;

        // redirect to editProfilePage.php
        header("Location: editProfilePage.php");
        }

        exit();
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
?>

</body>
</html>