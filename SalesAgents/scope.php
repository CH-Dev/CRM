<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<form action="/SalesAgents/createscope.php" method="post">
Scope: <input type="text" name="text"><br>
<input type="submit" value="Create">
</form>
<?php 
session_start();
$at=$_SESSION["AccountType"];
if($at==1){
	echo "<form action='/SalesAgents/updatequotes.php' method='post'>";
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