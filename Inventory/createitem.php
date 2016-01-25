<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>

<form action="/Inventory/createitem2.php" method="post">
Description:<input type="text" name="desc"><br>
Boone ID:<input type="text" name="boone"><br>
Current Stock:<input type="number" name="stock"><br>
Model Number:<input type="number" name="mod"><br>
Category:<select name="cat">
<?php 
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql="SELECT * FROM categories";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$sym=$row["Symbol"];
	$desc=$row["Description"];
	$id=$row["IDKey"];
	
	echo "<option value='$id'>$sym,$desc</option>";
}
?>
</select><br>
Unit of Measure:<select name="cat">
<?php 
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql="SELECT * FROM units";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$sym=$row["Symbol"];
	$desc=$row["Description"];
	$id=$row["IDKey"];
	echo "<option value='$id'>$sym,$desc</option>";
}
?>
</select><br>
<input type="submit" value="Create Item"><br>

</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>