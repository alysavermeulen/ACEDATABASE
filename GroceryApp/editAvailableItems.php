<?php
session_start();
?>

<?php

if($_SESSION['userType'] != "Admin"){
    header("Location: showStore.php");
}

?>

<!DOCTYPE html>
<head>
    <meta charset='UTF-8' />
    <title>Edit Available Grocery Items</title>
    <link rel='stylesheet' href='styles.css' />
</head>

<body>
    <div class='page'>
        <header class='menu-container'>
            <h1 class='logo'>455: Database Systems</h1>
            <nav class='menu'>
                <?php

                if($_SESSION['userType'] == "Admin"){
                    echo '<li><a href="editAvailableItems.php">Edit Available Grocery Items</a></li>';
                }

                ?>
                <li class='dropdown'><span>Pages &#9662;</span>
                    <ul class='features-menu'>
                        <!-- Start of submenu -->
                      <li><a href='index.html'>Home</a></li>
                      <li><a href="passengerIndex.html">Airplane Passengers</a></li>
                    </ul>                                
                    <!-- End of submenu -->
                </li>
                <li><a href='index.html'>Home</a></li>
            </nav>
        </header>


        <article class='content'>

            <section>
                <h2>Edit Available Grocery Items</h2>
                <br>
                <br>
                <nav>
                    <ul>
                        <li><a href="addItemPage.php" style="color: #0b6fa6">Add Grocery Item</a></li>
                        <li><a href="editItemSearch.php" style="color: #0b6fa6">Edit Grocery Item</a></li>
                        <li><a href="removeItemPage.php" style="color: #0b6fa6">Remove Grocery Item</a></li>
                    <ul>
                </nav>
                </p>
            </section>
        </article>
    </div>
</body>

</html>