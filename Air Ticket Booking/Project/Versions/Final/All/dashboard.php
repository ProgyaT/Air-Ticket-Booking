<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', 'Flight_Booking_System');

	$error_msg = '';

	session_start();
	$passport_number = $_SESSION['user_passport'];

	$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$_SESSION['user_identity'] = NULL;
		$_SESSION['user_passport'] = NULL;

		header("Location: http://localhost/Projects/Flight%20Booking%20System/login.php");
	}
?>
	<html>
	<head>
		<title>Dashboard</title>

		<style type = "text/css">
			body {
				font-family:Arial, Helvetica, sans-serif;
				font-size:14px;
			}

			label {
				font-weight:bold;
				width:100px;
				font-size:14px;
			}

			div {
				padding: 10px;
			}

			select {
				min-width: 100px;
			}

			.main-container {
				display:flex;
				align-items: center;
				justify-content: center;
			}

			.error {
				font-size:11px;
				color:#cc0000;
				margin-top:10px;
			}

			.flight {
				border: solid 2px black;
				margin: 5px;
				padding: 5px 20px;
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
				<h2>Dashboard</h2>
			</div>

			<div>
				<div>
					<h3>My Info:</h3>
					<?php
					$sql = 'SELECT CONCAT(first_name , " ", last_name) as name, passport_number FROM passport WHERE passport_number = "'.(mysqli_real_escape_string($db, $passport_number)).'"';
					$result = $db -> query($sql);
					$row = $result -> fetch_assoc();
					?>

					<p>Name: <span><?php echo $row['name'] ?></span></p>
					<p>Passport Number: <span><?php echo $row['passport_number'] ?></span></p>
				</div>

				<div>
					<h3>My Flights:</h3>
					<a href="http://localhost/Projects/Flight%20Booking%20System/airport-selection.php">
						<p>+ Book a new flight</p>
					</a>
					<div>
						<?php
						$sql = 'SELECT flight.take_off_time as take_off, plane.plane_number as plane, plane_model.model_name as model, seat.seat_name as seat FROM booking, flight, plane, plane_model, seat WHERE booking.reserve_seat_id = seat.seat_id AND booking.flight_id = flight.flight_id AND flight.by_plane_id = plane.plane_id AND plane.model_id = plane_model.model_id AND booking.by_passanger = "'.$passport_number.'"';
						$result = $db -> query($sql);
						$count = $result -> num_rows;

						for ($i = 0; $i < $count; $i++) {
							$row = $result -> fetch_assoc();
							echo '<div class="flight">';
							echo '<h3>Booking '.($i+1).'</h3>';
							echo '<p><b>Date: </b>'.$row['plane'].'</p>';
							echo '<p><b>Model: </b>'.$row['model'].'</p>';
							echo '<p><b>Seat: </b>'.$row['seat'].'</p>';
							echo '<p><b>Plane: </b>'.$row['plane'].'</p>';
							echo '<p><b>Take Off: </b>'.$row['take_off'].'</p>';
							echo '</div>';
						}
						?>
					</div>
				</div>

				<form action = "" method = "post">
					<input type = "submit" value = "Log Out" class="button"/>
				</form>

				<div class="error">
					<?php echo $error_msg; ?>
				</div>
			</div>
		</div>
	</body>
	</html>
<?php
$db -> close();
?>