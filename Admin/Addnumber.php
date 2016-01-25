<html>
<head>
<link rel="stylesheet" type="text/css" href="/Big Style.css">
<title>CoolHeat comfort CRM</title>
<script src="/sorttable.js"></script>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
Create Lead<br><br><table class='flags'>
<form action="/Admin/savenumber.php" method="post">
<tr><td  class='flagbox'>First Name:</td><td  class='flagbox'><input type="text" name='fn' value=''  class='updatetext'></td></tr>
<tr><td  class='flagbox'>Last Name:</td><td  class='flagbox'><input type="text" name='ln' value=''  class='updatetext'></td></tr>
<tr><td  class='flagbox'>Address:</td><td  class='flagbox'><input type="text" name='add' value=''  class='updatetext'></td></tr>
<tr><td  class='flagbox'>Phone Number:</td><td  class='flagbox'><input type="tel" name='pnum' value=''  class='updatetext'></td></tr>
<tr><td  class='flagbox'>City:</td><td  class='flagbox'><input type="text" name='z' value=''  class='updatetext'></td></tr>
<tr><td  class='flagbox'>Pcode:</td><td  class='flagbox'><input type="text" name='code' value=''  class='updatetext'></td></tr>
<tr><td  class='flagbox'>Email:</td><td  class='flagbox'><input type="text" name='email' value=''  class='updatetext'></td></tr>
<tr><td  class='flagbox'>CellNumber:</td><td  class='flagbox'><input type="tel" name='cnum' value=''  class='updatetext'></td></tr>
<tr><td  class='flagbox'>Source:</td><td  class='flagbox'>
<select name="source" class='Sales-select'>
<option value="Referral">Referral</option>
<option value="Lawn Sign">Lawn Sign</option>
<option value="Facebook">Facebook</option>
<option value="Flyer">Flyer</option>
<option value="Groupon">Groupon</option>
<option value="Kijiji">Kijiji</option>
<option value="Google">Google</option>
<option value="Other">Other</option>
</select></td></tr>

<?php 
session_start();
echo "<tr><td  class='flagbox'>Schedule:</td><td  class='flagbox'><select name='shift'  class='Sales-select'>";
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$sql="SELECT * FROM shifts WHERE Date>'$date' AND slots>'0' AND type='sa' ORDER BY Date;";
$result = mysqli_query($conn, $sql);
echo "<option value='0'>No Timeslot</option>";
while($row = $result->fetch_assoc()) {
	$date=$row["Date"];
	$start=$row["Start"];
	$end=$row["End"];
	$z=$row["Zone"];
	$idkey=$row["IDKey"];
	echo "<option value='$idkey'>$date, $start - $end, $z</option>";
}
echo "</select></td></tr>";
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
echo "<tr><td  class='flagbox'>Schedule Past:</td><td  class='flagbox'><select name='shiftP'  class='Sales-select'>";
$sql="SELECT * FROM shifts WHERE Date<'$date' AND slots>'0' AND type='sa' ORDER BY Date DESC;";
$result = mysqli_query($conn, $sql);
echo "<option value='0'>Future Slot</option>";
for($X=0;$X<25;$X++){
 	$row = $result->fetch_assoc();
	$date=$row["Date"];
	$start=$row["Start"];
	$end=$row["End"];
	$z=$row["Zone"];
	$idkey=$row["IDKey"];
	echo "<option value='$idkey'>$date, $start - $end, $z</option>";
}
echo "</select></td></tr>";

?>

<tr><td  class='flagbox'><input type="submit" value="Add"  class='calbutton'></td></tr>
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<tr><td  class='flagbox'><form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><input type='text' name='pass' value='$pass' hidden>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu'  class='calbutton'></form><br></td></tr></table>";
?>
</body>
</html>