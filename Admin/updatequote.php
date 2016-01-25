<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM Index</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
echo "<div id='resultsect'>";
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$p=$_POST["price"];
$com=$_POST["coms"];
$exp=$_POST["expiry"];
$idq=$_SESSION["IDQKey"];
$idb=$_SESSION["IDBKey"];
$sql="UPDATE quotes SET Price='$p',Expiry='$exp' WHERE IDKey='$idq'";
$result = mysqli_query($conn, $sql);
$bsql="UPDATE bookings SET Comments1='$com' WHERE IDKey='$idb'";
$bresult = mysqli_query($conn, $bsql);
$dsql="SELECT * FROM bookings WHERE IDKey='$idb'";
$bresult = mysqli_query($conn, $bsql);
$row= $bresult->fetch_assoc();
$agent=$row["SalesmanID"];

$appt=$row["AppointmentID"];
$esql="SELECT * FROM shifts WHERE IDKey='$appt'";
$eresult = mysqli_query($conn, $esql);
$erow= $eresult->fetch_assoc();
$wid=$erow["WID"];

$fsql="SELECT Percent FROM agents WHERE IDKey='$agent'";
$fresult = mysqli_query($conn, $fsql);
$frow= $fresult->fetch_assoc();
$perc=$frow["Percent"];

$gsql="SELECT sum(TotalPrice) FROM parts WHERE IDQKey='$idq'";
$gresult = mysqli_query($conn, $gsql);
$grow= $gresult->fetch_assoc();
$total=$grow["sum(TotalPrice)"];

$profit=$p-$total;
$commision=$profit*$prec;
$csql="INTERT INTO payments (AgentID,WID,Amount,Comment,Type,Method) VALUES($agent,$wid,$commision,$com,'SalesMan Commission for booking# $idb','Cheque')";
$cresult = mysqli_query($conn, $csql);
echo "Updated successfully!";
?>
<form action="/Admin/viewpreinspects" method="post">
View Others:<input type="submit" value="View">
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>