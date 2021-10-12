<!DOCTYPE html>
<html>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    //path to the SQLite database file
    $db_file = './myDB/airport.db';

    // collect value of input field
    $f_name = $_POST['f_name'];
    $m_name = $_POST['m_name'];
    $l_name = $_POST['l_name'];
    $ssn = $_POST['ssn'];

    //check for errors
    if (empty($f_name) || empty($l_name) || empty($ssn)) {
        echo "A field is empty";
    } 
    else {
        
        if(empty($m_name)) {
            $m_name = null;
        }
        try {
            //open connection to the airport database file
            $db = new PDO('sqlite:' . $db_file);

            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //insert new info into passengers 
            $qry = $db->prepare('INSERT INTO passengers (f_name, m_name, l_name, ssn) VALUES (?, ?, ?, ?)');
            $qry->execute(array($f_name, $m_name, $l_name, $ssn));

            //disconnect from db
            $db = null;

            //redirect to showPassengers.php
            header("Location: http://localhost/showPassengers.php");
            exit();
        }
        catch(PDOException $e) {
            die('Exception : '.$e->getMessage());
        }
    }
}
?>

</body>
</html>