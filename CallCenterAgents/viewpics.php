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
$idkey=$_POST["rad"];
$sql="SELECT IDKey,Approved,Preinspect FROM quotes WHERE IDBKey='$idkey';";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$idqkey=$row["IDKey"];
$app=$row["Approved"];
$pre=$row["Preinspect"];
if($pre=='1'){
	echo "This booking is awaiting Preinspection currently.";
}
if($app=='1'){
	echo "This quote has been approved.";
}
echo "<br>";
$sql="Select Link from images WHERE SecurityLVL='0' AND IDQKey='$idqkey'";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$link=$row["Link"];
	echo "<img src='/SalesAgents/$link' alt='Image' width='1000' height='1000'><br>";
}

?>

<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>

</body>
</html>