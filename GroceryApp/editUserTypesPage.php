<?php
session_start();
?>

<?php

if($_SESSION['userType'] != "Admin"){
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
            <h1 class="logo">455: Database Systems</h1>
            <nav class="menu">
                <?php

                if($_SESSION['userType'] == "Admin"){
                    echo '<li><a href="editAvailableItems.php">Edit Available Grocery Items</a></li>';
                }

                ?>
                <li class="dropdown">
                    <span>Pages &#9662;</span>
                    <ul class="features-menu">
                        <!-- Start of submenu -->
                        <li><a href="index.html">Home</a></li>
                        <li><a href="passengerIndex.html">Airplane Passengers</a></li>
                    </ul>
                    <!-- End of submenu -->
                </li>
                <li><a href="index.html">Home</a></li>
                <li><a href="signOut.php">Sign Out</a></li>
            </nav>
        </header>
        <article class="content">

        <!--Title-->
            <header>
                <h2>Edit User Types</h2>
            </header>

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
                                    <th>LastName</th>
                                    <th>Username</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        $message = "Switch to Admin";
                        foreach($result_set as $tuple){
                            if ($tuple['username'] != $_SESSION['username']){
                                if ($tuple['userType'] == "Admin"){
                                    $message = "Switch to Standard User";
                                }
                                echo '<tr>
                                        <td>'.$tuple['firstName'].'</td>
                                        <td>'.$tuple['last Name'].'</td>
                                        <td>'.$tuple['username'].'</td>
                                        <td><a href="editUserType.php?foodID='.$tuple['username'].'" style="color: #0b6fa6">'.$message.'</a></td>
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