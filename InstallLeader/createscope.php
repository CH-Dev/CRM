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
$idq=$_SESSION["IDQKey"];
$idnum=$_SESSION["idnum"];
$text=$_POST["text"];
$sql="INSERT INTO scopes (Text,AgentID,IDQKey) Values('$text','$idnum','$idq')";
$result = mysqli_query($conn, $sql);
?>
<form action="/InstallLeader/createscope.php" method="post">
Create Another Scope? <input type="text" name="text"><br>
<input type="submit" value="Create">
</form>
<form action="/InstallLeader/jobs.php" method="post">
Back: <input type="text" name="text"><br>
<input type="submit" value="Quote List">
</form>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>