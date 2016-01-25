<html>
<head>
<link rel="stylesheet" type="text/css" href="Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php 
session_start();
$_SESSION["servername"]="localhost";
$_SESSION["Dusername"] = "web";
$_SESSION["Dpassword"] = "";
$_SESSION["dbname"] = "pnumbers";
$_SESSION["username"]=$_POST["user"];
$_SESSION["password"]=$_POST["pass"];
$_SESSION["idnum"]=0;
$accountype='44';
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$username=$_SESSION["username"];
$password=$_SESSION["password"];
$sql = "SELECT IDKey FROM agents WHERE UserName = '$username' AND Password = 'Banana' AND AccountType='$password';";
//echo "<br>".$sql."<br>";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) ==1) {
	echo "Logged in successfully as:$username<br>";
	while($row = $result->fetch_assoc()){
		$_SESSION["AccountType"]=$password;
		$_SESSION["idnum"]= $row["IDKey"];
		echo "
				<form action='/Monkey/monkeymine.php' method='post'>
				Monkey<input type='submit'' value='Mine'>
				</form>
				";
		echo "
				<form action='/Monkey/kijiji.php' method='post'>
				Monkey<input type='submit'' value='kijiji'>
				</form>
				";
	}
}
else {
	echo "Incorrect Login/Server error";
}
?>