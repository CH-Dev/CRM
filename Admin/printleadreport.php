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
$qsql="SELECT COUNT(*) FROM quotes WHERE Preinspect='1' OR Preinspect IS NULL";
$bsql="SELECT COUNT(*) FROM bookings";
$jsql="SELECT COUNT(*) FROM jobs";
$b2sql="SELECT COUNT(*) FROM bookings WHERE Cancelled IS NULL AND IDNKey NOT IN(SELECT IDNKey FROM quotes)";
$b3sql="SELECT COUNT(*) FROM bookings WHERE Cancelled IS NOT NULL";
if($mode==1){//Day Mode
	$qsql="$qsql AND DateIssued='$lowdate'";
	$jsql="$jsql WHERE StartDate='$lowdate'";
	$bsql="$bsql WHERE AppointmentID IN (SELECT IDKey FROM shifts WHERE Date LIKE '%$lowdate%')";
	$b3sql="$b3sql AND AppointmentID IN (SELECT IDKey FROM shifts WHERE Date LIKE '%$lowdate%')";
}

$bresult = mysqli_query($conn, $bsql);
$brow = $bresult->fetch_assoc();
$b2result = mysqli_query($conn, $b2sql);
$b2row = $b2result->fetch_assoc();
$b3result = mysqli_query($conn, $b3sql);
$b3row = $b3result->fetch_assoc();
$qresult = mysqli_query($conn, $qsql);
$qrow = $qresult->fetch_assoc();
$jresult = mysqli_query($conn, $jsql);
$jrow = $jresult->fetch_assoc();

$bookings=$brow["COUNT(*)"];
$bookingsm=$b2row["COUNT(*)"];
$bookingsC=$b3row["COUNT(*)"];
$quotes=$qrow["COUNT(*)"];
$jobs=$jrow["COUNT(*)"];
$bookingsU=$bookings-$bookingsm;
$bookingpercent=($bookingsU/$bookings)*100;

echo "$bookings Leads generated so far, $bookingsU have been updated! $bookingsC Leads have been cancelled<br>$bookingpercent% of bookings are up to date!<br>$quotes Quotes are in the system!<br>$jobs Jobs are in the system!";

?>

<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>