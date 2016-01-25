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
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$bkeys=$_POST["rad"];
$l=count($bkeys);
foreach ($bkeys as $x){
	
	$assign=$_POST["who"];
	$sql="UPDATE bookings SET SalesmanID='$assign' WHERE IDKey='$x'";
	$result = mysqli_query($conn, $sql);
	$bsql="SELECT Fname,Lname from agents WHERE IDKey='$assign'";
	$bresult = mysqli_query($conn, $bsql);
	$brow = $bresult->fetch_assoc();
	$fn=$brow["Fname"];
	$ln=$brow["Lname"];

	$dsql="SELECT * FROM bookings WHERE IDKey='$x'";
	$dresult = mysqli_query($conn, $dsql);
	$drow = $dresult->fetch_assoc();
	$idnkey=$drow["IDNKey"];
	$apptID=$drow["AppointmentID"];

	$esql="SELECT * FROM numbers WHERE IDNKey='$idnkey'";
	$eresult = mysqli_query($conn, $esql);
	$erow = $eresult->fetch_assoc();
	$cfn=$erow["Fname"];
	$cln=$erow["Lname"];
	$add=$erow["Address"];

	$fsql="SELECT * FROM shifts WHERE IDKey='$apptID'";
	$fresult = mysqli_query($conn, $fsql);
	$frow = $fresult->fetch_assoc();
	$t=$frow["Start"];
	$e=$frow["End"];
	$Date=$frow["Date"];

	$csql="INSERT INTO reminders (Text,Date,Time,End,AgentID,IDNKey) VALUES('B:$cfn $cln - $add','$Date','$t','$e','$assign','$idnkey')";

if (mysqli_query($conn, $csql)) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $csql . "<br>" . mysqli_error($conn);
}
echo "You assigned booking #$x to Agent #$assign/$fn $ln<br>";
}
?>
<form action="/SalesManager/bookings.php" method="post">
Bookings:<input type="submit" value="Menu">
</form>
<form action="/SalesManager/viewagents.php" method="post">
Agents:<input type="submit" value="Menu">
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>