<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<form action="/SalesManager/bookingshow.php" method="post">
Date:<input type="date" name="when">Format is YYYY/MM/DD, searches Date of bookings<br>
Search For:<input type="text" name="what"><br>
<input type="submit" value="View">
</form>
<?php 
session_start();
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>