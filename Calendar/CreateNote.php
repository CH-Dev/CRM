<html>
<head>
<title>CoolHeat comfort CRM</title>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
include '..\Validate.php';
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$AT=$_SESSION["AccountType"];
$text=validateinput($_POST["text"]);
$IDN=$_SESSION["IDNKey"];
$agent=$_SESSION["idnum"];
$date = date('Y/m/d H:i:s');
$date=str_replace('/', '-', $date);
$sql="INSERT INTO notes (IDNKey,Date,Text,AgentID) VALUES('$IDN','$date','$text','$agent')";

if ($conn->query($sql) === TRUE) {
	//echo "New record created successfully";
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}
if($AT==0||$AT==7){
	echo"<form action='/Calendar/CreateNote.php' method='post'>
		Add Another Note:
		<input type='text' value='' name='text'><br>
		<input type='submit' value='Create Note'>
		</form><br>
		<form action='/CallCenterAgents/getnextnumber.php' method='post'>
		Next Number:<input type='submit' value='Next Number'>
		</form><br>
		<form action='/CallCenterAgents/Callbacks.php' method='post'>
		Manage Callbacks:<input type='submit' value='Callbacks'>
		</form>";	
}else if($AT==1){
	echo "<form action= '/SalesAgents/savebookings.php' method='post'>
				<input type='number' value='0' name='Mode' hidden>
				<input type='submit' value='Back' class='calbutton'>
				";
	echo "<meta http-equiv='refresh' content='1;url=../SalesAgents/savebookings.php'>";
}
/*	$what=$_SESSION["what"];
	$when=$_SESSION["when"];
	
	echo "<div id='comsect'>
	<form action='/SalesAgents/bookingshow.php' method='post'>
	<input type='text' value='$what' name='what' hidden>
	<input type='date' value='$when' name='when' hidden>
	Back to bookings:<input type='submit' value='Bookings'>
	</form>	<br>
	<form action='/SalesAgents/viewquotes.php' method='post'>
	<input type='submit' value='Return to Search'>
	<input type='text' value='$what' name='what' hidden>
	<input type='text' value='$when' name='when' hidden>
	</form>";
}*/
//echo "$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']";
//$host=$_SERVER["HTTP_HOST"];


?>

<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>