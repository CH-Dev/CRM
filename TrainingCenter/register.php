<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$_SESSION["servername"]="localhost";
$_SESSION["Dusername"] = 'web';
$_SESSION["Dpassword"] = "";
$_SESSION["dbname"] = "pnumbers";
$_SESSION["username"]=$_POST["user"];
$_SESSION["password"]=$_POST["pass"];
$_SESSION["idnum"]=0;
$_SESSION["username"]=$_POST["user"];
$_SESSION["password"]=$_POST["pass"];
// Create connection
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$username=$_SESSION["username"];
$password=$_SESSION["password"];
//echo "<br>".$username.$password."connected";

$sql = "SELECT IDKey,AccountType,Fname,Lname FROM agents WHERE UserName = '$username' AND Password = '$password';";
//echo "<br>".$sql."<br>";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) ==1) {
	echo "Logged in successfully as:$username<br>";
	while($row = $result->fetch_assoc()){
		$accountype=$row["AccountType"];
		$_SESSION["AccountType"]=$accountype;
		$_SESSION["idnum"]= $row["IDKey"];
		//echo "id: ". $row["IDKey"]. "<br>";
		$fname=$row["Fname"];
		$_SESSION[fn]=$fname;
		Echo "Welcome $fname. <br> our first training will be Personal Development.<br> Please click <b>Continue</b> to move on.";
		echo "<form action='/TrainingCenter/pd1001.php' method='post'>
				<input type='submit' value='Continue'>
				</form>";
	}
}
else {
	echo "Incorrect Login/Server error";
	echo "You have made an incorrect move please return to the index and try again.";
}




?>


</body>
</html>