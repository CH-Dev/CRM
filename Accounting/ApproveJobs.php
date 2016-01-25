<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM Index</title>
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
$fn=$_POST["fn"];
$ln=$_POST["ln"];
$add=$_POST["add"];
$pcode=$_POST["pcode"];
$salesman=$_POST["salesman"];
$price=$_POST["price"];

$mode=$_POST["mode"];

$idn=$_POST["idn"];
$idq=$_POST["idq"];
$flags=$_POST["check"];
$Aflag='0';
$Fflag='0';
$Tflag='0';
$Bflag='0';
$Sflag='0';
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
	else if($flags[$x]=='s'){
		$Sflag='1';
	}
}
$nsql="UPDATE numbers SET Fname='$fn',Lname='$ln',Address='$add',Pcode='$pcode' WHERE IDNKey='$idn'";
mysqli_query($conn, $nsql);
$bsql="UPDATE bookings SET Fflag='$Fflag',Aflag='$Aflag',Tflag='$Tflag',Bflag='$Bflag',Sflag='$Sflag' WHERE IDNKey='$idn'";
mysqli_query($conn, $bsql);
$qsql="UPDATE quotes SET Price='$price',SalesmanID='$salesman',Approved='1' WHERE IDNKey='$idn'";
mysqli_query($conn, $qsql);
if($mode==0){
	$sdate=$_POST["startdate"];
	$jsql="INSERT INTO jobs (IDQKey,StartDate) VALUES ('$idq','$sdate')";
	mysqli_query($conn, $jsql);
	echo "Job Created Successfully!<br>";
}else{
	echo "Information updated succesfully!<br>";
}

?>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>