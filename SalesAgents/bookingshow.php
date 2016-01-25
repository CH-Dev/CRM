<html>
<head>
<link rel="stylesheet" type="text/css" href="/Big Style.css">
<title>CoolHeat comfort CRM</title>
<script src="/sorttable.js"></script>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php 
session_start();
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<table><form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden> <input type='text' name='pass' value='$pass' hidden>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu' class='calbutton'></form></table>";
?>
<?php

$idnum=$_SESSION["idnum"];
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$when=$_POST["when"];
$what=$_POST["what"];
if($what==""&&$when!=""){
	$what="emptyempty,emtpy,emtpy";
}
if($when==""&&$what!=""){
	$when="emptyempty,emtpy,emtpy";
}
$_SESSION["when"]=$when;
$_SESSION["what"]=$what;

$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql="SELECT numbers.IDNKey,numbers.Address,bookings.IDKey AS 'IDBKey',CONCAT(numbers.Fname,' ',numbers.Lname) AS 'cusn',numbers.Pnumber,numbers.FAge,numbers.ACAge,bookings.Fflag,bookings.Aflag,bookings.Tflag,bookings.Bflag,bookings.Sflag,CONCAT(agents.Fname,' ',agents.Lname) AS 'agentN',shifts.Date,CONCAT(shifts.Start,'-',shifts.END) AS 'time' FROM bookings INNER JOIN numbers ON bookings.IDNKey=numbers.IDNKey INNER JOIN agents ON bookings.LastContactID=agents.IDKey INNER JOIN shifts ON bookings.AppointmentID=shifts.IDKey WHERE bookings.Heat IS NULL AND bookings.Cancelled IS NULL AND bookings.SalesmanID='$idnum'
AND (numbers.Fname LIKE '%$what%' OR numbers.Lname LIKE '%$what%' OR numbers.Address LIKE '%$what%' OR numbers.Zone LIKE '%$what%'OR numbers.Pcode LIKE '%$what%' OR shifts.Date='$when' OR numbers.IDNKey='$what' OR bookings.IDKey='$what' OR bookings.DateofBooking='$when' OR numbers.Pnumber LIKE '%$what%') AND numbers.IDNKey NOT IN(SELECT IDNKey FROM quotes) ORDER BY shifts.Date DESC, shifts.Start";
$result = mysqli_query($conn, $sql);
echo "<table cellpadding='0' cellspacing='0' class='calendar'>";
while($row = $result->fetch_assoc()) {
	
	
	$idkey=$row["IDBKey"];
	$idn=$row["IDNKey"];
	$cusn=$row["cusn"];
	$address=$row["Address"];
	$address="<a href='https://maps.google.com?saddr=Current+Location&daddr=$address'>$address</a>";
	
	$date=$row["Date"];
	$time=$row["time"];
	$pnum=$row["Pnumber"];
	$name=$row["cusn"];
	
	$fflag=echocheck($row["Fflag"]);
	$aflag=echocheck($row["Aflag"]);
	$tflag=echocheck($row["Tflag"]);
	$bflag=echocheck($row["Bflag"]);
	$sflag=echocheck($row["Sflag"]);
	echo "<b>$date-$time</b><br>";
	echo "<form action='/SalesAgents/updatebookings.php' method='post'><input type='submit' class='dayviewbutton' value='$name'><input type='text' name='rad' value='$idkey'hidden></form><br>";
	echo "$pnum<br>";
	echo "$address<br>";
	echo "$fflag$aflag$bflag$tflag$sflag<br><br>";
}
function echorow($p){
	echo "<td>$p</td>";
}
function echocheck($p){
	if($p=='1'){
		return "&#10004";
	}else{
		return "&#10006";
	}
}
?>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu' class='calbutton'></form><br>";
?>
</body>
</html>