<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<script src="/sorttable.js"></script>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$idnum=$_SESSION["idnum"];
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$_SESSION["what"]=$_POST["what"];
$_SESSION["when"]=$_POST["when"];
$what=$_POST["what"];
$when=$_POST["when"];
$idnum=$_SESSION["idnum"];
$asql="SELECT Fname,Lname,IDKey from agents WHERE SupervisorID='$idnum' AND AccountType='1'";
$aresult = mysqli_query($conn, $asql);
while($arow = $aresult->fetch_assoc()) {
	echo "<br>".$arow["Fname"]." ".$arow["Lname"].":";
	$sid=$arow["IDKey"];
	
	$sql="SELECT quotes.Price,quotes.Expiry,quotes.DateIssued,quotes.IDBKey,quotes.IDKey,quotes.IDNKey,numbers.Fname,numbers.Fname,numbers.Pnumber,numbers.Zone FROM numbers INNER JOIN quotes ON quotes.IDNKey=numbers.IDNKey WHERE quotes.SalesmanID='$sid' AND quotes.Approved IS NULL
	AND (quotes.DateIssued LIKE '%$when%' OR quotes.IDKey LIKE '%$what%' OR numbers.IDNKey LIKE '%$what%' OR numbers.Lname LIKE '%$what%' OR numbers.Fname LIKE '%$what%' OR numbers.Zone LIKE '%$what%' OR numbers.Pcode LIKE '%$what%' OR numbers.Address LIKE '%$what%' OR numbers.Pnumber LIKE '%$what%')";
	
	
	$result = mysqli_query($conn, $sql);
	echo "<form action='/SalesManager/updatequotes.php' method='post'>";
	echo "<table border='6' style='width:100%' class='sortable'>";
	echo "<tr>";
	echo "<td>X</td>";
	echo "<td title='Customers First Name'>First Name</td>";
	echo "<td title='Customers Last Name'>Last Name</td>";
	echo "<td title='Customers Address'>Address</td>";
	echo "<td title='Customers Phone Number'>Phone#</td>";
	echo "<td title='Customers Region'>Zone</td>";
	echo "<td title='Age of current Furnace'>Furnace Age</td>";
	echo "<td title='Age of current A/C'>A/C Age</td>";
	echo "<td title='Quoted Price for the job'>Price</td>";
	echo "<td title='When the Quote Expires'>Expiry</td>";
	echo "<td title='Date the Quote was given'>Date Issued</td>";

	echo "</tr>";
	while($row = $result->fetch_assoc()) {
		$nID=$row["IDNKey"];
		$bID=$row["IDBKey"];
		$csql="SELECT IDNKey FROM bookings WHERE IDKey='$bID';";
		$res3 = mysqli_query($conn, $csql);
		$row3=$res3->fetch_assoc();
		if($nID===NULL){
			$nID=$row3["IDNKey"];
		}
		$sql="SELECT Fname,Lname,Address,Pnumber,Zone,FAge,ACAge FROM numbers WHERE IDNKey='$nID';";
		$res2 = mysqli_query($conn, $sql);
		$row2=$res2->fetch_assoc();
		echo "<tr>";
		$idQkey=$row["IDKey"];
		echo "<td><input type='radio' name='rad' value='$idQkey'></td>";
		//echorow($idQkey);
		$address=$row2["Address"];
		$addlink="<a href='https://maps.google.com?saddr=Current+Location&daddr=$address'>$address</a>";
		echorow($row2["Fname"]);
		echorow($row2["Lname"]);
		echorow($addlink);
		echorow($row2["Pnumber"]);
		echorow($row2["Zone"]);
		echorow($row2["FAge"]);
		echorow($row2["ACAge"]);
		echorow($row["Price"]);
		echorow($row["Expiry"]);
		echorow($row["DateIssued"]);
		echo "</tr>";
	}
	echo "</table>";
	echo "<input type='submit' value='submit'>";
	echo "</form>";
}
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