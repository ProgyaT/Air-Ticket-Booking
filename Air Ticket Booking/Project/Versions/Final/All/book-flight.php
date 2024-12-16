<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', 'Flight_Booking_System');

	session_start();

	$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	$sql = 'INSERT INTO booking (by_passanger, reserve_seat_id, flight_id) VALUES ("'.$_SESSION['user_passport'].'", '.$_SESSION['seat-id'].', '.$_SESSION['flight-id'].')';
?>

<html>
<head>
	<title>Booking</title>

	<style type = "text/css">
		body {
			font-family:Arial, Helvetica, sans-serif;
			font-size:14px;
		}

		div {
			padding: 10px;
		}

		.main-container {
			display:flex;
			align-items: center;
			justify-content: center;
		}

		.button {
			background-color: #4CAF50; /* Green */
			border: none;
			color: white;
			padding: 4px 8px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			margin: 4px 2px;
			transition-duration: 0.4s;
			cursor: pointer;
		}

		.button {
			background-color: white;
			color: black;
			border: 2px solid #4CAF50;
		}

		.button:hover {
			background-color: #4CAF50;
			color: white;
		}
	</style>
</head>
<body bgcolor = "#FFFFFF">
	<div class="main-container">
	<div>
		<div>
			<h2>
				<?php
				if($db -> query($sql) === TRUE){
					echo "Booking Successful";

					$_SESSION['from-airport'] = NULL;
					$_SESSION['to-airport'] = NULL;
					$_SESSION['travel-date'] = NULL;
					$_SESSION['flight-id'] = NULL;
					$_SESSION['seat-id'] = NULL;
				}
				else {
					echo "Booking Failed";
				}
				?>
			</h2>
		</div>

		<a href="http://localhost/Projects/Flight%20Booking%20System/dashboard.php" class="button">Go back to Dashboard</a>
	</div>
</body>
</html>
<?php
$db -> close();
?>
