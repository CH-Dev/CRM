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
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$nsql="SELECT * FROM numbers WHERE Comments2='quotes'";
$result = mysqli_query($conn, $nsql);
while($row = $result->fetch_assoc()){
	$idn=$row["IDNKey"];
	$csql="UPDATE numbers SET Comments2='autoquoted' WHERE IDNKey='$idn'";
	if (mysqli_query($conn, $csql)) {
		echo "Quote registered, <br>";
	} else {
		echo "Error: " . $csql . "<br>" . mysqli_error($conn);
	}
	$sql="INSERT INTO bookings (IDNKey,SalesmanID,AppointmentID) VALUES('$idn','30','0')";
	/*$sql="INSERT INTO quotes (IDNKey,Approved,SalesmanID,Preinspect) VALUES ('$idn','1','92979','99')";
	
	if (mysqli_query($conn, $sql)) {
		echo "Quote registered, <br>";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}*/
}
?>
<form action="/Admin/Addnumber.php" method="post">
Add another Number<input type='submit' value='Next'>
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>