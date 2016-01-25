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
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$idnum=$_SESSION["idnum"];
$fn=$_POST["fn"];
$ln=$_POST["ln"];
$pnum=$_POST["pnum"];
$add=$_POST["add"];
$z=$_POST["z"];
$code=$_POST["code"];
$email=$_POST["email"];
$cnum=$_POST["cnum"];
$source=$_POST["source"];
$sql="INSERT INTO numbers (Fname,Lname,Pnumber,Address,Zone,Pcode,Email,CellNumber,DateofContact,Comments2,source)
		VALUES ('$fn','$ln','$pnum','$add','$z','$code','$email','$cnum','$date','quotes','$source')";
if (mysqli_query($conn, $sql)) {
	echo "New record created successfully<br>";
} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
$bsql="SELECT max(IDNKey) FROM numbers;";
$bresult = mysqli_query($conn, $bsql);
$brow= $bresult->fetch_assoc();
$newIDN=$brow["max(IDNKey)"];
$shiftID=$_POST["shift"];
$shiftIDP=$_POST["shiftP"];
if($shiftIDP!=0){
	$shiftID=$shiftIDP;
}
$booksql="INSERT INTO bookings (IDNKey,SalesmanID,AppointmentID,LastContactID) VALUES('$newIDN','$idnum','$shiftID','$idnum')";
if (mysqli_query($conn, $booksql)) {
	echo "New booking created successfully and added to your account.<br>";
} else {
	echo "Error: " . $booksql . "<br>" . mysqli_error($conn);
}
?>
<br>
<form action="/Admin/Addnumber.php" method="post">
Add another Number<input type='submit' value='Next'>
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>