<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM Index</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$_SESSION["servername"]="localhost";
$_SESSION["Dusername"] = 'web';
$_SESSION["Dpassword"] = "";
$_SESSION["dbname"] = "pnumbers";
$idnum=$_SESSION["idnum"];
$fname=$_POST["fn"];
$lname=$_POST["ln"];
$username=$_POST["user"];
$pass=$_POST["pass"];
$add=$_POST["add"];
$zone=$_POST["zone"];
$code=$_POST["code"];
$pnum=$_POST["pnum"];
$doh=$_POST["doh"];
$sin=$_POST["sin"];
$idpref=$_POST["idpref"];
$points=$_POST["points"];
// Create connection
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
$presql="SELECT * FROM agents WHERE IDKey='$idpref'";
$presql2="SELECT Email FROM agents WHERE IDKey='$idnum'";
$result2 = mysqli_query($conn, $presql2);
$row2 = $result2->fetch_assoc();
$supemail=$row2["Email"];
$result = mysqli_query($conn, $presql);
if (mysqli_num_rows($result) ==0) {
	$sql = "INSERT INTO agents (Fname, Lname, Address,Zone,Pnumber,DateofHire,SIN,IDKey,Cpoints,Apoints,UserName,Password,AccountType,SuperVisorID,Email)
	VALUES ('$fname','$lname','$add','$zone','$pnum','$doh','$sin','$idpref','$points','$points','$username','$pass','0','$idnum','$supemail');";
	echo " $idpref is the User's new ID Number.<br>";
}else{
	$sql = "INSERT INTO agents (Fname, Lname, Address,Zone,Pnumber,DateofHire,SIN,Cpoints,Apoints,UserName,Password,AccountType,SuperVisorID,Email)
	VALUES ('$fname','$lname','$add','$zone','$pnum','$doh','$sin','$points','$points','$username','$pass','0','$idnum','$supemail');";
	echo "<br>$sql<br>";
	echo "Unable to aquire requested Agent ID Number, Sequenced number assigned instead.<br>";
	$bsql="SELECT max(IDKey) FROM numbers";
	if ($bresult = mysqli_query($conn, $bsql)) {
	$row = $bresult->fetch_assoc();
	$newid=$row["max(IDKey)"];
	echo " $newid is the User's new ID Number.<br>";
	}
	
}
echo "<br>".$fname."<br>";
echo $lname."<br>";
echo $add."<br>";
echo $pass."<br>";
echo $username."<br><br>";
if (mysqli_query($conn, $sql)) {
	echo "New record created successfully";
} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Cancel'></form><br>";
?>
</body>
</html>