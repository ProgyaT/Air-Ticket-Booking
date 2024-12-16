<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', 'Flight_Booking_System');

	$error_msg = '';

	session_start();

	$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	$sql = 'SELECT * FROM flight WHERE take_off_time BETWEEN "'.$_SESSION['travel-date'].' 00:00:00" AND "'.$_SESSION['travel-date'].' 23:59:59" AND from_airport_id = '.$_SESSION['from-airport'].' AND to_airport_id = '.$_SESSION['to-airport'];
	$result = $db -> query($sql);
	$count = $result -> num_rows;

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$_SESSION['flight-id'] = $_POST['flight'];

		header("Location: http://localhost/Projects/Flight%20Booking%20System/seat-selection.php");
	}
?>
	<html>
	<head>
		<title>Plane Selection</title>

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
				<h2>Plane Selection</h2>
			</div>

			<div>
				<form action = "" method = "post">
					<div>
						<p>Available Flights:</p>
						<?php
						for ($i = 0; $i < $count; $i++) {
							$row = $result -> fetch_assoc();

							$sql_plane = 'SELECT plane.plane_number as number, plane_model.model_name as model FROM plane, plane_model WHERE plane.plane_id = '.$row['by_plane_id'].' AND plane_model.model_id = plane.model_id';
							$result_plane = $db -> query($sql_plane);
							$row_plane = $result_plane -> fetch_assoc();

							$text = $row_plane['model'].' ['.$row_plane['number'].']'; //.' [Take Off: '.$row['take_off_time'].', Arrival: '.$row['take_off_time'].']';

							echo '<input type="radio" id="'.$row['flight_id'].'" name="flight" value="'.$row['flight_id'].'"><label for="'.$row['flight_id'].'">'.$text.'</label><br>';
						}
						?>
					</div>
					<input type = "submit" value = "Submit" class="button"/>
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