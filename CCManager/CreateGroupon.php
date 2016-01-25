<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<form action='/CCManager/points2.php' method='post'>
Phone Number:<input type="number" name='pnum' value='613'><br>
First Name:<input type="text" name='fn'><br>
Last Name:<input type="text" name='ln'><br>
Address:<input type="text" name='add'><br>
City:<input type="text" name='zone'><br>
Time:<input type="text" name='time'><br>
Date:<input type="text" name='date'><br>
Comments:<input type="text" name='com1'><br>
<input type='submit' value='submit'>
</form>
<?php
session_start();
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Cancel'></form><br>";
?>
</body>
</html>