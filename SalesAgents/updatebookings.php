<html>
<head>
<link rel="stylesheet" type="text/css" href="/Big Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
$idkey=$_POST["rad"];
$_SESSION["IDKey"]=$idkey;
$sql="SELECT DateofBooking,AppointmentID,Comments1,Comments2,LastContactID,IDNKey,Fflag,Aflag,Tflag,Bflag,Sflag FROM bookings WHERE IDKey='$idkey';";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$idnk=$row["IDNKey"];
$_SESSION["IDNKey"]=$idnk;
$bd=$row["DateofBooking"];
$at=$row["AppointmentID"];
$asql="SELECT Fname,Lname,Address,ACAge,FAge,Pnumber,CellNumber FROM numbers WHERE IDNKey='$idnk';";
$aresult=mysqli_query($conn, $asql);
$arow = $aresult->fetch_assoc();
$fn=$arow["Fname"];
$ln=$arow["Lname"];
$add=$arow["Address"];
$ac=$arow["ACAge"];
$fa=$arow["FAge"];
$pnum=$arow["Pnumber"];
$cell=$arow["CellNumber"];
$lc=$row["LastContactID"];
$Fflag=$row["Fflag"];
$Aflag=$row["Aflag"];
$Tflag=$row["Tflag"];
$Bflag=$row["Bflag"];
$Sflag=$row["Sflag"];
$bsql="SELECT Fname,Lname FROM agents WHERE IDKey='$lc';";
$bresult=mysqli_query($conn, $bsql);
$brow = $bresult->fetch_assoc();
$bFname=$brow["Fname"];
$bLname=$brow["Lname"];
$sql="SELECT * FROM quotes WHERE IDNKey='$idnk'";
$result = mysqli_query($conn, $sql);
$idq=0;
if (mysqli_num_rows($result)>0) {
	$row = $result->fetch_assoc();
	
	$idq=$row["IDKey"];
	$sqlj="SELECT * FROM jobs WHERE IDQKey='$idq'";
	$jresult = mysqli_query($conn, $sqlj);
	if (mysqli_num_rows($jresult)>0) {
		echo "This booking is a job!<br>";
	}
	else{
		echo "This bookings is a quote!<br>";
	}
}

echo "<table class='flags'><form action= '/SalesAgents/savebookings.php' method='post'>Appointment Info <br>";
echo "<tr><td class='flagbox'>First Name:</td><td class='flagbox'><input type='text' class='updatetext' name='Fname' value='$fn'></td></tr>";
echo "<tr><td class='flagbox'>Last Name:</td><td class='flagbox'><input type='text' class='updatetext' name='Lname' value='$ln'></td></tr>";
echo "<tr><td class='flagbox'>Address:</td><td class='flagbox'><input type='text' class='updatetext' name='Address' value='$add'></td></tr>";
echo "<tr><td class='flagbox'>Phone Number:</td><td class='flagbox'><input type='text' class='updatetext' name='Pnumber' value='$pnum'></td></tr>";
if($cell==""){
	$cell="Cell";
}
echo "<tr><td class='flagbox'>Cell:</td><td class='flagbox'><input type='text' class='updatetext' name='Cell' value='$cell'></td></tr>";
echo "<tr><td class='flagbox'>Reschedule:</td><td class='flagbox'><select name='Btime' class='Sales-select'>";
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$sql="SELECT * FROM shifts WHERE Date>'$date' AND slots>'0' AND type='sa' AND IDKey<>'0';";
$result = mysqli_query($conn, $sql);
echo "<option value='0'>No time slot yet</option>";
while($row = $result->fetch_assoc()) {
	$date=$row["Date"];
	$start=$row["Start"];
	$end=$row["End"];
	$idkey=$row["IDKey"];
	echo "<option value='$idkey'>$date, $start - $end</option>";
}
echo "</select></td></tr>";

echo "<tr><td class='flagbox'>A/C Age:</td><td class='flagbox'>
<select name='ACAge' class='Sales-select'>";
echo "<option value='$ac'>$ac</option>";
for($x=0;$x<26;$x++){
	echo "<option value='$x'>$x</option>";
}
echo "<option value='99'>25+</option>";

echo "</select>
</td></tr>";
echo "<tr><td class='flagbox'>Furnace Age:</td><td class='flagbox'>
<select name='FAge' class='Sales-select'>";
echo "<option value='$fa'>$fa</option>";
for($x=0;$x<26;$x++){
	echo "<option value='$x'>$x</option>";
}
echo "<option value='99'>25+</option>";

echo "</select>
</td></tr>";

echo "<tr><td class='flagbox'>Lead Result:</td><td class='flagbox'>
<select name='rad' class='Sales-select'>
<option value='no'>Update</option>
<option value='quote'>Quoted</option>
<option value='serv'>Service</option>
<option value='rebook'>Rebooked</option>
<option value='inspect'>Preinspect</option>
<option value='can'>Cancelled</option>

</select></td></tr>";
echo "<tr><td class='flagbox'>Price:</td><td class='flagbox'><input type='text' class='updatetext' name= 'price' value='0'></td></tr>";
echo "<tr><td class='flagbox'>Expiry:</td><td class='flagbox'><input type='date' class='updatetext' name='exp'></td></tr>";
echo "<tr><td class='flagbox'>Confirm Lead:</td></tr>
<tr><td class='flags'>Furnace:</td><td class='flagbox'><input type='checkbox' name='check' value='f'";if($Fflag==1){echo "checked";}echo "></td></tr>
<tr><td class='flags'> A/C:</td><td class='flagbox'><input type='checkbox' name='check' value='a'";if($Aflag==1){echo "checked";}echo "><br></td></tr>
<tr><td class='flags'>Water Tank:</td><td class='flagbox'><input type='checkbox' name='check' value='t'";if($Tflag==1){echo "checked";}echo "></td></tr>
<tr><td class='flags'> Boiler:</td><td class='flagbox'><input type='checkbox' name='check' value='b'";if($Bflag==1){echo "checked";}echo "></td></tr>
<tr><td class='flags'> Service:</td><td class='flagbox'><input type='checkbox' name='check' value='s'";if($Sflag==1){echo "checked";}echo "></td></tr>";
//echo "<tr><td><input type='date' name='day'></td></tr>";
echo "<tr><td class='flagbox'><input type='submit' value='Submit Edits' class='calbutton'></td>
		<input type='number' value='1' name='Mode' hidden>";

echo "</form><form action='/login.php' method='post'>";
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<input type='text' name='mode' value='0' hidden>";
echo "<td class='flagbox'>	<input type='text' name='user' value='$user' hidden> <input type='text' name='pass' value='$pass' hidden>
<input type='submit' value='Schedule' class='calbutton'></form></td></tr></table>";

/*
$what=$_SESSION["what"];
$when=$_SESSION["when"];
echo "<div id='comsect'>
<form action='/SalesAgents/bookingshow.php' method='post'>
<input type='date' value='$when' name='when' hidden>
<input type='text' value='$what' name='what' hidden>
Back to Search:<input type='submit' value='back'>
</form>
</div>";
*/

$nsql="SELECT * FROM notes WHERE IDNKey='$idnk'";
$nresult = mysqli_query($conn, $nsql);
while($nrow = $nresult->fetch_assoc()) {
	$agent=$nrow["AgentID"];
	$sql="SELECT Fname,Lname FROM agents WHERE IDKey='$agent'";
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();
	$name= $row["Fname"]." ".$row["Lname"];
	$text=$nrow["Text"];
	$time=$nrow["Date"];
	echo "<br>$time:$name said: $text";	
}
?>
<br><br>
</body>
</html>