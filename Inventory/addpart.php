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
$idq=$_POST["idq"];
$i1=$_POST["part1"];
$i2=$_POST["part2"];
$i3=$_POST["part3"];
$i4=$_POST["part4"];
$i5=$_POST["part5"];
$i6=$_POST["part6"];
$i7=$_POST["part7"];
$i8=$_POST["part8"];
$i9=$_POST["part9"];
$i10=$_POST["part10"];

if($i1<>'-1'){
	$q1=$_POST["quantity1"];
	updateparts($idq,$i1,$q1,$conn);
}
if($i2<>'-1'){
	$q2=$_POST["quantity2"];
	updateparts($idq,$i2,$q2,$conn);
}
if($i3<>'-1'){
	$q3=$_POST["quantity3"];
	updateparts($idq,$i3,$q3,$conn);
}
if($i4<>'-1'){
	$q4=$_POST["quantity4"];
	updateparts($idq,$i4,$q4,$conn);
}
if($i5<>'-1'){
	$q5=$_POST["quantity5"];
	updateparts($idq,$i5,$q5,$conn);
}
if($i6<>'-1'){
	$q6=$_POST["quantity6"];
	updateparts($idq,$i6,$q6,$conn);
}
if($i7<>'-1'){
	$q7=$_POST["quantity7"];
	updateparts($idq,$i7,$q7,$conn);
}
if($i8<>'-1'){
	$q8=$_POST["quantity8"];
	updateparts($idq,$i8,$q8,$conn);
}
if($i9<>'-1'){
	$q9=$_POST["quantity9"];
	updateparts($idq,$i9,$q9,$conn);
}
if($i10<>'-1'){
	$q10=$_POST["quantity10"];
	updateparts($idq,$i10,$q10,$conn);
}
function updateparts($idqkey,$partID,$quantitynum,$conn){
	$sql1="SELECT Quantity FROM parts WHERE IDQKey='$idqkey' AND ItemID='$partID'";
	$result = mysqli_query($conn, $sql1);
	if (mysqli_num_rows($result) >0) {
		$row = $result->fetch_assoc();
		$quantity=$row["Quantity"]+$quantitynum;
		$bsql="UPDATE parts SET Quantity='$quantity' WHERE IDKey='$partID'";
		$result = mysqli_query($conn, $bsql);
	}
	elseif(mysqli_num_rows($result)==0){
		$bsql="INSERT INTO parts (IDQKey,Quantity,ItemID) VALUES ('$idqkey','$quantitynum','$partID')";
		$result = mysqli_query($conn, $bsql);
	}
}
?>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>