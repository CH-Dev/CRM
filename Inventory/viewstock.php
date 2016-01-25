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


	echo "<form actions='/Inventory/savestock.php' method='post'>";
	echo "<table class='sortable'>";
	$zsql="SELECT * FROM items";
	$result = mysqli_query($conn, $zsql);
	while($row = $result->fetch_assoc()) {
		RowTicker("next");
		$z=$row["Description"];
		$idkey=$row["IDKey"];
		$stock=$row["Stock"];
		echorow($z);
		echorow($stock);
		echo "</tr>";
	}
	echo "</table>";
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
<input type="number" name='item001' value=''>

<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>