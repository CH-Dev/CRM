<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
</head>
<body>
<?php
session_start();
$_SESSION["servername"]="localhost";
$_SESSION["Dusername"] = "web";
$_SESSION["Dpassword"] = "";
$_SESSION["dbname"] = "pnumbers";
$_SESSION["idnum"]=0;
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql="DROP DATABASE pnumbers";
$result = mysqli_query($conn, $sql);
?>
</body>
</html>