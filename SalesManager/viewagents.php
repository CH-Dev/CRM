<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>

<?php
session_start();
$idnum=$_SESSION["idnum"];
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql="SELECT Fname,Lname,IDKey from agents WHERE SupervisorID='$idnum' AND AccountType='1'";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()){
	$sid=$row["IDKey"];
	$fn=$row["Fname"];
	$ln=$row["Lname"];
	echo "$fn $ln's current bookings";
	echo "<form action='changebooking.php' method='post'>";
	DisplayTable($sid);
	echo "<input type='submit' value='view'>";
	echo "</form>";
}

function DisplayTable($sid){
	$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$bsql="SELECT * FROM bookings WHERE SalesmanID='$sid'";
	$bresult = mysqli_query($conn, $bsql);
	echo "<table border='6' style='width:100%' class='sortable'>";
	echo "<tr>";
	echo "<td>X</td>";
	echo "<td title='Phone Number'>Pnumber</td>";
	echo "<td title='Customer First Name'>First Name</td>";
	echo "<td title='Customer Last Name'>Last Name</td>";
	echo "<td title='Customer Address'>Address</td>";
	echo "<td title='Date of the appointment'>Booking Date</td>";
	echo "<td title='Time of the Appointment'>Appointment Time</td>";
	echo "<td title='Age of the current A/C'>AC Age</td>";
	echo "<td title='Age of the current Furnace'>F Age</td>";
	echo "<td title='Whether this is a Furnace call'>F</td>";
	echo "<td title='Whether this is a A/C call'>A/C</td>";
	echo "<td title='Whether this is a Hot Water Tank call'>T</td>";
	echo "<td title='Whether this is a Boiler call'>B</td>";
	echo "<td title='Customers Cellphone Number'>CellNumber</td>";
	echo "<td title='Booking Agents Name'>First Contact</td>";
	echo "</tr>";
	RowTicker("start");
	while($brow = $bresult->fetch_assoc()){
		RowTicker("next");
		$appID=$brow["AppointmentID"];
		$idkey=$brow["IDKey"];
		$idnkey=$brow["IDNKey"];
		$ff=$brow["Fflag"];
		$af=$brow["Aflag"];
		$bf=$brow["Bflag"];
		$tf=$brow["Tflag"];
		$sql="SELECT Fname,Lname,Address,Pnumber,Zone,FAge,ACAge,CellNumber,AssignedUser FROM numbers WHERE IDNKey='$idnkey';";
		$res2 = mysqli_query($conn, $sql);
		$row2=$res2->fetch_assoc();
		$asql="SELECT Date,Start,End FROM shifts WHERE IDKey='$appID';";
		$ares = mysqli_query($conn, $asql);
		$arow=$ares->fetch_assoc();
		$appdata = $arow["Date"].":".$arow["Start"]."-".$arow["End"];
		$address=$row2["Address"];
		echo "<td><input type='radio' name='rad' value='$idkey'></td>";
		$address="<a href='https://maps.google.com?saddr=Current+Location&daddr=$address'>$address</a>";
		echorow($row2["Pnumber"]);
		echorow($row2["Fname"]);
		echorow($row2["Lname"]);
		echorow($address);
		echorow($brow["DateofBooking"]);
		echorow($appdata);
		echorow($row2["ACAge"]);
		echorow($row2["FAge"]);
		echocheck($ff);
		echocheck($af);
		echocheck($tf);
		echocheck($bf);
		echorow($row2["CellNumber"]);
		$id=$row2["AssignedUser"];
		$tsql="SELECT FName,LName FROM agents WHERE IDKey='$id'";
		$res=mysqli_query($conn, $tsql);
		$trow = $res->fetch_assoc();
		echorow($trow["FName"].$trow["LName"]);
		echo "</tr>";
	}
	echo "</table>";
}
function echorow($p){
	echo "<td>$p</td>";
}
function RowTicker($go){
	if($go=="start"){
		$GLOBALS["trc"]=0;
	}
	else{
		if($GLOBALS["trc"]==1){
			$GLOBALS["trc"];
			echo "<tr>";
			$GLOBALS["trc"]=0;
		}
		else{
			echo "<tr class='stripe'>";
			$GLOBALS["trc"]++;
		}
	}
}
function echocheck($p){
	if($p=='1'){
		echo "<td>&#10004;</td>";
	}else{
		echo "<td> &#10006; </td>";
	}
}
?>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>