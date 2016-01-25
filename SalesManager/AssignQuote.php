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
$idnum=$_SESSION["idnum"];
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);

$idq=$_SESSION["IDQKey"];
$who=$_POST["who"];
$sql="UPDATE quotes SET OriginalSalesmanID=salesmanID,SalesmanID='$who' WHERE IDKey='$idq' AND OriginalSalesmanID IS NULL";
$result = mysqli_query($conn, $sql);
$bsql="INSERT INTO reminders (Text,AgentID,Date) VALUES ('$idnum has transferred quote #$idq!','44','$date')";
$bresult = mysqli_query($conn, $bsql);
?>
Quote Successfully reassigned,Original salesperson stored in records.<br>
<form action="/SalesManager/updatequotes.php"></form>
Return to Quote:<input type="submit" value="Back">
<?php 
$idq=$_POST["backnum"];
echo "<input type='number' name='rad' value='$idq' hidden>";
?>
</form>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>