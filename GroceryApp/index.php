<?php
session_start();

if(isset($_SESSION['username'])) {
    header("Location: groceryList.php");
}
else {
    header("Location: groceryLogin.php");
}
?>