<html>
<head>
<link rel="stylesheet" type="text/css" href="Main Style.css">
<title>CoolHeat comfort CRM Index</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$pass=$_POST["pass"];
$user=$_POST["user"];
$idkey=$_SESSION["idnum"];
$sql="UPDATE agents SET Username='$user',Password='$pass' WHERE IDKey='$idkey';";
if (mysqli_query($conn, $sql)){
	echo "Account updated successfully.";
}
else{
	echo "something was wrong!";
}
$bsql="INSERT INTO reminders (Text,AgentID,Date) VALUES ('$idkey changed their username and password!','44','$date')";
$bresult = mysqli_query($conn, $bsql);
?>
<form action="index.php" method="post">
<input type="submit" value="To index">
</form>
</body>
</html>