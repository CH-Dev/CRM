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
$sql="SELECT * FROM jobs WHERE AssignedUser IS NULL OR AssignedUser='0'";
$result = mysqli_query($conn, $sql);

echo "<form action='/Inventory/jobs.php' method='post'>";
echo "<table border='6' style='width:100%' class='sortable'>";
echo "<tr>";
echo "<td>X</td>";
echo "<td title='Customers First Name'>First Name</td>";
echo "<td title='Customers Last Name'>Last Name</td>";
echo "<td title='Customers Address'>Address</td>";
echo "<td title='Customers Phone Number'>Phone#</td>";
echo "<td title='Customers Region'>Zone</td>";
echo "<td title='Age of old A/C'>AC</td>";
echo "<td title='Age of old Furnace'>F</td>";
echo "<td title='Quoted Price for the job'>Price</td>";
echo "<td title='Date the Quote was given'>Date Issued</td>";
echo "</tr>";
RowTicker("start");
while($row = $result->fetch_assoc()){//print jobs/quotes/bookigns and numbers
	RowTicker("next");
	$jid=$row["IDKey"];
	$qid=$row["IDQKey"];
	$qsql="SELECT * FROM quotes WHERE IDKey='$qid';";
	$qresult = mysqli_query($conn, $qsql);
	$qrow = $qresult->fetch_assoc();
	$nid=$qrow["IDNKey"];
	$nsql="SELECT * FROM numbers WHERE IDNKey='$nid';";
	$nresult = mysqli_query($conn, $nsql);
	$nrow = $nresult->fetch_assoc();
	echo "<td><input type='radio' name='rad' value='$jid'></td>";
	$address=$nrow["Address"];
	$addlink="<a href='https://maps.google.com?saddr=Current+Location&daddr=$address'>$address</a>";
	
	echorow($nrow["Fname"]);
	echorow($nrow["Lname"]);
	echorow($addlink);
	
	echorow($nrow["Pnumber"]);
	echorow($nrow["Zone"]);
	echorow($nrow["ACAge"]);
	echorow($nrow["FAge"]);
	echorow($qrow["Price"]);
	echorow($qrow["DateIssued"]);
	
	echo "</tr>";
}
echo "</table>";
echo "<input type='submit' value='submit'>";
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
