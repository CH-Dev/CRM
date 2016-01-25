<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
View Jobs:<form action="/InstallLeader/jobs.php">
<input type="submit" value="jobs">
</form><br>
Schedule Shifts:<form action="/Calendar/event.php">
<input type="submit" value="shifts">
</form><br>
Manage Crew:<form action="/InstallLeader/managecrew.php">
<input type="submit" value="manage">
</form><br>
<?php 
session_start();
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>