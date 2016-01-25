<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<form action="/Calendar/createevent.php" method="post">

Date of Event:<input type="date"name="date">MM/DD/YYYY<br>
Event Type:
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$Accounttype=$_SESSION["AccountType"];
if($Accounttype=='0'){//Call Center Agent
	echo "Start Time:<input type='text' name='stime' value='12pm'><br>
End Time:<input type='text' name='etime' value='8pm'><br>";
	echo "<select name='type'>";
	echo "<option value='cc'>Call Center Shift</option>";
	echo "</select>";
	echo "<input type='text' hidden value='0' name='slots'>";
	echo "<input type='text' hidden value='0' name='zone'>";
}
if($Accounttype=='11'){//Sales Manager
	echo "<input type='text' name='stime' value='box' hidden>
<input type='text' name='etime' value='box' hidden>";
	echo "<br>10-1<input type='checkbox' name='slots[]' value='early' checked><br>
1-4<input type='checkbox' name='slots[]' value='mid' checked><br>
5-8<input type='checkbox' name='slots[]' value='late' checked><br>";
	echo "<select name='type'>";
	echo "<option value='sa'>Sales Shift</option>";
	echo "<option value='ha'>Hour Shift</option>";
	echo "</select><br>";
	echo "Slots:<input type='number' name='slots' value='3'>";
	//echo "Zone:<input type='text' name='zone' value=' Ottawa'>";
	echo "Zone:<select name='zone'>";
	$zsql="SELECT DISTINCT Zone FROM numbers";
	$result = mysqli_query($conn, $zsql);
	while($row = $result->fetch_assoc()) {
		$z=$row["Zone"];
		echo "<option value='$z'>$z</option>";
	}
	echo "</select>";
}
if($Accounttype=='10'){//Crew Leader
	echo "Start Time:<input type='text' name='stime' value='12pm'><br>
End Time:<input type='text' name='etime' value='8pm'><br>";
	echo "<select name='type'>";
	echo "<option value='cs'>Crew Shift</option>";
	echo "</select><br>";
	echo "<input type='text' hidden value='0' name='slots'>";
	echo "<input type='text' hidden value='0' name='zone'>";
}
?>
<input type="submit" value="Add Shift">
</form>
<form action="/Calendar/showevents.php" method="post">
<input type="hidden" name="past" value='0'>
Past Shifts:<input type="checkbox" name="past" value='1'>

View My Shifts<input type="submit" value="View">
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>