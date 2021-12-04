<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>
<?php
    
    $editSuccess = "User type successfully switched!";

    // path to the SQLite database file
    $db_file = './myDB/grocery.db';

    try {
        // open connection to the grocery database file
        $db = new PDO('sqlite:' . $db_file);

        // set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = $_GET['username'];

        // prepare to fetch user info
        $stmt = $db->prepare("select * from user where username = ?");

        // fetch info of user with this username
        $stmt->execute([$username]);
        $tuple = $stmt->fetch(PDO::FETCH_ASSOC);

        $userType = $tuple['userType'];
        $newUserType = 'Admin';
        if ($userType == 'Admin'){
            $newUserType = 'User';
        }

        // prepare to update profile info
        $qry = $db->prepare('UPDATE user SET firstName = ?, lastName = ?, username = ?, password = ?, userType = ? WHERE username = ?');
        $qry->bindParam(1, $firstName);
        $qry->bindParam(2, $lastName);
        $qry->bindParam(3, $inputUsername);
        $qry->bindParam(4, $password);
        $qry->bindParam(5, $userType);
        $qry->bindparam(6, $currentUsername);

        // set values of input fields
        $firstName = $tuple['firstName'];
        $lastName = $tuple['lastName'];
        $inputUsername = $tuple['username'];
        $password = $tuple['password'];
        $userType = $newUserType;
        $currentUsername = $tuple['username'];

        // update food item info
        $qry->execute();

        // set success message
        $_SESSION['success'] = $editSuccess;

        // disconnect from db
        $db = null;

        // redirect to editUserTypesPage.php
        header("Location: editUserTypesPage.php");

        exit();
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
?>

</body>
</html>