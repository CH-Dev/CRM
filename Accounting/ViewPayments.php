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
if($_POST["mode"]==0){
	$week=$_POST["week"];
	$who=$_POST["who"];
	$sql="SELECT CONCAT(agents.Fname,' ',agents.Lname) AS Agent,payments.Amount,payments.Method,payments.Type,CONCAT (numbers.Fname,numbers.Lname) as cusn, weeks.PayDate
	FROM payments INNER JOIN numbers ON payments.IDNKey=numbers.IDNKey INNER JOIN agents ON payments.AgentID=agents.IDKey INNER JOIN weeks ON weeks.IDKey=payments.WID WHERE payments.WID='$week' AND AgentID='$who'";
}else if($_POST["mode"]==1){
	$week=$_POST["week"];
	$sql="SELECT CONCAT(agents.Fname,' ',agents.Lname) AS Agent,payments.Amount,payments.Method,payments.Type,CONCAT (numbers.Fname,numbers.Lname) as cusn, weeks.PayDate
	FROM payments INNER JOIN numbers ON payments.IDNKey=numbers.IDNKey INNER JOIN agents ON payments.AgentID=agents.IDKey INNER JOIN weeks ON weeks.IDKey=payments.WID  WHERE payments.WID='$week'";
}else if($_POST["mode"]==2){
	$who=$_POST["who"];
	$sql="SELECT CONCAT(agents.Fname,' ',agents.Lname) AS Agent,payments.Amount,payments.Method,payments.Type,CONCAT (numbers.Fname,numbers.Lname) as cusn, weeks.PayDate
	FROM payments INNER JOIN numbers ON payments.IDNKey=numbers.IDNKey INNER JOIN agents ON payments.AgentID=agents.IDKey INNER JOIN weeks ON weeks.IDKey=payments.WID  WHERE AgentID='$who'";
}
echo "<table><tr>
			<td title='Agent that the payment is to be made to'>Agent</td>
			<td title='Amount to be paid'>Amount</td>
			<td title='Date payment is expected to be made'>Pay Date</td>
			<td title='Type of Payment'>Type</td>
			<td title='Customer Account this payment is related to'>Customer</td>
			</tr>";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	echo "<tr>";
	$agent=$row["Agent"];
	$amount=$row["Amount"];
	$type=$row["Type"];
	$cusn=$row["cusn"];
	$paydate=$row["PayDate"];
	echo "<td>$agent</td>";
	echo "<td>$amount</td>";
	echo "<td>$paydate</td>";
	
	echo "<td>$type</td>";
	echo "<td>$cusn</td>";
	echo "</tr>";
}
echo "</table>";
?>

<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>