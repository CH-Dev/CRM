<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM Index</title>
<script src="/sorttable.js"></script>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$idnum=$_SESSION["idnum"];
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql="SELECT Type FROM punches WHERE IDKey IN (SELECT MAX(IDKey) FROM punches WHERE AgentID='$idnum')";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$lasttype=$row["Type"];
$t=1;
if($lasttype=='1'){
	$t=0;
}
$lat=$_POST["lat"];
$lon=$_POST["lon"];

$cdate = date('Y/m/d H:i:s');
$cdate=str_replace('/', '-', $cdate);

$bsql="INSERT INTO punches (Type,AgentID,Lattitude,Longitude,Time) VALUES ('$t','$idnum','$lat','$lon','$cdate')";
//echo $bsql;
$bresult = mysqli_query($conn, $bsql);
?>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>