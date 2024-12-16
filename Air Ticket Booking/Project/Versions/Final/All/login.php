<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_DATABASE', 'Flight_Booking_System');
	
	$error_msg = "";

	session_start();

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

			header("Location: http://localhost/Projects/Flight%20Booking%20System/dashboard.php");
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
		<h2>Login</h2>
	</div>
				
	<div>  
	<form action = "" method = "post">
		<div>
			<label for="username">UserName  :</label>
			<input type = "text" id="username" name = "username"/>
		</div>

		<div>
			<label for="password">Password  :</label>
			<input type = "password" id="password"  name = "password"/>
		</div>
		<input type = "submit" value = "Login" class="button"/>
	</form>
               
	<div class="error">
		<?php echo $error_msg; ?>
	</div>	
	</div>			
</div>
</body>
</html>