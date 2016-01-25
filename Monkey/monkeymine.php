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

//Find next address to update
$sql= "SELECT Address,Zone,IDNKey FROM numbers WHERE Comments2='MonkeyMine' AND Pnumber='0';";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$idn=$row["IDNKey"];
$_SESSION["idn"]=$idn;
$address=$row["Address"];
$zone=$row["Zone"];

//Claim that Address so no other monkey touches it
$bsql="UPDATE numbers SET Pnumber='1' WHERE IDNKey='$idn';";
$bresult = mysqli_query($conn, $bsql);

//Give the monkey the URL
echo "<a href='http://www.canada411.ca/search/?stype=ad&st=$address&ci=$zone&pv=ON&pc=' target='_blank'>link</a>";
?>

<form action="/Monkey/monkeysubmit.php" method="post">
<input type="text" name="num"><br>
<input type="submit" value="Submit">

</body>
</html>