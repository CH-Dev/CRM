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
$name=$_POST["name"];
$T1=$_POST["t1"]+" ";
$T2=$_POST["t2"]+" ";
$T3=$_POST["t3"]+" ";
$T4=$_POST["t4"]+" ";
$T5=$_POST["t5"]+" ";
$T6=$_POST["t6"]+" ";
$T7=$_POST["t7"]+" ";
$T8=$_POST["t8"]+" ";
$T9=$_POST["t9"]+" ";
$T10=$_POST["t10"]+" ";
$T11=$_POST["t11"]+" ";
$T12=$_POST["t12"]+" ";
$T13=$_POST["t13"]+" ";
$T14=$_POST["t14"]+" ";
$T15=$_POST["t15"]+" ";
$T16=$_POST["t16"]+" ";
$T17=$_POST["t17"]+" ";
$T18=$_POST["t18"]+" ";
$T19=$_POST["t19"]+" ";
$T20=$_POST["t20"]+" ";
$sql="INSERT INTO mail (Name,T1,T2,T3,T4,T5,T6,T7,T8,T9,T10,T11,T12,T13,T14,T15,T16,T17,T18,T19,T20) VALUES ('$name','$T1','$T2','$T3','$T4','$T5','$T6','$T7','$T8','$T9','$T10','$T11','$T12','$T13','$T14','$T15','$T16','$T17','$T18','$T19','$T20)";
$result = mysqli_query($conn, $sql);
$bsql="SELECT max(IDKey) FROM mail WHERE Name='$name'";
$bresult = mysqli_query($conn, $bsql);
$row=$bresult->fetch_assoc();
$mid=$row["max(IDKey)"];
echo "<form action='/AutoMail/createattachment.php' method='post'>
<input type='text' vaue='$mid' name='mailid' hidden>
<input type='submit' value='Add Attachments'>
</form>";
?>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>