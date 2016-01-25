<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<link rel="stylesheet" media="screen and (max-width: 800px)" href="/Mobile Style.css" />
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
$idn=$_POST["number"];
$sql="SELECT * FROM numbers WHERE IDNKey='$idn'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$fn=$row["Fname"];
$ln=$row["Lname"];
$add=$row["Address"];
$resp=$row["Response"];
$sql2="SELECT * FROM bookings WHERE IDNKey='$idn'";
$result2 = mysqli_query($conn, $sql2);
$row2 = $result2->fetch_assoc();
$ff=$row2["Fflag"];
$af=$row2["Aflag"];
$bf=$row2["Bflag"];
$tf=$row2["Tflag"];
$sf=$row2["Sflag"];
$Aid=$row2["LastContactID"];
?>
<form action="/Admin/modifynum2.php" method="post">
<input type="text" value="<?php echo $idn;?>" name="idn" hidden>
FN:<input type="text" value="<?php echo $fn;?>" name="fname">
LN:<input type="text" value="<?php echo $ln;?>" name="lname"><br>
Address:<input type="text" value="<?php echo $add;?>" name="add">
Response:<select name='rad'>
<option value="<?php echo $resp;?>"><?php echo $resp;?></option>
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
Appointment type:<br>
<?php 
echo "
Furnace:<input type='checkbox' name='check' value='f'";if($ff==1){echo "checked";}echo "><br>
A/C:<input type='checkbox' name='check' value='a'";if($af==1){echo "checked";}echo "><br>
Water Tank:<input type='checkbox' name='check' value='t'";if($tf==1){echo "checked";}echo "><br>
Boiler:<input type='checkbox' name='check' value='b'";if($bf==1){echo "checked";}echo "><br>
Service:<input type='checkbox' name='check' value='s'";if($sf==1){echo "checked";}echo ">";
?>
<?php 
echo "Time Slot:<select name='Btime'>";
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$sql="SELECT * FROM shifts WHERE Date>'$date' AND slots>'0' AND type='sa';";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$date=$row["Date"];
	$start=$row["Start"];
	$end=$row["End"];
	$idkey=$row["IDKey"];
	echo "<option value='$idkey'>$date, $start - $end</option>";
}
echo "</select>";

?>
<select name='who'>
<?php 
$idnum=$_SESSION["idnum"];
$asql="SELECT * FROM agents WHERE SupervisorID='$idnum' AND AccountType='0'";
$aresult = mysqli_query($conn, $asql);
$a2sql="SELECT * FROM agents WHERE IDKey='$Aid'";
$a2result = mysqli_query($conn, $a2sql);
$a2row = $a2result->fetch_assoc();
$afn=$a2row["Fname"];
$aln=$a2row["Lname"];

echo "<option value='$Aid'>$afn $aln</option>";
echo "<option value='$idnum'>me!</option>";
while($arow = $aresult->fetch_assoc()) {
	$aid=$arow["IDKey"];
	$fn=$arow["Fname"];
	$ln=$arow["Lname"];
	echo "<option value='$aid'>$fn,$ln</option>";
}
?>
	
</select>
<input type="submit" value="Submit">
</form>

<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>