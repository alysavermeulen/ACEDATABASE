<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Show Passengers</title>
    <link rel="stylesheet" href="../styles.css" />
</head>
<body>
    <div class="page">
        <header class='menu-container'>
            <h1 class='logo'>455: Database Systems</h1>
            <nav class='menu'>
                <li class='dropdown'><span>Pages &#9662;</span>
                    <ul class='features-menu'>
                        <!-- Start of submenu -->
                      <li><a href='../index.html'>Proj1</a></li>
                      <li><a href="./passengerIndex.html">Proj2: Airplane Passengers</a></li>
                    </ul>                                
                    <!-- End of submenu -->
                </li>
                <li><a href='./passengerIndex.html'>Home</a></li>
            </nav>
        </header>
        <article class="content">

        <?php
            $message = ""; // default success message (empty)

            if(isset($_GET['success'])) { // if passenger info sucessfully added/updated
                $successType = $_GET['success'];
                if($successType == '1'){ // if passenger sucessfully added
                    $message = "New passenger successfully added!";
                }
                if($successType == '2'){ // if passenger sucessfully updated
                    $message = "Passenger information successfully updated!";
                }
                echo "$message";
                echo "<br>";
                echo "<br>";
            }
            if(isset($_GET['error'])) { // if ssn being updated was invalid
                $errorType = $_GET['error'];
                if($errorType == '1'){
                    $message = "No passenger with inputed SSN was found! Please reselect.";
                    echo "$message";
                    echo "<br>";
                    echo "<br>";
                }

            }​
        ?>

        <!--Title-->
            <header>
                <h2>Passengers</h2>
            </header>

            <!-- Passenger Table -->
            <div>
                <?php

                    //path to the SQLite database file
                    $db_file = './myDB/airport.db';

                    try {
                        //open connection to the airport database file
                        $db = new PDO('sqlite:' . $db_file);

                        //set errormode to use exceptions
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        //return all passengers, and store the result set
                        $qry = "select * from passengers;";
                        $result_set = $db->query($qry);

                        //print the table
                        echo '<br>
                            <table>
                                <thead>
                                    <tr>
                                    <th>First Name</th>
                                    <th>Middle Initial</th>
                                    <th>Last Name</th>
                                    <th>SSN</th>
                                    </tr>
                                </thead>
                                <tbody>';
                        foreach($result_set as $tuple){
                            echo '<tr>
                                    <td>'.$tuple['f_name'].'</td>
                                    <td>'.$tuple['m_name'].'</td>
                                    <td>'.$tuple['l_name'].'</td>
                                    <td>'.$tuple['ssn'].'</td>
                                    <td><a href="passengerForm.php?ssn='.$tuple['ssn'].'" style="color: #0b6fa6">Update</a></td>
                                </tr>';
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