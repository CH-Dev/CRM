<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<div id="numsect">
<?php 
$idkey=$_POST["rad"];
session_start();
$username=$_SESSION["username"];//Connect to the database
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$space=" ";
$sql="SELECT * FROM numbers WHERE IDNKey='$idkey'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) ==1) {
	$row = $result->fetch_assoc();
	echo "#".$row["Pnumber"]."<br>".$row["Fname"].",".$row["Lname"]."<br>".$row["Address"]."<br>".$row["Comments1"]."<br>".$row["Comments2"];
	$_SESSION["IDNKey"]=$row["IDNKey"];
}
$fage=$row["FAge"];
$acage=$row["ACAge"];
$cbd=$row["CBDate"];
$cbt=$row["CBTime"];
?>
</div>
<form action='/CallCenterAgents/callresult.php' method='post'>
<div id="resultsect">
Response:<select name='rad'>
<option value='CB'>Call Back</option>
<option value='booked'>booked</option>
<option value='DNC'>Do Not Call</option>
<option value='NI'>Not Interested</option>
<option value='o'>Uncalled</option>
<option value='B'>Business</option>
<option value='NA'>No Answer</option>
<option value='NS'>No Signal</option>
<option value='DNQ'>Does Not Qualify</option>
<option value='APP'>Renting</option>
</select><br>

<?php 
echo "Age of AC:<br><input type='text' name='acage' value='$acage'><br>";
echo "Age of Furnace:<br><input type='text' name='fage' value='$fage'><br>";
echo "Call Back date:<br><input type='text' name='cbtime' value='$cbd'> DD/MM/YY<br>";
echo "Call Back time:<br><input type='text' name='cbt' value='$cbt'> <br>";
?>
Appointment type:<br>
Furnace:<input type='checkbox' name='check' value='f'> A/C:<input type='checkbox' name='check' value='a'><br>
Water Tank:<input type='checkbox' name='check' value='t'> Boiler:<input type='checkbox' name='check' value='b'><br>
<?php 
echo "Time Slot:<select name='Btime'>";
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$sql="SELECT * FROM shifts WHERE Date>'$date' AND slots>'0' AND type='sa';";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$date=$row["Date"];
	$start=$row["Start"];
	$end=$row["End"];
	$idks=$row["IDKey"];
	$z=$row["Zone"];
	echo "<option value='$idks'>$date, $start - $end, $z</option>";
}
echo "</select>";
?>
<input type='submit' value='submit'>
<form action="/CallCenterAgents/Callbacks.php" method="post">
<input type="submit" value="Cancel">
</form>
</div>
<div id="datasect">
</form>

<form action="transfercallback.php" method="post">
Give to:<input type="number" name="newid"><br>
This is the ID Key of the receiving agent, please ensure accuracy or the callback<br>
could be lost! You will receive 25% of normal payment when you transfer this way.<br>
The receiver will get 75% of normal payment.<br>
<?php 
echo "<input type='number' name='idkey' value='$idkey' hidden>";
?>
<input type="submit" value="Complete Transfer">
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</div>
</body>
</html>