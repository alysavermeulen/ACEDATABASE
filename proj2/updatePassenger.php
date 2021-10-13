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

        // prepare to update passenger info
        $qry = $db->prepare("UPDATE passengers SET f_name = ?, m_name = ?, l_name = ?, ssn = ? WHERE ssn = ?");
        $qry->bindParam(1, $f_name);
        $qry->bindParam(2, $m_name);
        $qry->bindParam(3, $l_name);
        $qry->bindParam(4, $ssn);
        $qry->bindParam(5, $ssn);

        // collect values of input fields
        $f_name = $_POST['f_name'];
        $m_name = $_POST['m_name'];
        $l_name = $_POST['l_name'];
        $ssn = $_POST['ssn'];

        if(empty($m_name)) {
            $m_name = null;
        }

        // update passenger info
        $qry->execute();

        // disconnect from db
        $db = null;

        // redirect to showPassengers.php
        header("Location: ./showPassengers.php?success=2");
        exit();
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
}
?>

</body>
</html>