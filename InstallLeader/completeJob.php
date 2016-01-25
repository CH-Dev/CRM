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
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$day=$_POST["day"];
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$jib=$_SESSION["jib"];
$bsql="SELECT IDKey FROM weeks WHERE Start<='$day' AND End>='$day';";
$result = mysqli_query($conn, $bsql);
$row = $result->fetch_assoc();
$wid=$row["IDKey"];
$sql="INSERT INTO shifts (Date,DateBooked,AgentID,Type,slots,WID,Zone)
VALUES ('$date','$date','$idnum','js','0','$wid','Install')";
if (mysqli_query($conn, $sql)) {
	echo "New record created successfully";
} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
$sqlcomp="SELECT IDKey FROM shifts WHERE Type='js' AND Date='$day'";
$compresult = mysqli_query($conn, $sqlcomp);
$comprow = $compresult->fetch_assoc();
$cd=$comprow["IDKey"];
$sql="UPDATE jobs SET Complete='true',DateofCompletion='$cd' WHERE IDKey='$jib'";
if (mysqli_query($conn, $bsql)) {
	echo "Flag set successfully<br>";
} else {
	echo "Error: " . $bsql . "<br>" . mysqli_error($conn);
}
$sqlp="INSERT INTO payments(AgentID,WID,Type,Amount,Method,IDNKey) VALUES('','$wid','','','','','',)";
?>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>