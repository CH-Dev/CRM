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
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$jid=$_POST["rad"];
$_SESSION["jib"]=$jid;
$asql="SELECT IDQKey FROM jobs WHERE IDKey='$jid'";
$result = mysqli_query($conn, $asql);
$row = $result->fetch_assoc();
$IDQ=$row["IDQKey"];
?>
Modify Part list:<form action="/Inventory/Partslist.php" method="post">
<?php echo"<input type='number' value='$IDQ' name='IDQ' hidden>";?>
<input type="submit">
</form>
Flag as Complete:<form action="/InstallLeader/completeJob.php" method="post">
<input type="date" name="day">
<?php echo"<input type='number' value='$IDQ' name='IDQ' hidden>";?>
<input type="submit">
</form>
Assign Job:<form action="/Inventory/assignjob.php" method="post">
<?php echo"<input type='number' value='$IDQ' name='IDQ' hidden>";?>
<select name="who">
<?php 
$sql="SELECT * FROM agents WHERE AccountType='10'";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$aid=$row["IDKey"];
	$fn=$row["Fname"];
	$ln=$row["Lname"];
	echo "<option value='$aid'>$fn,$ln</option>";
}
?>
</select>
<input type="submit">
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>
