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
$sql="SELECT Price,Expiry,DateIssued,IDBKey,IDKey FROM quotes WHERE Preinspect='1';";
$result = mysqli_query($conn, $sql);
echo "<table border='6' style='width:100%'>";
echo "<form action='/Admin/performpreinspect.php' method='post'>";
echo "<tr>";
echo "<td>X</td>";
echorow("First Name");
echorow("Last Name");
echorow("Address");
echorow("Phone#");
echorow("Zone");
echorow("Furnace");
echorow("A/C");
echorow("Price");
echorow("Expiry");
echorow("Date Issued");
echorow("Comments");
echorow("Comments2");
echo "</tr>";
while($row = $result->fetch_assoc()) {
	$bID=$row["IDBKey"];
	$csql="SELECT IDNKey FROM bookings WHERE IDKey='$bID';";
	$res3 = mysqli_query($conn, $csql);
	$row3=$res3->fetch_assoc();
	$nID=$row3["IDNKey"];
	$sql="SELECT Fname,Lname,Address,Pnumber,Zone,FAge,ACAge,Comments1,Comments2 FROM numbers WHERE IDNKey='$nID';";
	$res2 = mysqli_query($conn, $sql);
	$row2=$res2->fetch_assoc();
	echo "<tr>";
	$idQkey=$row["IDKey"];
	echo "<td><input type='radio' name='rad' value='$idQkey'></td>";
	echorow($row2["Fname"]);
	echorow($row2["Lname"]);
	echorow($row2["Address"]);
	echorow($row2["Pnumber"]);
	echorow($row2["Zone"]);
	echorow($row2["FAge"]);
	echorow($row2["ACAge"]);
	echorow($row["Price"]);
	echorow($row["Expiry"]);
	echorow($row["DateIssued"]);
	echorow($row2["Comments1"]);
	echorow($row2["Comments2"]);
	echo "</tr>";
}
echo "</table>";
echo "<input type='submit' value='submit'>";
echo "</form>";


function echorow($p){
	echo "<td>$p</td>";
}
?>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>