<html>
<head>
<link rel="stylesheet" type="text/css" href="/Big Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
Create Reminder<br><br>
<form action="/SalesManager/createreminder2.php" method="post">
<input type="text" name="text" class='updatetext'><br><br>
<input type="date" name="date" class='updatetext'><br><br>
<?php 
$IDNKey=$_POST["idn"];
if($IDNKey!=0){
	echo "<input type='number' value='$IDNKey' name='idn' hidden>";
}else{
	echo "<input type='number' value='0' name='idn'>";
}
?>

<select name="who" class='Sales-select'>


<?php
session_start();
$idnum=$_SESSION["idnum"];
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
echo "<option value='$idnum'>Me</option>";
$sql="SELECT Fname,Lname,IDKey from agents WHERE SupervisorID='$idnum'";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()){
	$id=$row["IDKey"];
	$fn=$row["Fname"];
	$ln=$row["Lname"];
	echo "<option value='$id'>$fn $ln</option>";
}
?>

</select><br>
<input type='submit' value='Create' class='calbutton'>
</form>

<?php 
$who=$_POST["who"];
$text=$_POST["text"];
$date=$_POST["date"];
$sql="INSERT INTO reminders (AgentID,Text,Date,IDNKey) VALUES ('$who','$text','$date','$IDNKey')";
mysqli_query($conn, $sql);
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu' class='calbutton'></form><br>";
echo "<meta http-equiv='refresh' content='1;url=../SalesAgents/savebookings.php'>";
?>
</body>
</html>