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
$sql="SELECT quotes.IDKey as Qid,quotes.Price,CONCAT(numbers.Fname,' ',numbers.Lname) AS cusn,
		numbers.Address,numbers.Pnumber,numbers.IDNKey,jobs.IDKey as Jid,jobs.DateofCompletion
FROM jobs INNER JOIN quotes ON jobs.IDQKey=quotes.IDKey INNER JOIN numbers ON quotes.IDNKey=numbers.IDNKey
WHERE jobs.Complete='1' AND jobs.CFlag IS NULL";
$result = mysqli_query($conn, $sql);
echo "<table><tr>";
echo "<td title='Customer Name'>Name</td>";
echo "<td title='Customer Address'>Address</td>";
echo "<td title='Phone Number'>Phone</td>";
echo "<td title='Quoted Price'>Price</td>";
echo "<td title='Job Completion Date'>End Date</td>";
echo "<td title='Edit the Part List'>Part List</td>";
echo "<td title='Close Job, preventing modifications'>Close Job</td>";
echo "</tr>";
while($row = $result->fetch_assoc()) {
	$name=$row["cusn"];
	$price=$row["Price"];
	$add=$row["Address"];
	$pnum=$row["Pnumber"];
	$idn=$row["IDNKey"];
	$qid=$row["Qid"];
	$jid=$row["Jid"];
	$comp=$row["DateofCompletion"];
	echo "<tr>";
	echo "<td>$name</td>";
	echo "<td>$add</td>";
	echo "<td>$pnum</td>";
	echo "<td>$$price</td>";
	echo "<td>$comp</td>";
	echo "<td><form action='../Inventory/partslist.php' method='post'><input type='submit' value='Parts'><input type='text' name='IDQ' value='$qid'hidden></form></td>";
	echo "<td><form action='CloseJobs2.php' method='post'><input type='text' value='1' name='mode' hidden><input type='submit' value='Close'><input type='text' name='rad' value='$idn'hidden></form></td>";
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