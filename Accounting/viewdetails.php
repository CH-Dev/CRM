<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM Index</title>
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
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
$IDNKey=$_POST["rad"];
$sql="SELECT * FROM invoices WHERE IDNKey='$IDNKey'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$price=$row["Price"];
$fd=$row["FilingDate"];
$nsql="SELECT * FROM numbers WHERE IDNKey='$IDNKey'";
$nresult = mysqli_query($conn, $nsql);
$nrow = $nresult->fetch_assoc();
$bsql="SELECT shifts.WID,bookings.Aflag,bookings.Fflag,bookings.Tflag,bookings.Bflag,bookings.Sflag,shifts.Date FROM bookings INNER JOIN shifts ON bookings.AppointmentID=shifts.IDKey WHERE bookings.IDNKey='$IDNKey'";
$bresult = mysqli_query($conn, $bsql);
$brow = $bresult->fetch_assoc();
$qsql="SELECT quotes.IDKey,quotes.SalesmanID,quotes.DateIssued,quotes.Price,agents.Fname,agents.Lname FROM quotes INNER JOIN agents ON quotes.SalesmanID=agents.IDKey WHERE quotes.IDNKey='$IDNKey'";
$qresult = mysqli_query($conn, $qsql);
$qrow = $qresult->fetch_assoc();
$IDQKey=$qrow["IDKey"];
$fn=$nrow["Fname"];
$ln=$nrow["Lname"];
$source=$nrow["Source"];
$pnum=$nrow["Pnumber"];
$add=$nrow["Address"];
$pcode=$nrow["Pcode"];
$Aflag=$brow["Aflag"];
$Fflag=$brow["Fflag"];
$Bflag=$brow["Bflag"];
$Tflag=$brow["Tflag"];
$Sflag=$brow["Sflag"];
$bdate=$brow["Date"];
$mode=$_POST["mode"];
$dateissued=$qrow["DateIssued"];
$price=$qrow["Price"];
$salesID=$qrow["SalesmanID"];
$salesman=$qrow["Fname"]." ".$qrow["Lname"];
$wid=$brow["WID"];
$wsql="SELECT * FROM weeks WHERE IDKey='$wid'";
$wresult = mysqli_query($conn, $wsql);
$wrow = $wresult->fetch_assoc();
//This Section handles Payments
?>
<form action="/Accounting/ApproveJobs.php" method="post">

<?php 
echo "<input type='number' name='idn' value='$IDNKey' hidden><input type='number' name='idq' value='$IDQKey' hidden>
Name:<input type='text' value='$fn' name='fn'><input type='text' value='$ln' name='ln'><br>
Address:<input type='text' value='$add' name='add'><input type='text' value='$pcode' name='pcode'> <br>
Appointment Date:$bdate<br>
F:<input type='checkbox' name='check[]' value='f'";if($Fflag==1){echo "checked";}echo "> A:<input type='checkbox' name='check[]' value='a'";if($Aflag==1){echo "checked";}echo ">
W:<input type='checkbox' name='check[]' value='t'";if($Tflag==1){echo "checked";}echo "> B:<input type='checkbox' name='check[]' value='b'";if($Bflag==1){echo "checked";}echo ">
S:<input type='checkbox' name='check[]' value='s'";if($Sflag==1){echo "checked";}echo "><br>
Quoted by:<select name='salesman'><option value='$salesID'>$salesman</option>"; 
$ssql="SELECT * FROM agents WHERE AccountType='1' AND DateofTermination IS NULL";
$sresult = mysqli_query($conn, $ssql);
while($srow = $sresult->fetch_assoc()){
	$fn=$srow["Fname"];
	$ln=$srow["Lname"];
	$id=$srow["SalesmanID"];
	echo "<option value='$id'>$fn $ln</option>";
}
echo "</select> 
for:$<input type='number' value='$price' name='price'><br>
On:$dateissued<br>";
if($mode==0){
	echo "Start Date:<input type='date' value='$date' name='startdate'>";	
}

echo "<input type='text' value='$mode' name='mode' hidden>
		<input type='submit' value='Submit Edits'>
</form>";
if($source==""){
	$source="Call Center";
}
echo "Source:$source<br>";
$sql="SELECT Link FROM images WHERE IDQKey='$IDQKey'";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$link=$row["Link"];
	echo "<img src='$link' alt='Image' width='500' height='500'><br>";
}
?>
<?php
function echocheck($p){
	if($p=='1'){
		return "&#10004";
	}else{
		return "&#10006";
	}
}
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>