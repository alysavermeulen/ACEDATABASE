<!DOCTYPE html>
<html>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // path to the SQLite database file
    $db_file = './myDB/airport.db';

    try {
        // open connection to the airport database file
        $db = new PDO('sqlite:' . $db_file);

        // set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare to insert new info into passengers 
        $qry = $db->prepare('INSERT INTO passengers (f_name, m_name, l_name, ssn) VALUES (?, ?, ?, ?)');
        $qry->bindParam(1, $f_name);
        $qry->bindParam(2, $m_name);
        $qry->bindParam(3, $l_name);
        $qry->bindParam(4, $ssn);

        // collect values of input fields
        $f_name = $_POST['f_name'];
        $m_name = $_POST['m_name'];
        $l_name = $_POST['l_name'];
        $ssn = $_POST['ssn'];

        if(empty($m_name)) {
            $m_name = null;
        }

        // insert new info into passengers
        $qry->execute();

        // disconnect from db
        $db = null;

        // redirect to showPassengers.php
        header("Location: http://localhost/showPassengers.php?success=1");
        exit();
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
}
?>

</body>
</html>