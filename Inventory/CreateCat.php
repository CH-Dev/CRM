<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
Choose a Category Symbol and Description:<br>
<form action="CreateCat2.php" method="post">
Symbol:<input type="text" name="Symbol"><br>
Description:<input type="text" name="Description"><br>
<input type="submit" value="Create"> 
</form>
<?php 
session_start();
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>