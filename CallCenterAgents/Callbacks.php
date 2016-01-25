<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM Index</title>
<script src="/sorttable.js"></script>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
Please select a callback to edit:<br>
<?php
session_start();
DisplayTable();
function DisplayTable(){
	$username=$_SESSION["username"];
	$idnum=$_SESSION["idnum"];
	$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql="SELECT * FROM numbers WHERE AssignedUser='$idnum' AND Response='CB' ORDER BY CBDate;";
	$result = mysqli_query($conn, $sql);
	echo "<form action='updatecallback.php' method='post'>";
	echo "<input type='submit' value='Edit'>";
	echo "<table border='6' style='width:100%' class='sortable'>";
	if (mysqli_num_rows($result) >0) {
		echo "<tr>";
		echo "<td>X</td>";
		echorow("First Name");
		echorow("Last Name");
		echorow("Phone#");
		echorow("Address");
		echorow("Zone");
		echorow("CB Date");
		echorow("CB time");
		echorow("Transfered");
		echorow("Notes1");
		echorow("Notes2");
		echo "</tr>";
		RowTicker("start");
		while($row = $result->fetch_assoc()) {
			RowTicker("next");
			$idkey=$row["IDNKey"];
			echo "<td><input type='radio' name='rad' value='$idkey'></td>";

			$nsql="SELECT * FROM notes WHERE IDNKey='$idkey' AND AgentID='$idnum'";
			$nresult = mysqli_query($conn, $nsql);
			$nrow = $nresult->fetch_assoc();
			$text=$nrow["Text"];
			$nrow = $nresult->fetch_assoc();
			$text2=$nrow["Text"];
			echorow($row["Fname"]);
			echorow($row["Lname"]);
			echorow($row["Pnumber"]);
			echorow($row["Address"]);
			echorow($row["Zone"]);
			echorow($row["CBDate"]);
			echorow($row["CBTime"]);
			echorow($row["OriginalCaller"]);
			echorow($text);
			echorow($text2);
			echo "</tr>";
		}
	$_SESSION["IDNKey"]=$row["MIN(IDNKey)"];
	}
	echo "</table>";
	echo "<input type='submit' value='Edit'>";
	echo "</form>";
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
?>
<br><br>
<form action="/CallCenterAgents/getnextnumber.php" method="post">
Normal Calling:<input type="submit" value="Next Number">
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>