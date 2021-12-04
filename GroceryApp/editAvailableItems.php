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
<head>
    <meta charset='UTF-8' />
    <title>Edit Available Grocery Items</title>
    <link rel='stylesheet' href='styles.css' />
</head>

<body>
    <div class='page'>
        <header class="menu-container">
				<h1 class="logo">
					<a class="logo-link" href="./index.php">Grocery App</a>
				</h1>
				<nav class="menu">
					<li><a class="nav-link" href="./groceryList.php">My Cart</a></li>
                    <li><a class="nav-link" href="./editProfilePage.php">My Profile</a></li>
					<li><a class="nav-link" href="./signOut.php">Sign Out</a></li>
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
                        <li><a href="addCategoryPage.php" style="color: #0b6fa6">Edit Store Categories</a></li>
                        <li><a href="editUserTypesPage.php" style="color: #0b6fa6">Edit User Types</a></li>
                    <ul>
                </nav>
                </p>
            </section>
        </article>
    </div>
</body>

</html>