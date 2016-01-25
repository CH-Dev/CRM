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
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu'  class='calbutton'></form><br>";
?>
<?php

$idnum=$_SESSION["idnum"];
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$when="nonoononono";
$what=$_POST["what"];
$when=$_POST["when"];
if($what==""&&$when!=""){
	$what="emptyempty,emtpy,emtpy";
}
if($when==""&&$what!=""){
	$when="emptyempty,emtpy,emtpy";
}
$_SESSION["what"]=$what;
$_SESSION["when"]=$when;

$sql="SELECT bookings.Fflag,bookings.Aflag,bookings.Tflag,bookings.Bflag,bookings.Sflag,numbers.Address,numbers.Email,quotes.Price,quotes.Expiry,quotes.DateIssued,quotes.IDBKey,quotes.IDKey,quotes.IDNKey,CONCAT(numbers.Fname,' ',numbers.Lname) AS name,numbers.Pnumber,numbers.Zone FROM numbers INNER JOIN quotes ON quotes.IDNKey=numbers.IDNKey INNER JOIN bookings ON numbers.IDNKey=bookings.IDNKey WHERE quotes.SalesmanID='$idnum' AND quotes.Approved IS NULL
		AND (quotes.DateIssued LIKE '%$when%' OR quotes.IDKey LIKE '%$what%' OR numbers.IDNKey LIKE '%$what%' OR numbers.Lname LIKE '%$what%' OR numbers.Fname LIKE '%$what%' OR numbers.Zone LIKE '%$what%' OR numbers.Pcode LIKE '%$what%' OR numbers.Address LIKE '%$what%' OR numbers.Pnumber LIKE '%$what%') ORDER by quotes.DateIssued DESC";
$result = mysqli_query($conn, $sql);

echo "<table cellpadding='0' cellspacing='0' class='calendar'>";
while($row = $result->fetch_assoc()) {
	$nID=$row["IDNKey"];
	$bID=$row["IDBKey"];
	$idQkey=$row["IDKey"];
	$address=$row["Address"];
	$address="<a href='https://maps.google.com?saddr=Current+Location&daddr=$address'>$address</a>";
	$date=$row["DateIssued"];
	$fflag=echocheck($row["Fflag"]);
	$aflag=echocheck($row["Aflag"]);
	$tflag=echocheck($row["Tflag"]);
	$bflag=echocheck($row["Bflag"]);
	$sflag=echocheck($row["Sflag"]);
	$name=$row["name"];
	$pnum=$row["Pnumber"];
	echo "<b>$date</b><br>";
	echo "<form action='/SalesAgents/updatebookings.php' method='post'><input type='submit' class='dayviewbutton' value='$name'><input type='text' name='rad' value='$bID'hidden></form><br>";
	echo "$pnum<br>";
	echo "$address<br>";
	echo "$fflag$aflag$bflag$tflag$sflag<br><br>";
	
}
echo "</table>";

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
<input type='submit' value='Main Menu'  class='calbutton'></form><br>";
?>
</body>
</html>