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
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
if($_POST["mode"]!=1){
	
	if($_POST["mode"]==0){
		$num=$_POST["start"]."%".$_POST["mid"]."%".$_POST["end"];
		$sql="SELECT IDNKey,Pnumber,Fname,Lname,Response FROM numbers WHERE Pnumber LIKE '%$num%'";
	}
	if($_POST["mode"]==2){
		$add=$_POST["end"];
		$sql="SELECT IDNKey,Pnumber,Fname,Lname,Response FROM numbers WHERE Pnumber LIKE '%$add%'";
	}
	$result = mysqli_query($conn, $sql);
	while($row = $result->fetch_assoc()) {
		$idn=$row["IDNKey"];
		$pnum=$row["Pnumber"];
		$fn=$row["Fname"];
		$ln=$row["Lname"];
		$resp=$row["Response"];
		echo "<form action='/Admin/Modifynum.php' method='post'>$pnum:$fn $ln, Most recent Response is :$resp<br>";
		$sql3="SELECT * FROM bookings WHERE IDNKey='$idn'";
		$result3 = mysqli_query($conn, $sql3);
		$row3 = $result3->fetch_assoc();
		$agentid=$row3["LastContactID"];
		$sql4="SELECT * FROM agents WHERE IDKey='$agentid'";
		$result4 = mysqli_query($conn, $sql4);
		$row4 = $result4->fetch_assoc();
		echo " Assigned User:".$row4["Fname"]." ".$row4["Lname"]."<br>Below is the unanswered calls for this number.";
		echo "<input type='number' value='$idn' hidden name='number'>  <input type='submit' value='Modify'></form>";
	
		$sql2="SELECT * FROM ootracker WHERE IDNKey='$idn'";
		$result2 = mysqli_query($conn, $sql2);
		while($row2 = $result2->fetch_assoc()) {
			$agent=$row2["AgentID"];
			$date=$row2["DateofContact"];
			$time=$row2["TIME"];
			$sql4="SELECT * FROM agents WHERE IDKey='$agentid'";
			$result4 = mysqli_query($conn, $sql4);
			$row4 = $result4->fetch_assoc();
			$name=$row4["Fname"]." ".$row4["Lname"];
			echo " $name: $date : $time<br>";
		}
	}
}
else if($_POST["mode"]==1){
	$resp=$_POST["rad"];
	$add=$_POST["add"];
	$addb=$_POST["addb"];
	$sql2="SELECT count(Pnumber) FROM numbers WHERE Response='o' AND Address LIKE '%$add%$addb%'";
	$result2 = mysqli_query($conn, $sql2);
	$row2 = $result2->fetch_assoc();
	$count=$row2["count(Pnumber)"];
	echo "<br><b>$count</b> numbers have been modified(this can be undone by tech with this number $count<br>";
	$sql="UPDATE numbers SET Response='$resp',Comments1='Mass Edited$count' WHERE Address LIKE '%$add%$addb%' AND Response='o'";
	mysqli_query($conn, $sql);
	
}

?>
<br>
Search for a Number:
<form action="/Admin/ooCheck.php" method="post">
(<input type="text" name="start" style='width: 3em' value="613">)
<input type="text" name="mid" style='width: 3em'>-
<input type="text" name="end" style='width: 4em'>
<input type="text" name="mode" hidden value="0">
<input type="submit" value="Check">
</form>
Mass Modify Mode:<br>
<form action="/Admin/ooCheck.php" method="post">
<input type="text" name="mode" hidden value="1">
Address:<input type="text" name="add" style='width: 15em'><input type="text" name="addb" style='width: 15em'><br>
Response:<select name='rad'>
<option value='NA'>No Answer</option>
<option value='booked'>booked</option>
<option value='DNC'>Do Not Call</option>
<option value='NI'>Not Interested</option>
<option value='o'>Uncalled</option>
<option value='B'>Business</option>
<option value='oo'>No Answer</option>
<option value='NS'>No Signal</option>
<option value='CB'>Call Back</option>
<option value='DNQ'>Does Not Qualify</option>
<option value='APP'>Renting</option>
</select><br>
<input type="submit" value="Update">
</form>

<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>