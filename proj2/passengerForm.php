<!DOCTYPE html>
<html>

<?php

// default page variables (for adding new passenger)
$title = "Add New Passenger";
$subtitle = "Input information for new passenger:";
$button = "Submit";
$action = "createPassenger.php";

// path to the SQLite database file
$db_file = './myDB/airport.db';

// empty passenger info variables
$f_name = "";
$m_name = "";
$l_name = "";
$ssn = "";

// IF RELEVANT: adjust info for updating passenger information
if(isset($_GET['ssn'])) {
	// adjust page variables
	$title = "Update Passenger Information";
	$subtitle = "Update passenger information:";
	$button = "Update info";
	$action = "updatePassenger.php";

	//fetch ssn from URL
	$ssn = $_GET['ssn'];
	try {
	    // open connection to the airport database file
	    $db = new PDO('sqlite:' . $db_file);

	    // set errormode to use exceptions
	    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    // prepare to fetch info of passenger with this ssn
		$stmt = $db->prepare("select * from passengers where ssn = ?");

		// fetch info of passenger with this ssn
		$stmt->execute([$_GET['ssn']]);
		$tuple = $stmt->fetch(PDO::FETCH_ASSOC);

		// adjust passenger info variables
		$f_name = $tuple['f_name'];
		$l_name = $tuple['l_name'];

		if (!empty($tuple['m_name'])){
			$m_name = $tuple['m_name'];
		}

		// disconnect from db
	    $db = null;
	}
	catch(PDOException $e){
		die('Exception : '.$e->getMessage());
	}
}
?>
	<head>
		<meta charset="UTF-8" />
		<title><?php echo "$title"; ?></title>
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
					<h2><?php echo "$subtitle"; ?></h2>
				</header>

				<!-- Form -->
				<form
					class="insertPassengerForm"
					method="post"
					action="<?php echo "$action"; ?>"
				>
					<!-- f_name, m_name, l_name, ssn-->
					<label for="f_name">First Name</label>
					<input
						class="textInput"
						type="text"
						id="fname"
						name="f_name"
						value= "<?php echo "$f_name"; ?>"
						pattern="[A-Za-z]{1,}"
						required
					/>

					<label for="m_name">Middle Initial</label>
					<input
						class="textInput"
						type="text"
						id="mname"
						name="m_name"
						value= "<?php echo "$m_name"; ?>"
						pattern="[A-Za-z]{1}"
					/>

					<label for="l_name">Last Name</label>
					<input
						class="textInput"
						type="text"
						id="lname"
						name="l_name"
						value="<?php echo "$l_name"; ?>"
						pattern="[A-Za-z]{1,}"
						required
					/>

					<label for="ssn">Social Security Number (???-??-????)</label>
					<input
						class="textInput"
						type="text"
						id="ssn"
						name="ssn"
						value="<?php echo "$ssn"; ?>"
						pattern="\d{3}-?\d{2}-?\d{4}"
						required
					/>

					<input type="submit" value="<?php echo "$button"; ?>" />
				</form>
			</article>
		</div>
	</body>
</html>