<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM Index</title>
<script src="/sorttable.js"></script>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$id=$_SESSION["idnum"];
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql="SELECT Date,Start,End,DateBooked,IDKey FROM shifts WHERE AgentID='$id'";
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
if($_POST["past"]==1){
	$sql=$sql." AND Date<='$date' ORDER BY Date DESC, Start";
}
else{
	$sql=$sql." AND Date>='$date' ORDER BY Date, Start";
}
$result = mysqli_query($conn, $sql);

echo "<form action='updateevent.php' method='post'>";
echo "<table border='6' style='width:100%' class='sortable'>";
echo "<tr>";
echo "<td>X</td>";
echorow("Date of Shift");
echorow("Start");
echorow("End");
echorow("Date Booked");
echo "</tr>";
while($row = $result->fetch_assoc()) {
	echo "<tr>";
	$key=$row["IDKey"];
	echo "<td><input type='radio' name='rad' value='$key'></td>";
	echorow($row["Date"]);
	echorow($row["Start"]);
	echorow($row["End"]);
	echorow($row["DateBooked"]);
	echo "</tr>";
}
function echorow($p){
	echo "<td>$p</td>";
}
echo "edit:<input type='submit' value='Edit'>";
echo "</table>";
echo "</form>";
?>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>
