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
?>
<form action='/Cleaners/cleansubmit.php' method='post'></form>
<table>
 <tr><td>Customer Name:</td></tr>
 <tr><td>Address:</td></tr>
 <tr><td>City:</td></tr>
 <tr><td>Phone#:</td></tr>
 <tr><td>Email Address:</td></tr>
 <tr><td>Request for Quote/Services:<select name='quote'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td></td></tr>
 <tr><td>Call For Heat<td><td><select name='cfh'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Heat Exchanger Damaged<td><td><select name='hed'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Cleanings<td><td><select name='cleaning'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Burners:<td><td><select name='burner'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Venting:<td><td><select name='vent'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Traps/Drains:<td><td><select name='trap'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Fans:<td><td><select name='fan'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Ignitors and sensors:<td><td><select name='ign'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Heat Exchanged:<td><td><select name='he'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Gas Leaks:<td><td><select name='gl'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Gas Pressure:<td><td><input type='text' name='gasP'></td></tr>
 <tr><td>CO:<td><td><input type='text' name='co'></td></tr>
 <tr><td>Temperature Rise:<td><td><input type='text' name='tr'></td></tr>
 <tr><td>Hi Limit Working:<td><td><select name='hilim'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>APS Working:<td><td><select name='aps'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Flame Sensor:<td><td><select name='fsen'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Call for Heat:<td><td><select name='call'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Fan:<td><td><input type='text' name='fan2'></td></tr>
 <tr><td>Capacitor:<td><td><input type='text' name='cap'></td></tr>
 <tr><td>Door Switch:<td><td><select name='ds'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Wiring Damage:<td><td><select name='wire'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Meter Testing<td><td><input type='text' name='meter'></td></tr>
 <tr><td>Lockup:<td><td><input type='text' name='lock'></td></tr>
 <tr><td>Seepage:<td><td><input type='text' name='seep'></td></tr>
 <tr><td>MonoMeter:<td><td><input type='text' name='mono'></td></tr>
 <tr><td>Dial:<td><td><input type='text' name='dial'></td></tr>
 <tr><td>HSI:<td><td><input type='text' name='hsi'></td></tr>
 <tr><td>Refrigeration<td><td><input type='text' name='ref'></td></tr>
 <tr><td>Pressure1:<td><td><input type='text' name='pres'></td></tr>
 <tr><td>Temperature1:<td><td><input type='text' name='temp1'></td></tr>
 <tr><td>Pressure2:<td><td><input type='text' name='pres2'></td></tr>
 <tr><td>Temperature2:<td><td><input type='text' name='temp2'></td></tr>
 <tr><td>Damage:<td><td><select name='damac'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Hot Water System<td><td><input type='text' name='hot'></td></tr>
 <tr><td>PRV Working:<td><td><select name='prv'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Gas Pressure:<td><td><input type='text' name='waterpres'></td></tr>
 <tr><td>Cleared:<td><td><select name='clear'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Damage:<td><td><select name='dam2'><option value='y'>Yes</option><option value='n'>No</option></select></td></tr>
 <tr><td>Comments<td><td><input type='text' name='comments'></td></tr>
 </table>
 <input type="submit">
 </form>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>