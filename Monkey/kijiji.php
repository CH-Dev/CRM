<html>
<head>
<link rel="stylesheet" type="text/css" href="Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql="SELECT MIN(IDKey),URL,ADTitle,Description,Description2,Description3,Description4,Description5,Description6,Description7,Description8,Description9,Description10,Description11,Description12,Description13,Description14,Description15,Description16,Description17,Description18,Description19,Description20,PhoneNumber,Email,section FROM ads WHERE Posted='0'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) ==1) {
	$row = $result->fetch_assoc();
	$_SESSION["kkey"]=$row["MIN(IDKey)"];
	$url=$row["URL"];
	$adt=$row["ADTitle"];
	$desc=$row["Description"];
	$desc2=$row["Description2"];
	$desc3=$row["Description3"];
	$desc4=$row["Description4"];
	$desc5=$row["Description5"];
	$desc6=$row["Description6"];
	$desc7=$row["Description7"];
	$desc8=$row["Description8"];
	$desc9=$row["Description9"];
	$desc10=$row["Description10"];
	$desc11=$row["Description11"];
	$desc12=$row["Description12"];
	$desc13=$row["Description13"];
	$desc14=$row["Description14"];
	$desc15=$row["Description15"];
	$desc16=$row["Description16"];
	$desc17=$row["Description17"];
	$desc18=$row["Description18"];
	$desc19=$row["Description19"];
	$desc20=$row["Description20"];
	$pnum=$row["PhoneNumber"];
	$email=$row["Email"];
	$id=$row["MIN(IDKey)"];
	$sect=$row["section"];
	
	echo "<a href='$url' target='_blank'>link</a><br>";
	echo "<a href='$sect' target='_blank'>link</a><br>";
	echo "<input type='text' value='$adt'><br><br>";
	echo "<input type='text' value='$desc'><br>";
	echo "<input type='text' value='$desc2'><br>";
	echo "<input type='text' value='$desc3'><br>";
	echo "<input type='text' value='$desc4'><br>";
	echo "<input type='text' value='$desc5'><br>";
	echo "<input type='text' value='$desc6'><br>";
	echo "<input type='text' value='$desc7'><br>";
	echo "<input type='text' value='$desc8'><br>";
	echo "<input type='text' value='$desc9'><br>";
	echo "<input type='text' value='$desc10'><br>";
	echo "<input type='text' value='$desc11'><br>";
	echo "<input type='text' value='$desc12'><br>";
	echo "<input type='text' value='$desc13'><br>";
	echo "<input type='text' value='$desc14'><br>";
	echo "<input type='text' value='$desc15'><br>";
	echo "<input type='text' value='$desc16'><br>";
	echo "<input type='text' value='$desc17'><br>";
	echo "<input type='text' value='$desc18'><br>";
	echo "<input type='text' value='$desc19'><br>";
	echo "<input type='text' value='$desc20'><br>";
	echo "$pnum<br><br>";
	echo "$email<br><br>";
	$bsql="UPDATE ads SET Posted='1' WHERE IDKey='$id'";
	$result = mysqli_query($conn, $bsql);
	echo "
				<form action='/Monkey/kijiji.php' method='post'>
				<input type='submit'' value='next'>
				</form>
				";
	$csql="SELECT count(IDKey) FROM ads WHERE Posted='0'";
	$cresult = mysqli_query($conn, $csql);
	$row = $cresult->fetch_assoc();
	if($row["count(IDKey)"]==0) {
		$bsql="UPDATE ads SET Posted='0'";
		$result = mysqli_query($conn, $bsql);
	}
}
?>

</body>
</html>