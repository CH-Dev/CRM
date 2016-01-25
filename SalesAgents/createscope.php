<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$idq=$_SESSION["IDQKey"];
$idnum=$_SESSION["idnum"];
$text=$_POST["text"];
$sql="INSERT INTO scopes (Text,AgentID,IDQKey) Values('$text','$idnum','$idq')";
$result = mysqli_query($conn, $sql);
?>
<form action="/SalesAgents/createscope.php" method="post">
Create Another Scope? <input type="text" name="text"><br>
<input type="submit" value="Create">
</form>
<?php 
$Qzone=$_SESSION["Qzone"];
$Qdate=$_SESSION["Qdate"];
$Qname=$_SESSION["Qname"];
$Qpnum=$_SESSION["Qpnum"];
$QID=$_SESSION["QID"];
$rad=$_SESSION["rad"];
echo "<div id='comsect'>
<form action='/SalesAgents/viewquotes.php' method='post'>
<input type='text' value='$Qzone' name='zone' hidden>
<input type='text' value='$Qdate' name='date' hidden>
<input type='text' value='$Qname' name='lname' hidden>
<input type='text' value='$Qpnum' name='pnum' hidden>
<input type='text' value='$QID' name='ID' hidden>
<input type='text' value='$rad' name='rad' hidden>
Back to Search:<input type='submit' value='quotes'>
</form>
</div>	";
?>
<?php 
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