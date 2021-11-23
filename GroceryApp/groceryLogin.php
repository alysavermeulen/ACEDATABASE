<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Grocery Login</title>
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
							<li><a href="passengerIndex.html">Airplane Passengers</a></li>
						</ul>
						<!-- End of submenu -->
					</li>
					<li><a href="index.html">Home</a></li>
				</nav>
			</header>

			<!--Title and Form-->
			<article class="content">
				<header class="title">
					<h2>Grocery Login</h2>
				</header>

				<!-- Form -->
				<form
					class="groceryForm"
					method="post"
					action="groceryList.php"
				>
					<!-- username, password-->
					<label for="f_name">Username</label>
					<input
						class="textInput"
						type="text"
						id="fname"
						name="f_name"
						pattern="[A-Za-z]{1,}"
						required
					/>

					<label for="m_name">Password</label>
					<input
						class="textInput"
						type="text"
						id="mname"
						name="m_name"
						pattern="[A-Za-z]{1}"
					/>
					<input type="submit" value="Login" />
				</form>
				<div class="groceryForm">
                <a href="grocerySignup.php" style="color: #0b6fa6">Sign up as new user.</a>
            </div>
			</article>
		</div>
	</body>
</html>