<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', 'Flight_Booking_System');

	$error_msg = '';

	session_start();

	$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$_SESSION['from-airport'] = $_POST['from-airport'];
		$_SESSION['to-airport'] = $_POST['to-airport'];
		$_SESSION['travel-date'] = $_POST['travel-date'];

		header("Location: http://localhost/Projects/Flight%20Booking%20System/plane-selection.php");
	}
?>
<html>
<head>
	<title>Airport Selection</title>

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
			<h2>Airport Selection</h2>
		</div>

		<div>
			<form action = "" method = "post">
				<div>
					<label for="from-airport">From: </label><br/>
					<select name="from-airport" id="from-airport">
						<?php
						$sql = 'SELECT airport_id, name, location FROM airport';
						$result = $db -> query($sql);
						$count = $result -> num_rows;

						for ($i = 0; $i < $count; $i++) {
							$row = $result -> fetch_assoc();
							echo '<option value="'.$row['airport_id'].'">'.$row['name'].'</option>';
						}
						?>
					</select>
				</div>

				<div>
					<label for="to-airport">To: </label><br/>
					<select name="to-airport" id="to-airport">
						<?php
						$sql = 'SELECT airport_id, name, location FROM airport';
						$result = $db -> query($sql);
						$count = $result -> num_rows;

						for ($i = 0; $i < $count; $i++) {
							$row = $result -> fetch_assoc();
							echo '<option value="'.$row['airport_id'].'">'.$row['name'].'</option>';
						}
						?>
					</select>
				</div>

				<div>
					<label for="travel-date">Travel Date:</label><br/>
					<input type="date" class="form-control" id="travel-date" name="travel-date">
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