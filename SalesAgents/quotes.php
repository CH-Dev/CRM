<html>
<head>
<link rel="stylesheet" type="text/css" href="/Big Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
Quote Search<br><br>
<form action="viewquotes.php" method="post"><table class='flags'>

<tr><td  class='flagbox'>Date:</td><td  class='flagbox'><input type="date" name="when" class='updatetext' class='updatetext'></td></tr>
<tr><td  class='flagbox'>Search:</td><td  class='flagbox'><input type="text" name="what" class='updatetext' class='updatetext'></td></tr>
<tr><td  class='flagbox'></td><td  class='flagbox'><input type="submit" value="View" class='calbutton'></td></tr></table>
</form>
<?php 
session_start();
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden> <input type='text' name='pass' value='$pass' hidden>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu' class='calbutton'></form><br>";
?>
</body>
</html>