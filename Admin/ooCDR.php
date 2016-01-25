<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
Phone mode:<br>
<form action="/Admin/ooCheck.php" method="post">
(<input type="text" name="start" style='width: 3em' value="613">)
<input type="text" name="mid" style='width: 3em'>-
<input type="text" name="end" style='width: 4em'>
<input type="text" name="mode" hidden value="0">
<input type="submit" value="Check">
</form>
Address mode:<br>
<form action="/Admin/ooCheck.php" method="post">
<input type="text" name="end" style='width: 10em'>
<input type="text" name="mode" hidden value="2">
<input type="submit" value="Check">
</form>
Mass Modify Mode:<br>
<form action="/Admin/ooCheck.php" method="post">
<input type="text" name="mode" hidden value="1">
Address:<input type="text" name="add" style='width: 20em'><br>
Response:<select name='rad'>
<option value='NA'>No Answer</option>
<option value='booked'>booked</option>
<option value='DNC'>Do Not Call</option>
<option value='NI'>Not Interested</option>
<option value='o'>Uncalled</option>
<option value='B'>Business</option>
<option value='oo'>No Answer</option>
<option value='NS'>No Signal</option>
<option value='CB'>Call Back</option>
<option value='DNQ'>Does Not Qualify</option>
<option value='APP'>Renting</option>
</select><br>
<input type="submit" value="Update">
</form>


<?php
session_start();
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>