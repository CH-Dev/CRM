<html>
<head>
<link rel="stylesheet" type="text/css" href="/Big Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
$_SESSION["IDQKey"]=$_POST["rad"];
$idq=$_SESSION["IDQKey"];
$sql="SELECT * FROM scopes WHERE IDQKey=$idq";
$result = mysqli_query($conn, $sql);
$bsql="SELECT * FROM quotes WHERE IDKey='$idq'";
$bresult = mysqli_query($conn, $bsql);
$brow = $bresult->fetch_assoc();
$idnk=$brow["IDNKey"];
$nsql="SELECT * FROM numbers WHERE IDNKey='$idnk'";
$nresult = mysqli_query($conn, $nsql);
$nrow = $nresult->fetch_assoc();
$fn=$nrow["Fname"];
$ln=$nrow["Lname"];
$add=$nrow["Address"];
$pnum=$nrow["Pnumber"];
echo "$fn $ln<br>$add<br>$pnum<br>";
$_SESSION["IDNKey"]=$brow["IDNKey"];
echo "Scopes:<br>";
while($row = $result->fetch_assoc()){
	echo $row["AgentID"]." Said:".$row["Text"]."<br>";
}

echo"Notes:<br>";
$nsql="SELECT * FROM notes WHERE IDNKey='$idnk'";
$nresult = mysqli_query($conn, $nsql);
while($nrow = $nresult->fetch_assoc()) {
	$agent=$nrow["AgentID"];
	$sql="SELECT Fname,Lname FROM agents WHERE IDKey='$agent'";
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_assoc();
	$name= $row["Fname"]." ".$row["Lname"];
	$text=$nrow["Text"];
	$time=$nrow["Date"];
	echo "$time:$name said: $text<br>";
}

?>
<table class='flags'>
<tr><td class='flagbox'>
<form action='/Calendar/CreateNote.php' method='post'>
<input type='text' value='' name='text' class='updatetext'><br>
<input type='submit' value='Create Note' class='calbutton'>
</form></td></tr><tr><td class='flagbox'>
<form action="/SalesAgents/uploadpic.php" method="post">
<input type="number" value=<?php echo "'$idq'";?> name="backnum" hidden>
<input type="submit" value="Upload Picture" method="post" class='calbutton'>
</form></td></tr><tr><td class='flagbox'>
<form action="/SalesAgents/viewpic.php" method="post">
<input type="number" value=<?php echo "'$idq'";?> name="backnum" hidden>
<input type="submit" value="View Pictures" method="post" class='calbutton'>
</form></td></tr><tr><td class='flagbox'>
<form action="/SalesAgents/parts.php" method="post">
<input type="number" value=<?php echo "'$idq'";?> name="backnum" hidden>
<input type="submit" value="Edit Part list" disabled class='calbutton'>
</form></td></tr><tr><td class='flagbox'>
<form action="/SalesAgents/scope.php" method="post">
<input type="number" value=<?php echo "'$idq'";?> name="backnum" hidden>
<input type="submit" value="Define Scope" method="post" class='calbutton'>
</form></td></tr><tr><td class='flagbox'>
<form action="/SalesAgents/inspect.php" method="post">
<input type="number" value="<?php echo "$idq";?>" name="backnum" hidden>
<input type="submit" value="Request Preinspect" class='calbutton'>
</form></td></tr><tr><td class='flagbox'>
<?php 
$what=$_SESSION["what"];
$when=$_SESSION["when"];
echo "
<form action='/SalesAgents/viewquotes.php' method='post'>
<input type='submit' value='Return to Search' class='calbutton'>
<input type='text' value='$what' name='what' hidden>
<input type='text' value='$when' name='when' hidden>
</form>";
?>
</td></tr>
</table>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu' class='calbutton'></form><br>";
?>
</body>
</html>