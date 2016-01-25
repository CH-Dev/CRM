<html>
<head>
<link rel="stylesheet" type="text/css" href="/Big Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
error_reporting(0);
include '..\Validate.php';
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
$idkey=$_SESSION["IDKey"];
$idnkey=$_SESSION["IDNKey"];
$idnum=$_SESSION["idnum"];
$bkey=$_SESSION["IDKey"];
$sql="SELECT * FROM quotes WHERE IDNKey='$idnkey'";
$result = mysqli_query($conn, $sql);
$idq=0;
if (mysqli_num_rows($result)>0) {
	$row = $result->fetch_assoc();
	$idq=$row["IDKey"];
	$_SESSION["IDQKey"]=$idq;
}

if($_POST["Mode"]==1){
	$fn=validateinput($_POST["Fname"]);
	$ln=validateinput($_POST["Lname"]);
	$add=validateinput($_POST["Address"]);
	$at=validateinput($_POST["Btime"]);
	$ac=validateinput($_POST["ACAge"]);
	$fa=validateinput($_POST["FAge"]);
	$pnum=validateinput($_POST["Pnumber"]);
	$cell=$_POST["Cell"];
	$rad=$_POST["rad"];
	$price=$_POST["price"];
	$expiry=$_POST["exp"];
	
	$date = substr(date('Y/m/d H:i:s'),0,10);
	$date=str_replace('/', '-', $date);
	$expiry=str_replace('/', '-', $expiry);
	$sql="Update numbers SET Fname='$fn',Lname='$ln',Address='$add',ACAge='$ac',FAge='$fa',Pnumber='$pnum',CellNumber='$cell' WHERE IDNKey='$idnkey';";
	$result = mysqli_query($conn, $sql);
	$flags=$_POST["check"];
	$Aflag='0';$Fflag='0';$Tflag='0';$Bflag='0';$Sflag='0';
	$l=count($flags);
	for($x=0;$x<$l;$x++){
		if($flags[$x]=='a'){$Aflag='1';}
		else if($flags[$x]=='f'){$Fflag='1';}
		else if($flags[$x]=='t'){$Tflag='1';}
		else if($flags[$x]=='b'){$Bflag='1';}
		else if($flags[$x]=='s'){$Sflag='1';}
	}
	$apptID=$_POST["Btime"];
	$booksql="UPDATE bookings SET Aflag='$Aflag',Fflag='$Fflag',Bflag='$Bflag',Tflag='$Tflag',Sflag='$Sflag' WHERE IDKey='$bkey'";
	$bookresult = mysqli_query($conn, $booksql);
	if($_POST['rad']=="quote"){
		$r2sql="SELECT * FROM quotes WHERE IDNKey='$idnkey'";
		$r2result = mysqli_query($conn, $r2sql);
		if (mysqli_num_rows($r2result) ==0) {
			$csql="INSERT INTO quotes (Price,DateIssued,Expiry,IDBKey,SalesmanID,IDNKey)VALUES('$price','$date','$expiry','$idkey','$idnum','$idnkey');";
			$result = mysqli_query($conn, $csql);
			$booksql="UPDATE bookings SET Heat='0' WHERE IDKey='$idkey'";
			$bookresult = mysqli_query($conn, $booksql);
			$esql="SELECT bookings.LastContactID,shifts.WID,numbers.OriginalCaller FROM bookings INNER JOIN shifts ON bookings.AppointmentID=shifts.IDKey INNER JOIN numbers ON bookings.IDNKey=numbers.IDNKey WHERE bookings.IDKey='$idkey'";
			$eresult = mysqli_query($conn, $esql);
			$erow = $eresult->fetch_assoc();
			$agent=$erow["LastContactID"];
			$wid=$erow["WID"];
			$oc=$erow["OriginalCaller"];
			$tpay=0;
			if($Fflag==1&&$Aflag==1){
				$tpay+=40;
			}
			if($Fflag==1&&$Aflag==0){
				$tpay+=30;
			}
			if($Aflag==1&&$Fflag==0){
				$tpay+=20;
			}
			if($Tflag==1){
				$tpay+=10;
			}
			if($Bflag==1){
				$tpay+=30;
			}
			if($oc!=""&&$oc!=null&&$oc!="0"){
				$tpay*=0.75;
			}
			//This Section handles Payments
			$dsql="INSERT INTO payments (AgentID,WID,Amount,Type,IDNKey)VALUES('$agent','$wid','$tpay','CCQ','$idnkey');";
			$dresult = mysqli_query($conn, $dsql);
			if($oc!=null&&$oc!=""&&$oc!="0"){
				$tpay/=3;
				$hsql="INSERT INTO payments (AgentID,WID,Amount,Type,IDNKey,Method)VALUES('$oc','$wid','$tpay','CCQ','$idnkey','Quoting a booking');";
				$hresult = mysqli_query($conn, $hsql);
			}
		}
	}
	if($_POST['rad']=="inspect"){
		$csql="INSERT INTO quotes (Price,DateIssued,Expiry,IDBKey,Preinspect,IDNKey)VALUES('$price','$date','$expiry','$bkey','1','$idnkey')";
		$result = mysqli_query($conn, $csql);
		$booksql="UPDATE bookings SET Heat='0' WHERE IDKey='$idkey'";
		$bookresult = mysqli_query($conn, $booksql);
	}
	elseif ($_POST['rad']=="rebook"){
		$Btime=$_POST["Btime"];
		if($Btime==0){
			$csql="UPDATE bookings SET AppointmentID='1' WHERE IDKey='$bkey'";
		}else{
			$csql="UPDATE bookings SET AppointmentID='$Btime' WHERE IDKey='$bkey'";
		}
		
		$result = mysqli_query($conn, $csql);
		
		$csql="INSERT INTO reminders (Text,Date,Time,End,AgentID) VALUES('Rebook: $fn, $ln : $pnum','$Btime','X','X','0')";
		mysqli_query($conn, $csql);
	}elseif($_POST['rad']=="serv"){
		$csql="UPDATE bookigs SET Cancelled='1' WHERE IDKey='$bkey'";
		$result=mysqli_query($conn, $csql);
		$dsql="INSERT INTO Cleanings(IDNKey,ApptID) VALUES ($idnkey,$day)";
		$result=mysqli_query($conn, $dsql);
	}
	elseif($_POST['rad']=="can"){
		$csql="UPDATE bookings SET Cancelled='1' WHERE IDKey='$bkey';";
		$result = mysqli_query($conn, $csql);
	}
	$r2sql="SELECT * FROM reminders WHERE IDNKey='$idnkey' AND auto='1'";
	$r2result = mysqli_query($conn, $r2sql);
	if (mysqli_num_rows($r2result) ==0) {
		$rsql="INSERT INTO reminders (Text,AgentID,Date,IDNKey,auto) VALUES ('AUTOREMINDER','$idnum','$date','$idnkey','1')";
		$rresult = mysqli_query($conn, $rsql);
	}
	
}

/*
$what=$_SESSION["what"];
$when=$_SESSION["when"];

echo "<div id='comsect'>
<form action='/SalesAgents/bookingshow.php' method='post'>
<input type='text' value='$what' name='what' hidden>
<input type='date' value='$when' name='when' hidden>
Back to Search:<input type='submit' value='Bookings'>
</form>
</div>	";
*/




$sql="SELECT * FROM quotes WHERE IDNKey='$idnkey'";
$result = mysqli_query($conn, $sql);
$idq=0;
if (mysqli_num_rows($result)>0) {
	$row = $result->fetch_assoc();
	$idq=$row["IDKey"];
	$_SESSION["IDQKey"]=$idq;
}
//Start Set up the GUI for Salesman
echo "Create Notes and Reminders<br><br>Notes:<br><form action='/Calendar/CreateNote.php' method='post'>
<input type='text' name='text' class='updatetextBig'><br><br>
<input type='submit' value='Save Note' class='calbutton'>
</form>
Reminders:<br>
<form action='/SalesManager/createreminder2.php' method='post'>
<input type='number' value='$idnkey' name='idn' hidden>
<input type='text' name='text' class='updatetextBig'><br>
<table class='flags'>
<tr><td class='flagbox'>Set Reminder Date:</td><td class='flagbox'><input type='date' name='date' class='updatetext'></td></tr>
<tr><td class='flagbox'>Assign to:</td><td class='flagbox'><select name='who' class='Sales-select'><option value='$idnum'>Me</option>";
$sql="SELECT Fname,Lname,IDKey from agents WHERE SupervisorID='$idnum'";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()){
	$id=$row["IDKey"];
	$fn=$row["Fname"];
	$ln=$row["Lname"];
	echo "<option value='$id'>$fn $ln</option>";
}
echo "</select></td></tr><br><tr><td class='flagbox'><input type='submit' value='Save Reminder' class='calbutton'></td></table></form>";
if($idq>0){
	echo "<form action='/SalesAgents/uploadpic.php' method='post'>
	<input type='number' value='$idq' name='backnum' hidden>
	<input type='submit' value='Upload Picture' method='post' class='calbutton'>
	</form></td></tr><tr><td>
	<form action='/SalesAgents/viewpic.php' method='post'>
	<input type='number' value='$idq' name='backnum' hidden>
	<input type='submit' value='View Pictures' method='post' class='calbutton'>
	</form></td></tr><tr><td>
	<form action='/SalesAgents/scope.php' method='post'>
	<input type='number' value='$idq' name='backnum' hidden>
	<input type='submit' value='Define Scope' class='calbutton'>
	</form></td></tr><tr><td>";
	$sqlj="SELECT * FROM jobs WHERE IDQKey='$idq'";
	$jresult = mysqli_query($conn, $sqlj);
	if (mysqli_num_rows($jresult)==0) {
		echo "<form action='/SalesAgents/Createjob.php' method='post'>
		<input type='number' value='$idq' name='backnum' hidden>
		<input type='submit' value='Turn to Job' class='calbutton'>
		</form>
		";
	}
	
}
//End GUI
echo "<form action='/SalesAgents/updatebookings.php' method='post'>
<input type='submit' class='dayviewbutton' value='Back'>
<input type='text' name='rad' value='$bkey'hidden></form><br>";




?>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden> <input type='text' name='pass' value='$pass' hidden>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu' class='calbutton'><input type='text' name='mode' value='0' hidden></form><br>";
?>
</body>
</html>