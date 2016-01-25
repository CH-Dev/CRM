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
$sql="SELECT * FROM payments WHERE Approved IS NULL";
$result= mysqli_query($conn, $sql);
echo "<form action='/Accounting/approve.php' method='post'>";
echo "<table border='6' style='width:100%' class='sortable'>";
echo "<tr>";
echorow("x");
echo "<td title='The ID number of the Agent to be payed'>AgentID</td>";
echo "<td title='The Amount to be payed'>Amount</td>";
echo "<td title='The week the payment is for'>Week</td>";
echo "<td title='The Type of Payment'>Type</td>";
echo "<td title='Any Comments'>Comments</td>";
echo "<td title='The Requested Payment Method'>Method</td>";
echo "</tr>";
while($row = $result->fetch_assoc()) {
	$agent=$row["AgentID"];
	$amount=$row["Amount"];
	$week=$row["WID"];
	$type=$row["Type"];
	$com=$row["Comment"];
	$method=$row["Method"];
	$idkey=$row["IDKey"];
	echo "<tr>";
	echo "<td><input type='radio' name='appid' value='$idkey'></td>";
	echorow($agent);
	echorow($amount);
	echorow($week);
	echorow($type);
	echorow($com);
	echorow($method);
	echo "</tr>";
}
echo "</table>";
echo "<input type='submit' value='submit'>";
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
?>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>