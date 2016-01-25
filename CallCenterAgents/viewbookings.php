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
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$idkey=$_SESSION["idnum"];
$sql="SELECT bookings.IDKey,numbers.Fname,numbers.Lname,numbers.Address,numbers.FAge,numbers.ACAge,shifts.Date,shifts.Start,bookings.Cancelled,bookings.Fflag,bookings.Aflag,bookings.Tflag,bookings.Bflag,bookings.Sflag,bookings.DateofBooking,shifts.End FROM bookings INNER JOIN numbers ON bookings.IDNKey=numbers.IDNKey INNER JOIN shifts ON shifts.IDKey=bookings.AppointmentID WHERE bookings.LastContactID='$idkey'";
//$sql="SELECT IDKey,IDNKey,DateofBooking,AppointmentID,Comments1,Comments2,Cancelled,Fflag,Aflag,Tflag,Bflag FROM bookings WHERE LastContactID='$idkey'";
// echo "<form action='/CallCenterAgents/viewpics.php' method='post'>";
echo "<table border='6' style='width:100%' class='sortable'>";
//echo $sql;
$result = mysqli_query($conn, $sql);
echo "<tr>";
echo "<td>X</td>";
echo "<td title='Customers First Name'>First Name</td>";
echo "<td title='Customers Last Name'>Last Name</td>";
echo "<td title='Customers Address'>Address</td>";
echo "<td title='Date of booking'>Booking Date</td>";
echo "<td title='Appointment Time'>Appointment Time</td>";
echo "<td title='Age of A/C'>AC Age</td>";
echo "<td title='Age of Furnace'>FAge</td>";
echo "<td title='Furnace involved?'>F</td>";
echo "<td title='Air Conditioner involved?'>A/C</td>";
echo "<td title='Water Tank involved?'>T</td>";
echo "<td title='Boiler involved?'>B</td>";
echo "<td title='Service Call?'>S</td>";
echo "</tr>";
RowTicker("start");
while($row = $result->fetch_assoc()) {
	RowTicker("next");
	$idkey=$row["IDKey"];
	$appdata = $row["Date"].":".$row["Start"]."-".$row["End"];
	$idqkey="";
	echo "<td><input type='radio' name='rad' value='$idkey'></td>";
	echorow($row["Fname"]);
	echorow($row["Lname"]);
	echorow($row["Address"]);
	echorow($row["DateofBooking"]);
	echorow($appdata);
	echorow($row["ACAge"]);
	echorow($row["FAge"]);
	echocheck($row["Fflag"]);
	echocheck($row["Aflag"]);
	echocheck($row["Tflag"]);
	echocheck($row["Bflag"]);
	echocheck($row["Sflag"]);
	echo "</tr>";
}
function echorow($p){
	echo "<td>$p</td>";
}
function echocheck($p){
	if($p=='1'){
		echo "<td>&#10004;</td>";
	}else{
		echo "<td> &#10006; </td>";
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
echo "</table>";
echo "View Pics<input type='submit' value='submit'>";
echo "</form>";
?>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>