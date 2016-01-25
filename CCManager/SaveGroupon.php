<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php 
session_start();
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$idnum=$_SESSION["idnum"];
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$pnum=$_POST["pnum"];
$fn=$_POST["fn"];
$ln=$_POST["n"];
$add=$_POST["add"];
$zone=$_POST["zone"];
$com1=$_POST["com1"];
$d=$_POST["date"];
$t=$_POST["time"];
$sql="INSERT INTO numbers (Fname,Lname,Pnumber,Address,Zone) VALUES('$fn','$ln','$pnum','$add','$zone')";
$result = mysqli_query($conn, $sql);
$selSQL="SELECT * FROM numbers WHERE IDNKey IN (SELECT max(IDNKey) FROM numbers)";
$selresult = mysqli_query($conn, $selsql);
$row = $selresult->fetch_assoc();
$idn=$row["IDNKey"];
$bsql="INSERT INTO bookings (DateofBooking,LastContactID,Comments1,IDNKey,SalesmanID)
VALUES('$date','$idnum','$com1','$d : $t','$idn','44');";
if (mysqli_query($conn, $bsql)) {
echo "New record created successfully<br>";
} else {
echo "Error: " . $bsql . "<br>" . mysqli_error($conn);
}
?>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Cancel'></form><br>";
?>
</body>
</html>