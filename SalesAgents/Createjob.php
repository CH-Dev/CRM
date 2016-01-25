<html>
<head>
<title>CoolHeat comfort CRM</title>
<link rel="stylesheet" type="text/css" href="/Big Style.css">
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
include '..\Validate.php';
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$idq=$_POST["backnum"];
$sql="UPDATE quotes SET RequestJob='1' WHERE IDKey='$idq'";
mysqli_query($conn, $sql);
echo "<form action= '/SalesAgents/savebookings.php' method='post'>
				<input type='number' value='0' name='Mode' hidden>
				<input type='submit' value='Back' class='calbutton'>
		</form>
				";
echo "<meta http-equiv='refresh' content='3;url=../SalesAgents/savebookings.php'>";
?>
Job successfully Created!
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu' class='calbutton'></form><br>";
?>
</body>
</html>