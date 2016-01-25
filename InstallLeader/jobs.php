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
$idnum=$_SESSION["idnum"];

$sql="SELECT * FROM jobs WHERE AssignedUser='$idnum'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) >0) {
	echo "<form action='/InstallLeader/viewjob.php' method='post'>";
	echo "<table border='6' style='width:100%' class='sortable'>";
	echo "<tr>";
	echo "<td>X</td>";
	echorow("First Name");
	echorow("Last Name");
	echorow("Address");
	echorow("Phone Number");
	echorow("Furnace");
	echorow("A/C");
	echorow("Water Tank");
	echorow("Boiler");
	echorow("Completed");
	echorow("Date of Completion");
	echorow("Estimated Date of Completion");
	RowTicker("start");
	while($row = $result->fetch_assoc()) {
		RowTicker("next");
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
		$id=$row["IDKey"];
		echo "<td><input type='radio' name='rad' value='$id'></td>";
		echorow($nrow["Fname"]);
		echorow($nrow["Lname"]);
		echorow($nrow["Address"]);
		echorow($nrow["Pnumber"]);
		echocheck($brow["Fflag"]);
		echocheck($brow["Aflag"]);
		echocheck($brow["Tflag"]);
		echocheck($brow["Bflag"]);
		echocheck($row["Completed"]);
		echorow($row["DateofCompletion"]);
		echorow($row["EstCompletion"]);
		echo "</tr>";
	}
}
echo "</table>";
echo "<input type='submit' value='View'>";
echo "</form>";

function echorow($p){
	echo "<td>$p</td>";
}
function echocheck($p){
	if($p=='1'){
		echo "<td>&#10004;</td>";
	}else{
		echo "<td> &#10006; </td>";
	}
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
<br>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>