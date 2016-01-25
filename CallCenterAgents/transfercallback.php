<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$idnum=$_SESSION["idnum"];
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$id=$_SESSION["idnum"];
$tid=$_POST["newid"];
$idkey=$_POST["idkey"];
if($id===$tid){
	echo "Seriously you tried that?";
}
else{
	$sql="Update numbers SET AssignedUser='$tid',OriginalCaller='$id' WHERE IDNKey='$idkey' AND (OriginalCaller IS NULL OR OriginalCaller='0' OR OriginalCaller='')";
	mysqli_query($conn, $sql);
	echo "<br>Transfer successful!";
}
$bsql="INSERT INTO reminders (Text,AgentID,Date) VALUES ('$idnum has transferred Callback $idkey!','44','$date')";
$bresult = mysqli_query($conn, $bsql);
?>
<form action="/CallCenterAgents/Callbacks.php" method="post">
Return to Callbacks:<input type="submit" value="Callbacks">
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>