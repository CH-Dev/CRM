<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
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
$date = substr(date('Y/m/d H:i:s'),0,10);
$ddate=str_replace('/', '-', $date);
$fname=$_POST["fname"];
$lname=$_POST["lname"];
$add=$_POST["add"];
$resp=$_POST["rad"];
$idn=$_POST["idn"];
$timeslot=$_POST["Btime"];
$who=$_POST["who"];
$sql="UPDATE numbers SET Fname='$fname',Lname='$lname',Address='$add',Response='$resp' WHERE IDNKey='$idn'";
mysqli_query($conn, $sql);
echo "Number has been updated successfully!";
$bsql="SELECT count(*) FROM bookings WHERE IDNKey='$idn'";
$bresult = mysqli_query($conn, $bsql);
$brow = $bresult->fetch_assoc();
if(isset($_POST["check"])){

	$flags=$_POST["check"];
	$flags="";
	$Aflag='0';
	$Fflag='0';
	$Tflag='0';
	$Bflag='0';
	$l=count($flags);
	for($x=0;$x<$l;$x++){
		if($flags[$x]=='a'){
			$Aflag='1';
		}
		else if($flags[$x]=='f'){
			$Fflag='1';
		}
		else if($flags[$x]=='t'){
			$Tflag='1';
		}
		else if($flags[$x]=='b'){
			$Bflag='1';
		}
	}
	if($brow["count(*)"] ==1 && $resp=='booked'){
		$csql="UPDATE bookings SET LastContactID='$who',AppointmentID='$timeslot',DateofBooking='$ddate',Aflag='$Aflag',Fflag='$Fflag',Tflag='$Tflag',Bflag='$Bflag' WHERE IDNKey='$idn'";
		mysqli_query($conn, $csql);
		echo "The current booking has been updated!";
	}
	else if ($brow["count(*)"] ==0 && $resp=='booked') {
		$csql="INSERT INTO bookings (IDNKey,LastContactID,AppointmentID,DateofBooking,Aflag,Fflag,Tflag,Bflag) VALUES ('$idn','$who','$timeslot','$ddate','$Aflag','$Fflag','$Tflag','$Bflag')";
		mysqli_query($conn, $csql);
		echo "A booking has been created successfuly!";
	}
}

$dsql="INSERT INTO notes (Text,AgentID,Date,IDNKey) VALUES ('$idnum has modified this number.',$idnum'','$ddate','$idn')";
mysqli_query($conn, $dsql);
?>

<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>