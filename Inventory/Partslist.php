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
$idq=$_POST["IDQ"];
$asql="SELECT numbers.Fname,numbers.Lname,numbers.IDNKey FROM quotes JOIN numbers ON numbers.IDNKey=quotes.IDNKey WHERE quotes.IDKey='$idq'";
$aresult = mysqli_query($conn, $asql);
$arow = $aresult->fetch_assoc();
$fn=$arow["Fname"];
$ln=$arow["Lname"];
$idn=$arow["IDNKey"];
echo "<b>Editing Job for Customer #$idn| $fn $ln</b><br>";
?>
<form action="/Inventory/addpart.php" method="post">
<?php 

echo "<select name='part1'>";
printoption($conn);
echo "</select><input type='number' name='quantity1' value='1'><br>";

echo "<select name='part2'>";
printoption($conn);
echo "</select><input type='number' name='quantity2' value='1'><br>";
echo "<select name='part3'>";
printoption($conn);
echo "</select><input type='number' name='quantity3' value='1'><br>";
echo "<select name='part4'>";
printoption($conn);
echo "</select><input type='number' name='quantity4' value='1'><br>";
echo "<select name='part5'>";
printoption($conn);
echo "</select><input type='number' name='quantity5' value='1'><br>";
echo "<select name='part6'>";
printoption($conn);
echo "</select><input type='number' name='quantity6' value='1'><br>";
echo "<select name='part7'>";
printoption($conn);
echo "</select><input type='number' name='quantity7' value='1'><br>";
echo "<select name='part8'>";
printoption($conn);
echo "</select><input type='number' name='quantity8' value='1'><br>";
echo "<select name='part9'>";
printoption($conn);
echo "</select><input type='number' name='quantity9' value='1'><br>";
echo "<select name='part10'>";
printoption($conn);
echo "</select><input type='number' name='quantity10' value='1'><br>";
echo "</select><input type='number' name='idq' value='$idq' hidden><br>";
?>
<input type="submit" value="Add">
</form>

<?php 
$sql="SELECT ItemID,sum(Quantity) FROM parts WHERE IDQKey='$idq' GROUP BY ItemID";
$result = mysqli_query($conn, $sql);
echo "<form action='Inventory/modifyitemlist.php' method='post'>";
echo "<table border='6' style='width:100%' class='sortable'>";
echo "<tr>";
echo "<td>X</td>";
echorow("Category");
echorow("Model");
echorow("Description");
echorow("Quantity");
echorow("Price");
echo "</tr>";
RowTicker("start");
while($row = $result->fetch_assoc()) {
	RowTicker("next");
	$iID=$row["ItemID"];
	$bsql="SELECT * FROM items WHERE IDKey='$iID'";
	$bresult = mysqli_query($conn, $bsql);
	$brow = $bresult->fetch_assoc();
	echo "<td><input type='radio' name='rad' value='$iID'></td>";
	echorow($brow["Category"]);
	echorow($brow["ModelNum"]);
	echorow($brow["Description"]);
	echorow($row["sum(Quantity)"]);
	echorow($brow["Price"]);
	echo "</tr>";
}
echo "</table>";
echo "<input type='submit' value='Edit'>";
echo "</form>";
?>
<?php
function printoption($conn){
	echo "<option value='-1'>None</option>";
	$zsql="SELECT * FROM items";
	$result = mysqli_query($conn, $zsql);
	while($row = $result->fetch_assoc()) {
		$z=$row["Description"];
		$idkey=$row["IDKey"];
		echo "<option value='$idkey'>$z</option>";
	}
}
function echorow($p){
	echo "<td>$p</td>";
}
function RowTicker($go){
	if($go=="start"){
		$GLOBALS["trc"]=0;
	}
	else{
		if($GLOBALS["trc"]==1){
			$GLOBALS["trc"];
			echo "<tr>";
			$GLOBALS["trc"]=0;
		}
		else{
			echo "<tr class='stripe'>";
			$GLOBALS["trc"]++;
		}
	}
}
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>
