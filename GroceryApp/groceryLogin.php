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
				<h1 class="logo">
					<a class="logo-link" href="./index.html">Grocery App</a>
				</h1>
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