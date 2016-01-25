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
// Check connection
echo "<div id='resultsect'>";
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$p=$_POST["IDNKey"];
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$apptid=$_POST["Btime"];
$sid=$_POST["salesman"];
$flags=$_POST["check"];
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
$sql="INSERT INTO bookings (IDNKey,DateofBooking,LastContactID,AppointmentID,SalesmanID,Fflag,Aflag,Tflag,Bflag)
		VALUES('$p','$date','0','$apptid','$Fflag','$Aflag','$Tflag','$Bflag')";
$result = mysqli_query($conn, $sql);
?>
<br>
<form action="/Admin/Addnumber.php" method="post">
Add another Number<input type='submit' value='Next'>
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>