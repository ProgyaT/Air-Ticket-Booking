<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', 'Flight_Booking_System');
	
	$error_msg = "";

	session_start();
	
	$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	$sql = 'SELECT plane.model_id as model FROM flight, plane WHERE flight.by_plane_id = plane.plane_id AND flight.flight_id = '.$_SESSION['flight-id'];
	$result = $db -> query($sql);
	$row = $result -> fetch_assoc();
	$model_id = $row['model'];

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$_SESSION['seat-id'] = $_POST['seat'];

		header("Location: http://localhost/Projects/Flight%20Booking%20System/book-flight.php");
	}
?>
<html>
<head>
	<title>Seat Selection</title>
      
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

		.seat {
			display: inline-block;
			width: 100px;
			padding: 5px;
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
		<h2>Seat Selection</h2>
	</div>
				
	<div>  
		<form action = "" method = "post">
			<div>
				<p>Available Seats:</p>
				<?php
				$sql = 'SELECT seat_id, seat_name FROM seat WHERE model_id = "'.$model_id.'"';
				$result = $db -> query($sql);

				$count = $result -> num_rows;
				for ($i = 0; $i < $count; $i++) {
					$row = $result -> fetch_assoc();
					$seat_id = $row['seat_id'];
					$seat_name = $row['seat_name'];

					echo '<div class="seat"><input type="radio" id="'.$seat_id.'" name="seat" value="'.$seat_id.'"><label for="'.$seat_id.'">'.$seat_name.'</label></div>';
					if ($i % 5 == 4) {
						echo '<br>';
					}
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