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
$_SESSION["IDQKey"]=$_POST["rad"];
$idq=$_POST["rad"];
$sql="SELECT * FROM scopes WHERE IDQKey=$idq";
$result = mysqli_query($conn, $sql);
echo "The Quote Has the Following Scopes:<br>";
while($row = $result->fetch_assoc()){
	echo $row["AgentID"]." Said:".$row["Text"]."<br>";
}
?>
What would you like to do?:<br>

<form action="/SalesAgents/uploadpic.php" method="post">
<input type="number" value=<?php echo "'$idq'";?> name="backnum" hidden>
<input type="submit" value="Upload Picture">
</form><br>
<form action="/SalesAgents/viewpic.php" method="post">
<input type="number" value=<?php echo "'$idq'";?> name="backnum" hidden>
<input type="submit" value="View Pictures">
</form><br>
<form action="/SalesAgents/scope.php" method="post">
<input type="number" value=<?php echo "'$idq'";?> name="backnum" hidden>
<input type="submit" value="Define Scope">
</form><br>
<form action="/SalesAgents/parts.php" method="post">
<input type="number" value=<?php echo "'$idq'";?> name="backnum" hidden>
<input type="submit" value="Edit Part list" disabled>:Temporarily Disabled
</form><br>
<form action="/SalesManager/ApproveQuote.php" method="post">
<input type="number" value=<?php echo "'$idq'";?> name="backnum" hidden>
<input type="submit" value="Approve">
</form><br>
<form action="/SalesManager/AssignQuote.php" method="post">
<input type="number" value=<?php echo "'$idq'";?> name="backnum" hidden>
<select name='who'>
<?php 
$idnum=$_SESSION["idnum"];
$asql="SELECT * FROM agents WHERE SupervisorID='$idnum' AND AccountType='1'";
$aresult = mysqli_query($conn, $asql);
while($arow = $aresult->fetch_assoc()) {
	$aid=$arow["IDKey"];
	$fn=$arow["Fname"];
	$ln=$arow["Lname"];
	echo "<option value='$aid'>$fn,$ln</option>";
}
?>
</select>
<input type="submit" value="Assign">
</form><br>
<br>
<?php
$what=$_SESSION["what"];
$when=$_SESSION["when"];
echo "
<form action='/SalesAgents/viewquotes.php' method='post'>
<input type='submit' value='Return to Search'>
<input type='text' value='$what' name='what' hidden>
<input type='text' value='$when' name='when' hidden>
</form>";
?>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>