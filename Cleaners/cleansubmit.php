<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut ico
n" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$quote=$_POST["quote"];
$cfh=$_POST["cfh"];
$hed=$_POST["hed"];
$cleaning=$_POST["cleaning"];
$burner=$_POST["burner"];
$vent=$_POST["vent"];
$trap=$_POST["trap"];
$fan=$_POST["fan"];
$ign=$_POST["ign"];
$he=$_POST["he"];
gl=$_POST["gl"];
$gasP=$_POST["gasP"];
$co=$_POST["co"];
$tr=$_POST["tr"];
$hilim=$_POST["hilim"];
$aps=$_POST["aps"];
$fsen=$_POST["fsen"];
$call=$_POST["call"];
$fan2=$_POST["fan2"];
$cap=$_POST["cap"];
$ds=$_POST["ds"];
$wire=$_POST["wire"];
$meter=$_POST["meter"];
$lock=$_POST["lock"];
$seep=$_POST["seep"];
$mono=$_POST["mono"];
$dial=$_POST["dial"];
$hsi=$_POST["hsi"];
$ref=$_POST["ref"];
$pres=$_POST["pres"];
$temp1=$_POST["temp1"];
$pres2=$_POST["pres2"];
$temp2=$_POST["temp2"];
$damac=$_POST["damac"];
$hot=$_POST["hot"];
$prv=$_POST["prv"];
$waterpres=$_POST["waterpres"];
$clear=$_POST["clear"];
$dam2=$_POST["dam2"];
$comments=$_POST["comments"];

$sql="INSERT INTO cleaning (quote,cfh,hed,cleaning,burner,vent,trap,fan,ign,he,gl,gasP,co,tr,hilim,aps,fsen,call,fan2,cap,ds,wire,meter,lock,seep,mono,dial,hsi,ref,pres,temp1,pres2,temp2,damac,hot,prv,waterpres,clear,dam2,comments) VALUES
('$quote','$cfh','$hed','$cleaning','$burner','$vent','$trap','$fan','$ign','$he','$gl','$gasP','$co','$tr','$hilim','$aps','$fsen','$call','$fan2','$cap','$ds','$wire','$meter','$lock','$seep','$mono','$dial','$hsi','$ref','$pres','$temp1','$pres2','$temp2','$damac','$hot','$prv','$waterpres','$clear','$dam2','$comments')";
$result = mysqli_query($conn, $sql);
?>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>