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
$resp=$_POST["resp"];
$p1=$_POST["p1"];
$p2=$_POST["p2"];
$p3=$_POST["p3"];
$fage=$_POST["Fage"];
$acage=$_POST["ACage"];
$sql="UPDATE numbers SET Response='$resp',FAge='$fage',ACAge='$acage' WHERE Pnumber LIKE '%$p1%$p2%$p3%'";
$result = mysqli_query($conn, $sql);
echo "Updated successfully!";

?>
<form action='/Calendar/CreateNote.php' method='post'>
		<input type='text' value='' name='text'><br>
		<input type='submit' value='Create Note'>
		</form>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Cancel'></form><br>";
?>
</body>
</html>