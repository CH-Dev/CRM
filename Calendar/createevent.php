<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$date=$_POST["date"];
$stime=$_POST["stime"];
$etime=$_POST["etime"];
$type=$_POST["type"];
$idnum=$_SESSION["idnum"];
$cdate = substr(date('Y/m/d H:i:s'),0,10);
$cdate=str_replace('/', '-', $cdate);
$slots='';
$slots=$_POST["slots"];
$zone='0';
$zone=$_POST["zone"];
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

	$bsql="SELECT IDKey FROM weeks WHERE Start<='$date' AND End>='$date';";
	$result = mysqli_query($conn, $bsql);
	$row = $result->fetch_assoc();
	$wid=$row["IDKey"];
	if($stime=="box"){
		$asql="INSERT INTO shifts (Date,Start,End,DateBooked,AgentID,Type,slots,WID,Zone)
		VALUES ('$date','10AM','1PM','$cdate','$idnum','$type','$slots','$wid','$zone')";
		$bsql="INSERT INTO shifts (Date,Start,End,DateBooked,AgentID,Type,slots,WID,Zone)
		VALUES ('$date','1PM','4PM','$cdate','$idnum','$type','$slots','$wid','$zone')";
		$csql="INSERT INTO shifts (Date,Start,End,DateBooked,AgentID,Type,slots,WID,Zone)
		VALUES ('$date','5PM','8PM','$cdate','$idnum','$type','$slots','$wid','$zone')";
		if (mysqli_query($conn, $asql)) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $asql . "<br>" . mysqli_error($conn);
		}
		if (mysqli_query($conn, $bsql)) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $bsql . "<br>" . mysqli_error($conn);
		}
		if (mysqli_query($conn, $csql)) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $csql . "<br>" . mysqli_error($conn);
		}
	}
	else{
		$sql="INSERT INTO shifts (Date,Start,End,DateBooked,AgentID,Type,slots,WID,Zone)
		VALUES ('$date','$stime','$etime','$cdate','$idnum','$type','$slots','$wid','$zone')";
		if (mysqli_query($conn, $sql)) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
	
function echorow($p){
	echo "<td>$p</td>";
}
?>
<br>
<form action="/Calendar/event.php" method="post">
Back:<input type="submit" value="Back">
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>