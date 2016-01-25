<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
Welcome to the AutoMail system, this form allows you to create new AutoMail templates,<br>
These templates can then be selected and sent to a recipent quickly and easily!<br>
When creating AutoMail, each text entry box is a Paragraph, to leave a blank line,<br>
Simply skip a box, not all boxes must be used.<br>
After completing this step you will be able to attach files to be included with the AutoMail.<br>
The Name field is used to identify templates, and does not have to be unique, but its reccomended.<br>
<form action="/AutoMail/ceate2.php" method="post">
Name:<input type="text" name="name" value=" ">
<input type="text" name="t1" value=" ">
<input type="text" name="t2" value=" ">
<input type="text" name="t3" value=" ">
<input type="text" name="t4" value=" ">
<input type="text" name="t5" value=" ">
<input type="text" name="t6" value=" ">
<input type="text" name="t7" value=" ">
<input type="text" name="t8" value=" ">
<input type="text" name="t9" value=" ">
<input type="text" name="t10" value=" ">
<input type="text" name="t11" value=" ">
<input type="text" name="t12" value=" ">
<input type="text" name="t13" value=" ">
<input type="text" name="t14" value=" ">
<input type="text" name="t15" value=" ">
<input type="text" name="t16" value=" ">
<input type="text" name="t17" value=" ">
<input type="text" name="t18" value=" ">
<input type="text" name="t19" value=" ">
<input type="text" name="t20" value=" ">
<input type="submit" vaue="Done">
</form>

<?php
session_start();
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>