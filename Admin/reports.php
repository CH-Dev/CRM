<html>
<head>
<title>CoolHeat comfort CRM</title>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

?>
<form action="/Admin/printreport.php" method="post">
<input type="date" name="day"><br>
<select name="week">
<?php 
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$sql="SELECT * FROM weeks WHERE Start<'$date'";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()){
	$a=$row["Start"];
	$b=$row["End"];
	$id=$row["IDKey"];
	echo "<option value='$id'>$a - $b</option>";
	
}
?>
</select><br>
<select name="mode">
<option value="D">Day</option>
<option value="W">Week</option>
</select>
Call Center Stats:<input type="submit" value="Search">
</form>
<form action="/Admin/printbookingreport.php">
<select name="week">
<?php 
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$sql="SELECT * FROM weeks WHERE Start<'$date'";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()){
	$a=$row["Start"];
	$b=$row["End"];
	$id=$row["IDKey"];
	echo "<option value='$id'>$a - $b</option>";
	
}
?>
</select><br>
Bookings:<input type="submit" value="View">
</form>
Lead Stats:<form action="/Admin/printleadreport.php">
<input type="submit" value="View">
</form>

<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>