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
$_SESSION["jib"]=$_POST["rad"];
$id=$_POST["rad"];
$sql="SELECT * from jobs WHERE IDKey='$id'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$idq=$row["IDQKey"];
$qsql="SELECT * FROM quotes WHERE IDKey='$idq'";
$qresult = mysqli_query($conn, $qsql);
$qrow = $qresult->fetch_assoc();
$idb=$qrow["IDBKey"];
$bsql="SELECT * FROM bookings WHERE IDKey='$idb'";
$bresult = mysqli_query($conn, $bsql);
$brow = $bresult->fetch_assoc();
$idn=$brow["IDNKey"];
$nsql="SELECT * FROM numbers WHERE IDNKey='$idn'";
$nresult = mysqli_query($conn, $nsql);
$nrow = $nresult->fetch_assoc();
$isql="SELECT * FROM images WHERE IDQKey='$idq'";
$iresult = mysqli_query($conn, $isql);
$ssql="SELECT * FROM scopes WHERE IDQKey='$idq'";
$sresult = mysqli_query($conn, $ssql);
$psql="SELECT * FROM parts WHERE IDQKey='$idq'";
$presult = mysqli_query($conn, $psql);



echo "Customer Information:<br>".$nrow["Fname"]." ".$nrow["Lname"]."<br>".$nrow["Address"]."<br>".$nrow["Zone"]."<br>".$nrow["Pcode"]."<br>".$nrow["Pnumber"]
	."<br>".$nrow["Email"]."<br>".$nrow[""]."<br>Scopes:<br>";

while($srow = $sresult->fetch_assoc()){//Print scopes
	echo "<br>".$srow["AgentID"]."says: ".$srow["Text"];
}
echo "Images:";
while($irow = $iresult->fetch_assoc()){
	$link=$irow["Link"];
	echo "<img src='$link' alt='Image' width='500' height='500'><br>";
}
echo "Part List:";
while($prow = $presult->fetch_assoc()){
	echo "<br>".$srow["AgentID"]."says: ".$srow["Text"];
}
$_SESSION["IDQKey"]=$idq;
?>
<br>
Flag as Complete:<form action="/InstallLeader/completeJob.php"><br>
Number of Units Installed:<input type="number" name='numunits'>
<input type="submit" value="Complete">
</form><br>
Modify Part list:<form action="/Inventory/Partslist.php" method="post">
<input type="number" value="$IDQ" name="IDQ" hidden>
<input type="submit">
</form>
Add a Scope:<form action='/InstallLeader/createscope.php'>
<input type='submit' value='Complete'>
</form><br>
to Job List:<form action="/InstallLeader/jobs.php">
<input type="submit" value="cancel">
</form><br>
to Portal:<form action="/InstallLeader/leaderportal.php">
<input type="submit" value="cancel">
</form><br>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>