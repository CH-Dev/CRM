<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<div id="numsect">
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$idnum=$_SESSION["idnum"];
$sqlpunch="SELECT Type FROM punches WHERE IDKey IN (SELECT MAX(IDKey) FROM punches WHERE AgentID='$idnum')";
$resultpunch = mysqli_query($conn, $sqlpunch);
$rowpunch = $resultpunch->fetch_assoc();
$punchedin=$rowpunch["Type"];

if($punchedin=='0'){
	$zone=getnextnumber();
}
else{
	echo "Please punch in.";
}

function getnextnumber(){
	$idnum=$_SESSION["idnum"];
	$sql="SELECT MIN(IDNKey),Pnumber,Fname,Lname,Address,Zone FROM numbers WHERE AssignedUser='$idnum' AND AssignedUser<>'0' AND Response='o' AND (Length(Pnumber)='14' OR Length(Pnumber)='10');";
	//echo $sql;
	$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) ==1) {
		$row = $result->fetch_assoc();
		$zone=$row["Zone"];
		echo "your next number is:#<b>".$row["Pnumber"]."</b><br>".$row["Fname"].",".$row["Lname"]."<br>".$row["Address"]."<br>";
	$_SESSION["IDNKey"]=$row["MIN(IDNKey)"];
	//echo "IDKey=".$_SESSION["IDNKey"];
	}
	else{
		$super="SELECT Fname FROM agents WHERE IDKey IN(SELECT SupervisorID FROM agents WHERE IDKey='$idnum')";
		$sresult = mysqli_query($conn, $super);
		$srow = $sresult->fetch_assoc();
		$supID=$srow["Fname"];
		echo "<br><b>Tell $supID your out of rows!</b><br>";
	}
	//else{
	//	echo "Error code #1 Get Next Number else statement was triggered,$username<br>,$sql<br> !go get Aric and show him this!";
	//}
	return $zone;
}
?>
</div>
<div id="resultsect">
<form action="/CallCenterAgents/callresult.php" method="post">
Response:<select name='rad'>
<option value='NA'>No Answer</option>
<option value='booked'>booked</option>
<option value='DNC'>Do Not Call</option>
<option value='NI'>Not Interested</option>
<option value='o'>Uncalled</option>
<option value='B'>Business</option>
<option value='oo'>No Answer</option>
<option value='NS'>No Signal</option>
<option value='CB'>Call Back</option>
<option value='DNQ'>Does Not Qualify</option>
<option value='APP'>Renting</option>
</select><br>
Appointment type:<br>
Furnace:<input type="checkbox" name="check[]" value="f"> A/C:<input type="checkbox" name="check[]" value="a"><br>
Water Tank:<input type="checkbox" name="check[]" value="t"> Boiler:<input type="checkbox" name="check[]" value="b"><br>
Service:<input type="checkbox" name="check[]" value="s"><br>
<input type="submit" value="submit">
</div>
<div id="datasect">
Age of AC:<br><input type="text" name="acage" value="0"><br>
Age of Furnace:<br><input type="text" name="fage" value="0"><br>
Call Back date:<br><input type="date" name="cbtime"><br>
Call Back time:<br><input type="time" name="cbt"><br>
<?php 
echo "Time Slot:<select name='Btime'>";
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$sql="SELECT * FROM shifts WHERE Date>'$date' AND slots>'0' AND type='sa' AND Zone LIKE '%$zone%' ORDER BY Date;";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$date=$row["Date"];
	$start=$row["Start"];
	$end=$row["End"];
	$z=$row["Zone"];
	$idkey=$row["IDKey"];
	echo "<option value='$idkey'>$date, $start - $end, $z</option>";
}
echo "</select>";
?>

</div>
<div id="comsect">
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden> <input type='text' name='pass' value='$pass' hidden>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</div>
</body>
</html>