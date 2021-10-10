<!DOCTYPE html>
<html>
<body>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  First: <input type="text" name="fname">
  Last: <input type="text" name="lname">
  SSN: <input type="text" name="snn">
  <input type="submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $snn = $_POST['snn'];
    if (empty($name)) {
        echo "Name is empty";
    } else {
        echo $fname;
        echo $lname;
        echo $snn;
    }
}
?>

</body>
</html>