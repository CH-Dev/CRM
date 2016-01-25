<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$at=$_SESSION["AccountType"];
if($at==1){
	echo "<link rel='stylesheet' type='text/css'' href='Big Style.css'>";
}
$IDNKey=$_POST["idnkey"];
//echo $IDNKey;
$sql="SELECT Fname,Lname,Pnumber,Address,Response,DateofContact FROM numbers WHERE IDNKey='$IDNKey'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$bsql="SELECT Cancelled,Fflag,Aflag,Bflag,Tflag,AppointmentID FROM bookings WHERE IDNKey='$IDNKey'";
$bresult = mysqli_query($conn, $bsql);
$brow = $bresult->fetch_assoc();
$apptID=$brow["AppointmentID"];
$shQL="SELECT Date FROM shifts WHERE IDKey='$apptID'";
$shresult = mysqli_query($conn, $shQL);
$shrow = $shresult->fetch_assoc();
$qsql="SELECT IDKey,Price,DateIssued,Approved,Expiry,Preinspect FROM quotes WHERE IDNKey='$IDNKey'";
$qresult = mysqli_query($conn, $qsql);
$qrow = $qresult->fetch_assoc();
$IDQKey=$qrow["IDKey"];
$jsql="SELECT Complete,DateofCompletion,EstCompletion FROM jobs WHERE IDQKey='$IDQKey'";
$jresult = mysqli_query($conn, $jsql);
$jrow = $jresult->fetch_assoc();
$ssql="SELECT Text,AgentID FROM scopes WHERE IDQKey='$IDQKey'";
$sresult = mysqli_query($conn, $ssql);
$srow = $sresult->fetch_assoc();
$s2sql="SELECT count(*) FROM scopes WHERE IDQKey='$IDQKey'";
$s2result = mysqli_query($conn, $s2sql);
$s2row = $s2result->fetch_assoc();
$nsql="SELECT Text,AgentID,Date FROM notes WHERE IDNKey='$IDNKey'";
$nresult = mysqli_query($conn, $nsql);
$nrow = $nresult->fetch_assoc();
$psql="SELECT Link FROM images WHERE IDQKey='$IDQKey'";
$presult = mysqli_query($conn, $psql);
$prow = $presult->fetch_assoc();
$fflag=echocheck($brow["Fflag"]);
$aflag=echocheck($brow["Aflag"]);
$tflag=echocheck($brow["Tflag"]);
$bflag=echocheck($brow["Bflag"]);
$Can=echocheck($brow["Cancelled"]);
$address=$row["Address"];
?>
<table>
<tr>
<td>Name</td>
<td>Phone #</td>
<td>Address</td>
<td>Response</td>
</tr>
<tr>
<td><?php echo $row["Fname"]." ".$row["Lname"];  ?></td>
<td><?php echo $row["Pnumber"]; ?></td>
<td><?php echo "<a href='https://maps.google.com?saddr=Current+Location&daddr=$address'>$address</a>"; ?></td>




<td><?php echo $row["Response"]; ?></td>
</tr>

<?php 
$shdate=$shrow["Date"];
$dateofContact=$row["DateofContact"];
$app=echocheck($qrow["Approved"]);
$pre=echocheck($qrow["Preinspect"]);
$resp=$qrow["Response"];
$issued=$qrow["DateIssued"];
$comp=echocheck($jrow["Completed"]);
$dcomp=$jrow["DateofCompletion"];
$dest=$jrow["EstCompletion"];
$resp=$qrow["Response"];
if (mysqli_num_rows($bresult) >0) {
	echo "<tr>
<td>Cancelled?</td>
<td>Flags</td>
<td>Date of Booking</td>
<td>Date Contacted</td>
</tr>
<tr>
<td> $Can</td>
<td>$fflag$aflag$tflag$bflag</td>
<td>$shdate</td>
<td>$dateofContact</td>
</tr>";
}
if (mysqli_num_rows($qresult) >0) {
echo "
		<tr>
<td>Date Issued</td>
<td>Approved?</td>
<td>Preinspect?</td>
<td></td>
</tr>
<tr>
<td>$issued</td>
<td>$app</td>
<td>$pre</td>
<td>$resp</td>
</tr>
";
}
if (mysqli_num_rows($jresult) >0) {
	echo "<tr>
<td>Job completed?</td>
<td>Completion Date:</td>
<td>Est. Completion Date:</td>
<td></td>
</tr>
<tr>
<td>$comp</td>
<td>$dcomp</td>
<td>$dest</td>
<td>$resp</td>
</tr>
		
		
		";
}
echo "</table><form action='/Calendar/CreateNote.php' method='post'>
<input type='text' value='' name='text'>
<input type='submit' value='Note'>
</form><br>
<form action='/SalesManager/createreminder.php' method='post'>
<input type='number' value='$IDNKey' name='idn' hidden><input type='submit' value='Reminder'></form><br>";
?>




<?php 
$at=$_SESSION["AccountType"];
if($at==1){
	
}
function echocheck($p){
	if($p=='1'){
		return "&#10004";
	}else{
		return "&#10006";
	}
}
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
<input type='submit' value='Menu'></form><br>";
?>
</body>
</html>