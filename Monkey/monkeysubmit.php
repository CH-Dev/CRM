<html>
<head>
<link rel="stylesheet" type="text/css" href="Main Style.css">
<title>CoolHeat comfort CRM Index</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
$num=$_POST["num"];
$idn=$_SESSION["idn"];
$sql="UPDATE numbers SET Pnumber='$num', Comments2='',Response='o' WHERE IDNKey='$idn';";
$result = mysqli_query($conn, $sql);
?>
<form action="/Monkey/monkeymine.php" method="post">
<input type="submit" value="Submit">
</body>
</html>