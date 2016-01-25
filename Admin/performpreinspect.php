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
echo "<div id='resultsect'>";
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$idqkey=$_POST["rad"];
$_SESSION["IDQKey"]=$idqkey;
$sql="SELECT Link FROM images WHERE IDQKey='$idqkey'";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$link=$row["Link"];
	echo "<img src='/SalesAgents/$link' alt='Image' width='500' height='500'><br>";
}
echo "</div>";
$bsql="SELECT IDBKey FROM quotes WHERE IDKey='$idqkey';";
$bresult = mysqli_query($conn, $bsql);
$brow = $bresult->fetch_assoc();
$idbkey=$brow["IDBKey"];
$_SESSION["IDBKey"]=$idbkey;
$csql="SELECT Comments1,Comments2,IDNKey FROM bookings WHERE IDKey='$idbkey';";
$cresult = mysqli_query($conn, $csql);
$crow = $cresult->fetch_assoc();
$idn=$crow["IDNKey"];
$dsql="SELECT Fname,Lname,Pnumber,Address,Zone,FAge,ACAge,Comments1,Comments2 FROM numbers WHERE IDNKey='$idn'";
$dresult = mysqli_query($conn, $dsql);
$drow = $dresult->fetch_assoc();
$fn=$drow["Fname"];$ln=$drow["Lname"];$add=$drow["Address"];$pnum=$drow["Pnumber"];$z=$drow["Zone"];$fage=$drow["FAge"];$acage=$drow["ACAge"];
$com1=$drow["Comments1"];$com2=$drow["Comments2"];$com3=$crow["Comments1"];$com4=$crow["Comments2"];

echo "<div id='datasect'>";
echo "Customer Information<br>";
echo "Name:<br> $fn $ln<br>";
echo "Address: $add<br>";
echo "Phone number: $pnum <br>";
echo "Zone: $z<br>";
echo "Furnace Age: $fage<br>";
echo "A/C Age: $acage<br>";
echo "Comments:<br> $com1<br>$com2<br>$com3<br>$com4<br>";

?>
<form action="/Admin/updatequote.php" method="post">
Quote Amount:<input type="number" name="price"><br>
Expiry Date:<input type="date" name="expiry"><br>
<?php 
echo "Comments:<input type='text' name='com'value='$com3'><br>";
?>
Done:<input type="submit" value="Finish Preinspect">
</form>
<form action="/Admin/viewpreinspects" method="post">
Back:<input type="submit" value="Back">
</form>
</div>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>