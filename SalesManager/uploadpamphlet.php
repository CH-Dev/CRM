<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<form action="/SalesManager/uploadpamphlet2.php" method="post" enctype="multipart/form-data">
    Select File to upload:
    <input type="file" name="fileToUpload" id="fileToUpload"><br>
    <input type="submit" value="Upload File" name="submit">
</form>
<br><br>
<form action="/SalesManager/viewpamphlet.php" method="post">
    View current Pamphlets:<input type="submit" value="View" name="submit">
</form>
<?php
session_start(); 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>