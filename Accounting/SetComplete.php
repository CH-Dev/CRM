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
$idj=$_POST["idj"];
$date=$_POST["date"];
echo $date;
$sql="UPDATE jobs SET Complete='1',DateofCompletion='$date' WHERE IDKey='$idj'";
$result = mysqli_query($conn, $sql);

$jsql="SELECT bookings.IDNKey,bookings.Fflag,bookings.Aflag,bookings.Tflag,bookings.Bflag FROM jobs INNER JOIN quotes ON jobs.IDQKey=quotes.IDKey INNER JOIN bookings ON quotes.IDNKey=bookings.IDNKey WHERE jobs.IDKey='$idj'";

$jresult = mysqli_query($conn, $jsql);
$jrow = $jresult->fetch_assoc();
$idn=$jrow["IDNKey"];
$ff=$jrow["Fflag"];
$af=$jrow["Aflag"];
$tf=$jrow["Tflag"];
$bf=$jrow["Bflag"];
$count=0;
$bcount=0;
if($ff==1){
	$count=$count+1;
	$bcount=$bcount+1;
}
if($af==1){
	$count=$count+1;
	$bcount=$bcount+1;
}
if($tf==1){
	$count=$count+0.5;
	$bcount=$bcount+1;
}
if($bf==1){
	$count=$count+1;
	$bcount=$bcount+1;
}
$wsql="SELECT IDKey FROM weeks WHERE Start<='$date' AND End>='$date'";
$wresult = mysqli_query($conn, $wsql);
$wrow = $wresult->fetch_assoc();
$wid=$wrow["IDKey"];
$asql="SELECT * FROM agents WHERE PayType='U' OR idkey IN (SELECT AssignedUser FROM numbers WHERE IDNKey='$idn')";
$aresult = mysqli_query($conn, $asql);
while($arow = $aresult->fetch_assoc()){
	$comm=$arow["Comm"];
	$AID=$arow["IDKey"];
	$paytype=$arow["PayType"];
	if($paytype=='S'){
		$price=$comm*$count;
	}else if($paytype=='U'){
		$price=$comm*$bcount;
	}
	
	$usql="INSERT INTO payments (AgentID,WID,Amount,Type,Method,IDNKey) VALUES ('$AID','$wid','$price','CCB','Job marked as Complete','$idn')";
	mysqli_query($conn, $usql);
}
?>

<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>