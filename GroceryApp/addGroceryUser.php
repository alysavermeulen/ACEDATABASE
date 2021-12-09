<?php
session_start();
?>

<!DOCTYPE html>
<html>
<body>

<?php
    
    $username = $_POST['username'];
    $usererror = "Username already taken (please choose a unique username).";

    // path to the SQLite database file
    $db_file = './myDB/grocery.db';

    try {
        // open connection to the grocery database file
        $db = new PDO('sqlite:' . $db_file);

        // set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare to fetch user info
        $stmt = $db->prepare("select * from user where username = ?");

		// fetch info of user with this username (if user exists)
		$stmt->execute([$username]);
		$tuple = $stmt->fetch(PDO::FETCH_ASSOC);

		// if user with this username already exists
		if (!empty($tuple)){
			$_SESSION['error'] = $usererror;
        	$db = null;
			header("Location: grocerySignup.php");
		}

		// if username is available
		else{
	        // prepare to insert new user info 
	        $qry = $db->prepare('INSERT INTO user (firstName, lastName, username, password, userType) VALUES (?, ?, ?, ?, ?)');
	        $qry->bindParam(1, $firstName);
	        $qry->bindParam(2, $lastName);
	        $qry->bindParam(3, $username);
	        $qry->bindParam(4, $password);
	        $qry->bindParam(5, $userType);

	        // collect values of input fields
	        $firstName = $_POST['firstName'];
	        $lastName = $_POST['lastName'];
	        $username = $_POST['username'];
	        $password = $_POST['password'];
	        $userType = 'User';

	        // insert new info into user
	        $qry->execute();

        	$db = null;
	        header("Location: groceryLogin.php");
    	}

        exit();
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
?>

</body>
</html>