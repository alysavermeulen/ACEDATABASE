<?php
    session_start();

    if(empty($_SESSION['username'])){
        header("Location: groceryLogin.php");
    }

    else if($_SESSION['userType'] != "Admin"){
        header("Location: showStore.php");
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Edit User Types</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
<div class="page">
        <header class="menu-container">
                <h1 class="logo">
                    <a class="logo-link" href="./index.php">Grocery App</a>
                </h1>
                <nav class="menu">
                    <?php
                        if($_SESSION['userType'] == "Admin"){
                            echo '<li><a class="nav-link" href="editAvailableItems.php">Admin</a></li>';
                        }
                    ?>
                    <li><a class="nav-link" href="./groceryList.php">My Cart</a></li>
                    <li><a class="nav-link" href="./editProfilePage.php">My Profile</a></li>
                    <li><a class="nav-link" href="./signOut.php">Sign Out</a></li>
                </nav>
        </header>
        <article class="content">

        <!--Title-->
            <header>
                <h2>Edit User Types</h2>
            </header>

            <?php
                if(isset($_SESSION['success'])){
                    $success = $_SESSION['success'];
                    echo "<br><span><b>$success</b></span>";
                }
            ?>

            <!-- Show All Users and Types (User Table)-->
            <div>
                <?php

                    //path to the SQLite database file
                    $db_file = './myDB/grocery.db';

                    try {
                        //open connection to the grocery database file
                        $db = new PDO('sqlite:' . $db_file);

                        //set errormode to use exceptions
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        //retrieve food items from all categories
                        $qry = "select * from user order by firstName;";
                        $result_set = $db->query($qry);

                        //print the table
                        echo '<br>
                            <table>
                                <thead>
                                    <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                    <th>User Type</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        $message = "Switch to Admin";
                        foreach($result_set as $tuple){
                            if ($tuple['username'] != $_SESSION['username']){
                                if ($tuple['userType'] == "Admin"){
                                    $message = "Switch to Standard User";
                                }
                                else{
                                    $message = "Switch to Admin";
                                }
                                echo '<tr>
                                        <td>'.$tuple['firstName'].'</td>
                                        <td>'.$tuple['lastName'].'</td>
                                        <td>'.$tuple['username'].'</td>
                                        <td>'.$tuple['userType'].'</td>
                                        <td><a class="strong-button small" href="editUserType.php?username='.$tuple['username'].'">'.$message.'</a></td>
                                    </tr>';
                            }
                        }
                        echo '</tbody>
                            </table>';

                        //disconnect from db
                            $db = null;
                    }
                    catch(PDOException $e) {
                        die('Exception : '.$e->getMessage());
                    }
                ?>

            </div>
        </article>
    </div>
</body>
</html>

<?php
    unset($_SESSION['success']);
?>