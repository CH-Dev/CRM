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
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql="SELECT items.IDKey,items.Description,items.ModelNum,items.BooneKey,categories.Symbol as Csym,units.Symbol AS Usym FROM items INNER JOIN categories ON items.CatID=categories.IDKey INNER JOIN units ON items.UnitID=units.IDKey;";
$result = mysqli_query($conn, $sql);

echo "<form action='updatecallback.php' method='post'>";
echo "<table border='6' style='width:100%' class='sortable'>";
echo "<tr>";
echo "<td>X</td>";
echorow("Description");
echorow("ModelNum");
echorow("Boone ID");
echorow("Category");
echorow("Unit");
echo "</tr>";
RowTicker("start");
while($row = $result->fetch_assoc()) {
	RowTicker("next");
	$id=$row["IDKey"];
	echo "<td><input type='radio' name='rad' value='$id'></td>";
	echorow($row["Description"]);
	echorow($row["ModelNum"]);
	echorow($row["BooneKey"]);
	echorow($row["Csym"]);
	echorow($row["Usym"]);
	echo "</tr>";
}


echo "</table>";
echo "<input type='submit' value='Edit'>";
echo "</form>";
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
?>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>