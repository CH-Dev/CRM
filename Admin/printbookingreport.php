<html>
<head>
<title>CoolHeat comfort CRM</title>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
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
$sql="SELECT IDNKey FROM numbers WHERE IDNKey IN (SELECT IDNKey FROM bookings)";
$result = mysqli_query($conn, $sql);
$IDNarray=array();
for($count=0;$count<$result->num_rows;$count++){
	$row = $result->fetch_assoc();
	$IDNarray[$row["IDNKey"]]=$row["IDNKey"];
}

$sql2="SELECT IDNKey FROM numbers WHERE IDNKey IN (SELECT IDNKey FROM quotes)";
$result2 = mysqli_query($conn, $sql2);
for($count=0;$count<$result2->num_rows;$count++){
	$row2 = $result2->fetch_assoc();
	$IDNarray[$row2["IDNKey"]]=$row2["IDNKey"];
}
$sql3="SELECT MAX(IDNKey) FROM numbers";
$result3 = mysqli_query($conn, $sql3);
$row3 = $result3->fetch_assoc();
$arrlength = $row3["MAX(IDNKey)"];
echo $arrlength;
?>
<table>
<tr>
<td>Name</td>
<td>Date Booked</td>
<td>Date of Appointment</td>
<td>Qualified?</td>
<td>Lead Value</td>
<td>Followup date</td>
<td>Converted</td>
<td>Date of Completion</td>
<td>A Pay Date</td>
<td>B Pay Date</td>
<td>Other Pay Data</td>
<?php 
RowTicker("start");
for($count=0;$count<$arrlength;$count++){
	if(isset($IDNarray[$count])){
		RowTicker("next");
		//echo "Found $IDNarray[$count]<br>";
		$nsql="SELECT Fname,Lname FROM numbers WHERE IDNKey='$IDNarray[$count]'";
		$nresult = mysqli_query($conn, $nsql);
		$nrow = $nresult->fetch_assoc();
		$fn=$nrow["Fname"];
		$ln=$nrow["Lname"];
		$bsql="SELECT bookings.DateofBooking,shifts.Date,bookings.Fflag,bookings.Aflag,bookings.Tflag,bookings.Bflag,weeks.PayDate FROM bookings INNER JOIN shifts ON bookings.AppointmentID=shifts.IDKey INNER JOIN weeks ON shifts.WID=weeks.IDKey WHERE IDNKey='$IDNarray[$count]'";
		$bresult = mysqli_query($conn, $bsql);
		$brow = $bresult->fetch_assoc();
		$bd=$brow["DateofBooking"];
		$f=$brow["Fflag"];
		$a=$brow["Aflag"];
		$t=$brow["Tflag"];
		$b=$brow["Bflag"];
		$sd=$brow["Date"];
		$paydate=$brow["PayDate"];
		$qsql="SELECT IDKey FROM quotes WHERE IDNKey='$IDNarray[$count]'";
		$qresult = mysqli_query($conn, $qsql);
		$qrow = $qresult->fetch_assoc();
		$idq=$qrow["IDKey"];
		$jsql="SELECT shifts.Date,weeks.PayDate FROM jobs INNER JOIN shifts ON jobs.DateofCompletion=shifts.IDKey INNER JOIN weeks ON shifts.WID=weeks.IDKey WHERE IDQKey='$idq'";
		$jresult = mysqli_query($conn, $jsql);
		$jrow = $jresult->fetch_assoc();
		$cd=$jrow["DateofCompletion"];
		$backpay=$jrow["PayDate"];
		$value=0;
		if($f==1){
			$value+=30;
			if($a==1){
				$value+=10;
			}
		}
		if($a==1&&$f==0){
			$value+=20;
		}
		if($t==1){
			$value+=10;
		}
		if($b==1){
			$value+=30;
		}
		echorow("$fn $ln");
		echorow($bd);//Date booked
		echorow($sd);//Date of Appointment
		echorow(echocheck($f).echocheck($a).echocheck($t).echocheck($b));//Flags
		echorow($value);//Value
		echorow("");//Followup Update
		echorow(echocheck($cd));//ConverteD?
		echorow("$cd");//Date of install
		echorow("$paydate");//Front End Pay Date
		echorow("$backpay");//Back End Pay Date
		echorow("");//Pay Data
		echo "</tr>";
	}
}
function echorow($p){
	echo "<td>$p</td>";
}
function echocheck($p){
	if($p>'0'){
		return "&#10004";
	}else{
		return "&#10006";
	}
}
function RowTicker($go){
	if($go=="start"){
		$GLOBALS["trc"]=0;
	}
	else{
		if($GLOBALS["trc"]==1){
			$GLOBALS["trc"];
			echo "<tr>";
			$GLOBALS["trc"]=0;
		}
		else{
			echo "<tr class='stripe'>";
			$GLOBALS["trc"]++;
		}
	}
}
?>
</table>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>