<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<script src="/sorttable.js"></script>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$idnum=$_SESSION["idnum"];
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$what=$_POST["what"];
$when=$_POST["when"];
$_SESSION["when"]=$when;
$_SESSION["what"]=$what;
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql="SELECT numbers.CellNumber,agents.Fname AS 'Aname',numbers.Address,bookings.IDKey AS 'IDBKey',CONCAT(numbers.Fname,' ',numbers.Lname) AS 'cusn',numbers.Pnumber,numbers.FAge,numbers.ACAge,bookings.Fflag,bookings.Aflag,bookings.Tflag,bookings.Bflag,bookings.Sflag,CONCAT(agents.Fname,' ',agents.Lname) AS 'agentN',shifts.Date,CONCAT(shifts.Start,'-',shifts.END) AS 'time' FROM bookings INNER JOIN numbers ON bookings.IDNKey=numbers.IDNKey INNER JOIN agents ON bookings.LastContactID=agents.IDKey INNER JOIN shifts ON bookings.AppointmentID=shifts.IDKey WHERE bookings.SalesmanID='0'
AND (numbers.Fname LIKE '%$what%' OR numbers.Lname LIKE '%$what%' OR numbers.Address LIKE '%$what%' OR numbers.Zone LIKE '%$what%'OR numbers.Pcode LIKE '%$what%' OR shifts.Date='$when' OR numbers.IDNKey='$what' OR bookings.IDKey='$what' OR bookings.DateofBooking='$when' OR numbers.Pnumber LIKE '%$what%')";

echo "<form action='/SalesManager/assignbooking.php' method='post'>";
echo "<table border='6' style='width:100%' class='sortable'>";
//echo $sql;
$result = mysqli_query($conn, $sql);
echo "<tr>";
echo "<td>X</td>";
echo "<td title='Phone Number'>Pnumber</td>";
echo "<td title='Customer Name'>Name</td>";
echo "<td title='Customer Address'>Address</td>";
echo "<td title='Date of the appointment'>Booking Date</td>";
echo "<td title='Time of the Appointment'>Appointment Time</td>";
echo "<td title='Age of the current A/C'>AC Age</td>";
echo "<td title='Age of the current Furnace'>F Age</td>";
echo "<td title='Whether this bookings involves, a Furnace, A/C, Hot Water Tank or Boiler(From left to right)'>Flags</td>";
echo "<td title='Customers Cellphone Number'>CellNumber</td>";
echo "<td title='Booking Agents Name'>FName</td>";
echo "</tr>";
RowTicker("start");
while($row = $result->fetch_assoc()) {
	$idkey=$row["IDBKey"];
	RowTicker("next");
	echo "<td><input type='checkbox' name='rad[]' value='$idkey'></td>";
	
	$cusn=$row["cusn"];
	$fage=$row["FAge"];
	$acage=$row["ACAge"];
	$fflag=$row["Fflag"];
	$aflag=$row["Aflag"];
	$bflag=$row["Bflag"];
	$tflag=$row["Tflag"];
	$sflag=$row["Sflag"];
	$date=$row["Date"];
	$time=$row["time"];
	$pnum=$row["Pnumber"];
	$add=$row["Address"];
	$Aname=$row["Aname"];
	$cell=$row["CellNumber"];
	$add="<a href='https://maps.google.com?saddr=Current+Location&daddr=$add'>$add</a>";
	echorow("$pnum");
	echorow("$cusn");
	echorow("$add");
	echorow("$date");
	echorow("$time");

	echorow("$fage");
	echorow("$acage");
	$temp=echocheck($fflag).echocheck($aflag).echocheck($tflag).echocheck($bflag).echocheck($sflag);
	echo "<td>$temp</td>";
	echorow("$cell");
	echorow("$Aname");
	echo "</tr>";
	}
function echorow($p){
	echo "<td>$p</td>";
}
function echocheck($p){
	if($p=='1'){
		return  "&#10004";
	}else{
		return "&#10006";
	}
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
?>
</table>

<select name='who'>
<?php 
$idnum=$_SESSION["idnum"];
$asql="SELECT * FROM agents WHERE SupervisorID='$idnum' AND AccountType='1'";
$aresult = mysqli_query($conn, $asql);
while($arow = $aresult->fetch_assoc()) {
	$aid=$arow["IDKey"];
	$fn=$arow["Fname"];
	$ln=$arow["Lname"];
	echo "<option value='$aid'>$fn,$ln</option>";
}
?>
	
</select>
<input type='submit' value='submit'>
</form>

<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>