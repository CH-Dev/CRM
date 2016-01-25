<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
Welcome to the new user registration form, this form is designed to create CallCenter Agent Accounts<br>
For other account types please contact technical support or the manager of that department.<br>
Please make sure the new user's ID has been scanned into the computer's files and is available,<br>
as it is a required part of the new user registration process.<br>
Please enter the following Infortmation:
<form action="/CCManager/register.php" method="post">
<input type="text" name="fn" >-First Name<br>
<input type="text" name="ln" >-Last Name<br>
<input type="text" name="add" >-Address<br>
<input type="text" name="zone" >-City<br>
<input type="text" name="code" >-Postal Code<br>
<input type="tel" name="pnum" >-Phone Number<br>
<input type="date" name="doh" >-Date of Hire<br>
<input type="number" name="sin" >-SIN number<br>
<input type="number" name="idpref" >-Favorite Number<br>
<input type="number" name="points" >-Starting Points<br>
<input type="text" name="user" >-Username<br>
<input type="text" name="pass" >-Password<br>
Thank you for completing the basic information form please verify the information is correct,<br>
then enter your PIN below and click continue.<br>
<input type="password" name="pin"><br>
<input type="submit" value="Finish">
</form>
<?php 
session_start();
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Cancel'></form><br>";
?>
</body>
</html>