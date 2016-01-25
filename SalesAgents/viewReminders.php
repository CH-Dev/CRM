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
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$idnum=$_SESSION["idnum"];
$sql="SELECT numbers.IDNKey,reminders.Text,reminders.Date,CONCAT(numbers.Fname,' ',numbers.Lname) AS name,numbers.Address,numbers.Pnumber,numbers.Email,bookings.Fflag,bookings.Aflag,bookings.Tflag,bookings.Bflag
FROM reminders INNER JOIN numbers ON numbers.IDNKey=reminders.IDNKey INNER  JOIN bookings ON bookings.IDNKey=numbers.IDNKey
WHERE reminders.AgentID='$idnum' AND(";
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
if($_POST["mode"]==0){
	$sql="$sql reminders.Date='$date'";
}else if($_POST["mode"]==1){
	$days=7;
	$week=$_POST["week"];
	$wsql="SELECT * FROM weeks WHERE IDKey='$week'";
	$wresult = mysqli_query($conn, $wsql);
	$wrow = $wresult->fetch_assoc();
	$lowdate=$wrow["Start"];
	$sql="$sql reminders.Date='$lowdate'";
	$ndate=$lowdate;
	for($x=1;$x<$days;$x++){//Week mode logic
		$workingdate = date_create($ndate);
		date_modify($workingdate, '+1 day');
		$ndate=date_format($workingdate, 'Y-m-d');
		$sql="$sql OR reminders.Date='$ndate'";
	}
}
$workingdate = date_create($date);
$day=date_modify($workingdate, '-14 day');
$sql="$sql)ORDER BY reminders.Date";
$Sdate=date_format($day, 'Y-m-d');
echo "Choose week to view:<table class='flags'>
<tr><td class='flagbox'><form action='viewReminders.php' method='post'>
<input type='text' name='mode' value='1' hidden>
<select name='week' class='Sales-select'>";
$wsql="SELECT * FROM weeks WHERE End>'$Sdate'";
$wresult = mysqli_query($conn, $wsql);
while($wrow = $wresult->fetch_assoc()){
	$a=$wrow["Start"];
	$b=$wrow["End"];
	$id=$wrow["IDKey"];
	echo "<option value='$id'>$a - $b</option>";
	
}

echo "</select></td>";
echo "<td class='flagbox' valign='top'>
<input type='submit' value='Go' class='calbutton2'></form>";
if($_POST["mode"]==1){
	echo "<td class='flagbox' valign='top'>
		<form action='/SalesAgents/viewReminders.php' method='post'>
		<input type='text' name='mode' value='0' hidden>
		<input type='submit' value='Today' class='calbutton2'>
		</form></td>";
}
echo "</tr></table>";
echo "Followups for:";
if($_POST["mode"]==0){
	echo $date."<br><br>";
}
if($_POST["mode"]==1){
	$wsql="SELECT * FROM weeks WHERE IDKey='$week'";
	$wresult = mysqli_query($conn, $wsql);
	$wrow = $wresult->fetch_assoc();
	echo $wrow["Start"]."-".$wrow["End"]."<br><br>";
}
$result = mysqli_query($conn, $sql);
echo "<table cellpadding='0' cellspacing='0' class='calendar'>";
while($row = $result->fetch_assoc()) {	
	$name=$row["name"];
	$text=$row["Text"];
	$date=$row["Date"];
	$add=$row["Address"];
	$add="<a href='https://maps.google.com?saddr=Current+Location&daddr=$add'>$add</a>";
	$pnum=$row["Pnumber"];
	$email=$row["Email"];
	$fflag=echocheck($row["Fflag"]);
	$aflag=echocheck($row["Aflag"]);
	$tflag=echocheck($row["Tflag"]);
	$bflag=echocheck($row["Bflag"]);
	$idn=$row["IDNKey"];
	echo "<b>$date</b><br>";
	echo "<form action='/SalesAgents/updatebookings.php' method='post'><input type='submit' class='dayviewbutton' value='$text'><input type='text' name='rad' value='$idn'hidden></form><br>";
	echo "$name: $pnum<br>";
	echo "$email  $add<br>";
	echo "$fflag$aflag$bflag$tflag<br>";
	$nsql="SELECT * FROM notes WHERE IDNKey='$idn'";
	$nresult = mysqli_query($conn, $nsql);
	
	while($nrow = $nresult->fetch_assoc()) {
		$agent=$nrow["AgentID"];
		$n2sql="SELECT Fname,Lname FROM agents WHERE IDKey='$agent'";
		$n2result = mysqli_query($conn, $n2sql);
		$n2row = $n2result->fetch_assoc();
		$nname= $n2row["Fname"]." ".$n2row["Lname"];
		$ntext=$nrow["Text"];
		$time=$nrow["Date"];
		echo "$time:$nname said: $ntext<br>";
	}
	echo "<br>";
}
echo "</table>";
?>



<?php 
function echocheck($p){
	if($p=='1'){
		return "&#10004";
	}else{
		return "&#10006";
	}
}
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden> <input type='text' name='pass' value='$pass' hidden>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu'  class='calbutton'></form><br>";
?>
</body>
</html>