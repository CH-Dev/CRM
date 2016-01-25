<html>
<head>
<link rel="stylesheet" type="text/css" href="/Big Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
Upload Photos<br><br>
<form action="/SalesAgents/uploadpic2.php" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload" class='picbutton'><br>
    <input type="submit" value="Upload Image" name="submit" class='calbutton'>
    <input type="number" value="<?php echo $_POST["backnum"];?>" name="backnum" hidden>
</form>
<?php 
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
$idq=$_POST["backnum"];
$sql="SELECT Link FROM images WHERE IDQKey='$idq'";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$link=$row["Link"];
	echo "<img src='$link' alt='Image' width='150' height='150'><br>";
}

$at=$_SESSION["AccountType"];
if($at==1){
	echo "<form action='/SalesAgents/savebookings.php' method='post'>
		<input type='text' name='mode' value='0' hidden>";
}elseif($at==11){
		echo "<form action='/SalesManager/updatequotes.php' method='post'>";
}
echo"<input type='submit' value='Back' class='calbutton'>";

echo "<input type='number' name='rad' value='$idq' hidden>";
?>
</form>
<?php 

$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu' class='calbutton'></form><br>";
?>
</body>
</html>