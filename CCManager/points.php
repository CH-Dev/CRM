<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
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
Who would you like to adjust?<br>
<form action='/CCManager/points2.php' method='post'>
<select name='who'>
<?php 
$idnum=$_SESSION["idnum"];
$asql="SELECT * FROM agents WHERE SupervisorID='$idnum'";
$aresult = mysqli_query($conn, $asql);
while($arow = $aresult->fetch_assoc()) {
	$aid=$arow["IDKey"];
	$fn=$arow["Fname"];
	$ln=$arow["Lname"];
	echo "<option value='$aid'>$fn,$ln</option>";
}
?>
</select><br>
<select name='action'>
<option value='grant'>Grant</option>
<option value='take'>Take</option>
</select><br>
Quantity:<input type="number" name='quantity' value='1'><br>
<input type='submit' value='submit'>
</form>

<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Cancel'></form><br>";
?>
</body>
</html>