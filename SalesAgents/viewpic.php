<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php 
session_start();
$at=$_SESSION["AccountType"];

$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
$idq=$_SESSION["IDQKey"];

$sql="SELECT Link FROM images WHERE IDQKey='$idq'";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$link=$row["Link"];
	echo "<img src='$link' alt='Image' width='500' height='500'><br>";
}
$at=$_SESSION["AccountType"];
$backnum=$_POST["backnum"];
if($at==1){
		echo "<form action='/SalesAgents/savebookings.php' method='post'>
		<input type='text' name='mode' value='0' hidden>";
}elseif($at==11){
		echo "<form action='/SalesManager/updatequotes.php' method='post'>";
}
echo"Return to Quote:<input type='submit' value='Back'>";
$idq=$_POST["backnum"];
echo "<input type='number' name='rad' value='$idq' hidden>";
?>
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>