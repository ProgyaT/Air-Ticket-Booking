<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', 'Flight_Booking_System');
	
	$error_msg = "";

	session_start();
	
	$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	
	$dummy_model_id = 1;
	$model_id = mysqli_real_escape_string($db, $dummy_model_id);
	
	$sql = "SELECT id, seat_name FROM seat WHERE model_id = '$model_id'";
	$result = $db -> query($sql);
	
	$count = $result -> num_rows;
	for ($i = 0; $i < $count; $i++) {
		$row = $result -> fetch_assoc();
		echo $row['seat_name'];
	}
	
	$db -> close();

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']); 

		$sql = "SELECT passport_number FROM passanger WHERE username = '$username' and password = '$password'";
		$result = $db -> query($sql);
		$count = $result -> num_rows;

		if($count == 1) {
			$row = $result -> fetch_assoc();
			$_SESSION['user_identity'] = $username;
			$_SESSION['user_passport'] = $row['passport_number'];
			$error_msg = "Logged in as: " . $row['passport_number'];
		} else {
			$error_msg = "Invalid username or password.";
		}

		$db -> close();
	}
?>
<html>
<head>
	<title>Login Page</title>
      
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
      </style>
</head>

<body bgcolor = "#FFFFFF">
<div class="main-container">
	<div>
	<div>
		<b>Login</b>
	</div>
				
	<div>  
	<form action = "" method = "post">
		<div>
			<h1>SHOW ALL SEATS</h1>

  <p>Please select your SEAT:</p>

  <input type="radio" id="A1" name="fav_language" value="A1">
  <label for="A1">A1</label><br>
  <input type="radio" id="B1" name="fav_language" value="B1">
  <label for="B1">B1</label><br>
  <input type="radio" id="C1" name="fav_language" value="C1">
  <label for="C1">C1</label><br>
  <input type="radio" id="D1" name="fav_language" value="D1">
  <label for="D1">D1</label><br>
  <input type="radio" id="E1" name="fav_language" value="E1">
  <label for="E1">E1</label><br>
  <input type="radio" id="F1" name="fav_language" value="F1">
  <label for="F1">F1</label><br>
  <input type="radio" id="G1" name="fav_language" value="G1">
  <label for="G1">G1</label><br>
  <input type="radio" id="H1" name="fav_language" value="H1">
  <label for="H1">H1</label>

  <br>
		</div>

		<div>
			<label>Password  :</label>
			<input type = "password" name = "password"/>
		</div>
		<input type = "submit" value = " Submit "/>
	</form>
               
	<div class="error">
		<?php echo $error_msg; ?>
	</div>	
	</div>			
</div>
</body>
</html>