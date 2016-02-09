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
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$oosql="SELECT count(*) FROM ootracker WHERE AgentID='$idnum' AND DateofContact='$date'";
$oo2sql="SELECT count(*) FROM ootracker WHERE AgentID='$idnum' AND DateofContact='$date' AND Response='NA'";
$result = mysqli_query($conn, $sql);
$ooresult=mysqli_query($conn, $oosql);
$ooresult2=mysqli_query($conn, $oosql2);
$row = $result->fetch_assoc();
$oorow=$ooresult->fetch_assoc();
$oorow2=$ooresult2->fetch_assoc();
$count=$row["count(*)"]+$oorow["count(*)"];
echo "You've called ".$count." people today!";
$sql="SELECT count(*) FROM numbers WHERE AssignedUser='$idnum' AND DateofContact='$date' AND Response='booked'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
echo "<br>You've booked ".$row["count(*)"]." appointments today!";
$sql="SELECT count(*) FROM numbers WHERE AssignedUser='$idnum' AND Response='o'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
echo "<br>You have ".$row["count(*)"]." uncalled numbers left!";
echo "<br>".$oorow2["count(*)"]." people didn't answer so far today.";
$sql="SELECT count(*) FROM bookings WHERE LastContactID='$idnum'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
echo "<br>You've booked ".$row["count(*)"]." appointments so far!";
$sql="SELECT count(*) FROM numbers WHERE AssignedUser='$idnum' AND response!='o'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$oosql="SELECT count(*) FROM ootracker WHERE AgentID='$idnum'";
$ooresult=mysqli_query($conn, $oosql);
$oorow=$ooresult->fetch_assoc();
$count2=$row["count(*)"]+$oorow["count(*)"];
echo "<br>You've called ".$count2." people total!";
$dnq="SELECT count(*) FROM numbers WHERE AssignedUser='$idnum' AND DateofContact='$date' AND (Response='DNQ')";
$qresult = mysqli_query($conn, $dnq);
$qrow = $qresult->fetch_assoc();
echo "<br>You've had ".$qrow["count(*)"]." DNQ's Today!";
$sql="SELECT count(*) FROM numbers WHERE AssignedUser='$idnum' AND response='CB'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
echo "<br>You've got ".$row["count(*)"]." Callbacks scheduled!";
?>
<br><br>
Please Choose an Action:
<form action="/CallCenterAgents/getnextnumber.php" method="post">
Begin Calling:<input type="submit" value="Next Number">
</form>
<form action="/CallCenterAgents/Callbacks.php" method="post">
Manage Callbacks:<input type="submit" value="Callbacks">
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>