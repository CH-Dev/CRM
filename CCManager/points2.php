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
$action=$_POST["action"];
$who=$_POST["who"];
$num=$_POST["quantity"];
$sql="SELECT Cpoints,Apoints FROM agents WHERE IDKey='$who'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$cp=$row["Cpoints"];
$ap=$row["Apoints"];
if($action=="grant"){
	$cp+=$num;
	$ap+=$num;
}
if($action=="take"){
	$cp-=$num;
}
$bsql="UPDATE agents SET Cpoints='$cp',Apoints='$ap' WHERE IDKey='$who'";
$bresult = mysqli_query($conn, $bsql);
?>
The user's points have been adjusted accordingly,Please do not refresh this page.<br>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Cancel'></form><br>";
?>
</body>
</html>