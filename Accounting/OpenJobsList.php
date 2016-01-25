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
$sql="SELECT jobs.IDQKey,quotes.Price,CONCAT(numbers.Fname,' ',numbers.Lname) AS cusn,jobs.StartDate,numbers.Address,numbers.Pnumber,numbers.IDNKey,jobs.IDKey
FROM jobs INNER JOIN quotes ON jobs.IDQKey=quotes.IDKey INNER JOIN numbers ON quotes.IDNKey=numbers.IDNKey
WHERE jobs.Complete IS NULL AND jobs.DateofCompletion IS NULL";
$result = mysqli_query($conn, $sql);
echo "<table><tr>";
echo "<td title='Customer Name'>Name</td>";
echo "<td title='Customer Address'>Address</td>";
echo "<td title='Phone Number'>Phone</td>";
echo "<td title='Quoted Price'>Price</td>";
echo "<td title='Job Starting Date'>Start Date</td>";
echo "<td title='Edit the Part List'>Part List</td>";
echo "<td title='Edit Job info'>Edit Info</td>";
echo "<td title='Mark as Complete'>Complete?</td>";
echo "</tr>";
while($row = $result->fetch_assoc()) {
	echo "<tr>";
	$price=$row["Price"];
	$name=$row["cusn"];
	$sdate=$row["StartDate"];
	$add=$row["Address"];
	$pnum=$row["Pnumber"];
	$idn=$row["IDNKey"];
	$idj=$row["IDKey"];
	$qid=$row["IDQKey"];
	echo "<td>$name</td>";
	echo "<td>$add</td>";
	echo "<td>$pnum</td>";
	echo "<td>$$price</td>";
	echo "<td>$sdate</td>";
	echo "<td><form action='../Inventory/partslist.php' method='post'><input type='submit' value='Parts'><input type='text' name='IDQ' value='$qid'hidden></form></td>";
	echo "<td><form action='viewdetails.php' method='post'><input type='text' value='1' name='mode' hidden><input type='submit' value='Edit'><input type='text' name='rad' value='$idn'hidden></form></td>";
	echo "<td><form action='Complete.php' method='post'><input type='submit' value='Complete'><input type='text' name='idj' value='$idj'hidden></form></td>";
	echo "</tr>";
}
echo "</table>"
?>

<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>