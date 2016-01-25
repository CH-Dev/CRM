<html>
<head>
<title>CoolHeat comfort CRM</title>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$idnum=$_SESSION["idnum"];
$myidnum=$idnum;
$at=$_SESSION["AccountType"];
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
if($_POST["mode"]==1){
	$didk=$_POST["didn"];
	$dsql="UPDATE todo SET Deleted='1' WHERE IDKey='$didk'";
	mysqli_query($conn, $dsql);
}else if($_POST["mode"]==2){
	$texti=$_POST["text"];
	$dsql="INSERT INTO todo (Text,AgentID,Poster) VALUES ('$texti','$idnum','$myidnum')";
	mysqli_query($conn, $dsql);
}else if($_POST["mode"]==3){
	$idnum=$_POST["agent"];
}else if($_POST["mode"]==4){
	$idnum=$_POST["agent"];
	$texti=$_POST["text"];
	$dsql="INSERT INTO todo (Text,AgentID,Poster) VALUES ('$texti','$idnum','$myidnum')";
	mysqli_query($conn, $dsql);
}else if($_POST["mode"]==5){
	$idnum=$_POST["agent"];
	$didk=$_POST["didn"];
	$dsql="UPDATE todo SET Deleted='1' WHERE IDKey='$didk'";
	mysqli_query($conn, $dsql);
}
$asql2="SELECT CONCAT(Fname,' ',Lname) AS name FROM agents WHERE IDKey='$idnum'";
$a2result = mysqli_query($conn, $asql2);
$a2row = $a2result->fetch_assoc();
echo $a2row["name"]."'s To Do list<br>";
$sql="SELECT * FROM todo WHERE AgentID='$idnum' AND Deleted IS NULL";
$result = mysqli_query($conn, $sql);
if($at==1){
	echo "<link rel='stylesheet' type='text/css'' href='Big Style.css'>";
	echo "<table class='flags'>";
}
while($row = $result->fetch_assoc()){
	echo "<tr>";
	$text=$row["Text"];
	$idk=$row["IDKey"];
	echo "<td>$text</td>";
	if($myidnum==$idnum){
		if($_POST["mode"]<3){
			if($at==1){
				echo "<td><form action='ToDoList.php' method='post'><input type='text' name='mode' value='1' hidden><input type='text' name='didn' value='$idk' hidden>
				<input type='submit' value='Delete' class='calbutton'></form></td>";
			} else{
				echo "<td><form action='ToDoList.php' method='post'><input type='text' name='mode' value='1' hidden><input type='text' name='didn' value='$idk' hidden>
				<input type='submit' value='Delete'></form></td>";
			}
		} else {
			if($at==1){
				echo "<td><form action='ToDoList.php' method='post'><input type='text' name='mode' value='5' hidden><input type='text' name='didn' value='$idk' hidden>
				<input type='submit' value='Delete' class='calbutton'><input type='text' name='agent' value='$idnum' hidden></form></td>";
			}else{
				echo "<td><form action='ToDoList.php' method='post'><input type='text' name='mode' value='5' hidden><input type='text' name='didn' value='$idk' hidden>
				<input type='submit' value='Delete'><input type='text' name='agent' value='$idnum' hidden></form></td>";
			}
		}
	}
	echo "<br>";
	
}
echo "</table><br><form action='ToDoList.php' method='post'>";
if($_POST["mode"]<3){
	echo "<input type='text' name='mode' value='2' hidden>";
	if($at==1){
		echo "<input type='text' name='text' class='updatetext'><br>
			<input type='submit' value='Add to List' class='calbutton'>";
	}else{
		echo "<input type='text' name='text'><br>
			<input type='submit' value='Add to List'>";
	}
}
else{
	echo "<input type='text' name='mode' value='4' hidden>";
	if($at==1){
		echo "<input type='text' name='text' class='updatetext'><br>
			<input type='submit' value='Add to List' class='calbutton'>
			<input type='text' name='agent' value='$idnum' hidden>";
	}else{
		echo "<input type='text' name='text'><br>
			<input type='submit' value='Add to List'>
			<input type='text' name='agent' value='$idnum' hidden>";
	}
}

echo "</form>";
echo "<br> <form action='ToDoList.php' method='post'><select name='agent'>";
$asql="SELECT Fname,Lname,IDKey FROM agents WHERE DateofTermination IS NULL";
$aresult = mysqli_query($conn, $asql);
while($arow = $aresult->fetch_assoc()){
	$name=$arow["Fname"]." ".$arow["Lname"];
	$AID=$arow["IDKey"];
	echo "<option value='$AID'>$name</option>";
}
echo "</select>";
if($at==1){
	echo "<br>
	<input type='submit' value='View Agent' class='calbutton'>";
}else{
	echo "<br>
	<input type='submit' value='View Agent'>";
}
echo "<input type='text' name='mode' value='3' hidden></form>";
?>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
if($at==1){
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden> <input type='text' name='pass' value='$pass' hidden>
	<input type='text' name='mode' value='0' hidden>
	<input type='submit' value='Main Menu' class='calbutton'><input type='text' name='mode' value='0' hidden></form><br>";
}else{
	echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
	Back:<input type='submit' value='Main Menu'></form><br>";
}
?>
</body>
</html>