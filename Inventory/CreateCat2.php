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
$desc=$_POST["Description"];
$sym=$_POST["Symbol"];
$sql="INSERT INTO categories (Description,Symbol) VALUES ('$desc','$sym')";
mysqli_query($conn, $sql);
echo "$sql";
?>

Entry Created Successfully!<br>

Create Another?<form action="CreateCat2.php" method="post">
Symbol:<input type="text" name="Symbol"><br>
Description:<input type="text" name="Description"><br>
<input type="submit" value="Create"> 
</form>
<?php 

$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>