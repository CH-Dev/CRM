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
$idq=$_SESSION["IDQKey"];

$bsql="UPDATE quotes SET Approved='2' WHERE IDQKey='$idq')";
$bresult = mysqli_query($conn, $bsql);
$sql="INSERT INTO jobs (IDQKey) VALUES ('$idq')";
$result = mysqli_query($conn, $sql);
?>
Quote approved, Job created and sent to Inventory to assign to a Crew Leader.<br>
<form action="/SalesManager/updatequotes.php" method="post"></form>
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