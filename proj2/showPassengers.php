<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Show Passengers</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="page">
        <header class="menu-container">
            <h1 class="logo">455: Database Systems</h1>
            <nav class="menu">
                <li class="dropdown">
                    <span>Pages &#9662;</span>
                    <ul class="features-menu">
                        <!-- Start of submenu -->
                        <li><a href="index.html">Home</a></li>
                    </ul>
                    <!-- End of submenu -->
                </li>
                <li><a href="index.html">Home</a></li>
            </nav>
        </header>

        <!--Title and Form-->
        <article class="content">
            <header class="title">
                <h2>List of all tables</h2>
            </header>

            <!-- List -->
            <div>
                <?php


                    function displayHtmlTable($result_set, $tableName, $tableAttributes) {

                        $result = '<table>';
                        
                        //the header of the table
                        $result .= '<thead>';
                        $result .= '<tr>';
                        //create a header for each attribute
                        for ($index = 0; $index < count($tableAttributes); $index++){
                            $result .= '<td class="tableItem">' . $tableAttributes[$index] . '</td>';
                        }
                        $result .= '</tr>';
                        $result .= '</thead>';
                        
                        //the body of the table
                        $result .= '<tbody>';
                        //create a row for each tuple
                        foreach($result_set as $tuple) {
                            $result .= '<tr>';
                            //create an entry for each attribute
                            for ($index = 0; $index < count($tableAttributes); $index++){
                                $result .= '<td class="tableItem">' . $tuple[$index] . '</td>';
                            }
                            $result .= '</tr>';
                        }
                        $result .= '</tbody>';
                        $result .= '<table>';
                        
                
                        return $result;
                    }

                    //path to the SQLite database file
                    $db_file = './myDB/airport.db';

                    try {
                        //open connection to the airport database file
                        $db = new PDO('sqlite:' . $db_file);

                        //set errormode to use exceptions
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                        //----- Print out Passengers ---------
                        //return all passengers, and store the result set
                        $table = "passengers";
                        $query_str = "select * from \"$table\";";
                        $result_set = $db->query($query_str);
                        $attributes = array("f_name", "m_name", "l_name", "ssn");
                        echo displayHtmlTable($result_set, $table, $attributes);

                        //------ Print out planes ----------
                        //return all passengers, and store the result set
                        $table = "planes";
                        $query_str = "select * from \"$table\";";
                        $result_set = $db->query($query_str);
                        $attributes = array("tail_no", "make", "model", "capacity", "mph");
                        echo displayHtmlTable($result_set, $table, $attributes);


                        //------- Print out onboard ---------------------
                        //return all passengers, and store the result set
                        $table = "onboard";
                        $query_str = "select * from \"$table\";";
                        $result_set = $db->query($query_str);
                        $attributes = array("ssn", "flight_no", "seat");
                        echo displayHtmlTable($result_set, $table, $attributes);


                        //------- Print out flights ----------------------
                        //return all passengers, and store the result set
                        $query_str = "select * from flights;";
                        $result_set = $db->query($query_str);
                        $attributes = array("flight_no", "dep_loc", "dep_time", "arr_loc", "arr_time", "tail_no");
                        echo displayHtmlTable($result_set, "flights", $attributes);

                        //disconnect from db
                        $db = null;
                    }
                    catch(PDOException $e) {
                        die('Exception : '.$e->getMessage());
                    }
                ?>

            </div>
        </article>
        <!-- Footer -->
		<footer>
			<p>Authored by: Emilee Oquist, Colin Monaghan, and Alysa Vermeulen.</p>
		</footer>
    </div>
</body>
</html>