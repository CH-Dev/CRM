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
$stock=$_POST["stock"];
$desc=$_POST["desc"];
$mod=$_POST["mod"];
$cat=$_POST["cat"];
$boone=$_POST["boone"];
$sql="INSERT items (Description,ModelNum,CatID,BooneKey) VALUES ('$desc','$mod','$cat','$boone');";
$result = mysqli_query($conn, $sql);

?>
Item Description Created Successfully!<br>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>
