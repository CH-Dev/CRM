<html>
<head>
<title>CoolHeat comfort CRM</title>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$username=$_SESSION["username"];//Connect to the database
$idnkey=$_SESSION["IDNKey"];
$idnum=$_SESSION["idnum"];
$date = substr(date('Y/m/d H:i:s'),0,10);
$date=str_replace('/', '-', $date);
include '..\Validate.php';
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql1="SELECT Pnumber FROM numbers WHERE IDNKey='$idnkey'";
$result1 = mysqli_query($conn, $sql1);
$row1 = $result1->fetch_assoc();
$pnum=$row1["Pnumber"];
$start="UPDATE numbers SET DateofContact='$date',";//Setup our SQL template for easy access
$end=" WHERE Pnumber='$pnum'";
$mid="o";
//Handle Furnace and AC Ages
$submit=false;
$fage=validateinput($_POST["fage"]);
$acage=validateinput($_POST["acage"]);
if($fage!="0"){//if furnace age is entered
	if($acage!="0"){//if ac age is entered
		$mid=" FAge='$fage' , ACAge='$acage'";
	}
	else{
		$mid=" FAge=$fage";
	}
	$submit=true;
}//if furnace age is not entered
elseif($acage!="0"){//but AC age is
	$mid=" ACAge=$acage";
	$submit=true;
}
//Execute the SQL command for furnaces and AC
if($submit){
	$sql=$start.$mid.$end;
	//echo $sql."<br>";
	$result = mysqli_query($conn, $sql);
}
$mid="";
$sql=$start.$mid.$end;
//echo $sql."<br>";
$result = mysqli_query($conn, $sql);
$mid="Response='o'";
//echo $_POST["rad"]."<br>";
//Check what the radio button was and set the middle of the statement appropriatley!
if($_POST["rad"]=="DNC"){
	echo "DNC!";
	$mid = " Response='DNC'";
}
if($_POST["rad"]=="NS"){
	echo "No service!";
	$mid = " Response='NS'";
}
if($_POST["rad"]=="NA"){
	echo "No answer!";
	$mid= " Response='oo'";
	$time=date("h:i:sa");
	$oosql="INSERT INTO ootracker (DateofContact,Time,IDNKey,AgentID) VALUES ('$date','$time','$idnkey','$idnum')";//FINISH ME
if (mysqli_query($conn, $oosql)) {
		echo "New record created successfully<br>";
	} else {
		echo "Error: " . $oosql . "<br>" . mysqli_error($conn);
	}
}
if($_POST["rad"]=="NI"){
	echo "Not interested!";
	$mid= " Response='NI'";
}
if($_POST["rad"]=="DNQ"){
	echo "Not Qualified!";
	$mid= " Response='DNQ'";
}
if($_POST["rad"]=="APP"){
	echo "Apartment tagged!";
	$mid= " Response='APP'";
}
if($_POST["rad"]=="B"){
	echo "Business tagged!";
	$mid= " Response='B'";
}
if($_POST["rad"]=="booked"){//Deal with bookings and Callbacks as they need extra data stored!
	echo "You booked it awesome!<br>";
	$mid = " Response='booked'";
	$apptID=$_POST["Btime"];
	$flags=$_POST["check"];
	$Aflag='0';
	$Fflag='0';
	$Tflag='0';
	$Bflag='0';
	$Sflag='0';
	
	$l=count($flags);
	if($l==0){
		echo "You didn't set any Flags!!!<br> Flags are important because they determine your paycheck!!!<br>Please ask your Manager to help you fix this!<br>You'll need this Number $idnkey!!<br>";
		$emsql = "SELECT max(IDKey) FROM bookings";
		$emresult = mysqli_query($conn, $emsql);
		$emrow = $emresult->fetch_assoc();
		$emx=$emrow["max(IDKey"];
		echo "Booking IDKey is probably $emx +1<br> Please remember to mark your Flags properly next time, and congratulations on your booking!<br>";
	}
	for($x=0;$x<$l;$x++){
		if($flags[$x]=='a'){
			$Aflag='1';
		}
		else if($flags[$x]=='f'){
			$Fflag='1';
		}
		else if($flags[$x]=='t'){
			$Tflag='1';
		}
		else if($flags[$x]=='b'){
			$Bflag='1';
		}
		else if($flags[$x]=='s'){
			$Sflag='1';
		}
	}

	$bsql="INSERT INTO bookings (DateofBooking,LastContactID,AppointmentID,IDNKey,Fflag,Aflag,Tflag,Bflag,Sflag,SalesmanID)
		VALUES('$date','$idnum','$apptID','$idnkey','$Fflag','$Aflag','$Tflag','$Bflag','$Sflag','0');";	
	if (mysqli_query($conn, $bsql)) {
		echo "New record created successfully<br>";
	} else {
		echo "Error: " . $bsql . "<br>" . mysqli_error($conn);
	}
	$lsql="SELECT * FROM shifts WHERE IDKey='$apptID'";
	//echo "$lsql<br>";
	$lresult = mysqli_query($conn, $lsql);
	$lrow = $lresult->fetch_assoc();
	$slots=$lrow["slots"]-1;
	$gsql="UPDATE shifts SET slots=$slots WHERE IDKey='$apptID'";
	if (mysqli_query($conn, $gsql)) {
	} else {
		echo "Error: " . $gsql . "<br>" . mysqli_error($conn);
	}
	
	$csql="SELECT WID,slots FROM shifts WHERE IDKey='$apptID'";
	$cresult = mysqli_query($conn, $csql);
	$row = $cresult->fetch_assoc();
	$wid=$row["WID"];
	$dsql="SELECT PayDate FROM weeks WHERE IDKey='$wid'";
	$result = mysqli_query($conn, $dsql);
	$row = $result->fetch_assoc();
	$pd=$row["PayDate"];
	echo "You're estimated paydate for this booking is: $pd <br>";
	$psql="SELECT Cpoints,Apoints FROM agents WHERE IDKey='$idnum'";
	$presult = mysqli_query($conn, $psql);
	$prow = $result->fetch_assoc();
	$cpoints=$prow["Cpoints"];
	$apoints=$prow["Apoints"];
	$cpoints+=10;
	$apoints+=10;
	$p2sql="UPDATE agents SET Cpoints=Cpoints+10,Apoints=Apoints+10 WHERE IDKey='$idnum'";
	//echo $p2sql;
	$p2result = mysqli_query($conn, $p2sql);
	echo "You've received 10 points!";
}
if($_POST["rad"]=="CB"){
	$cbtime=$_POST["cbtime"];
	$cbt=$_POST["cbt"];
	echo "Call em back! at:$cbt on $cbtime";
	$mid = " Response='CB',CBdate='$cbtime',CBTime='$cbt'";
	
	$sql3="SELECT * FROM numbers WHERE IDNKey='$idnkey'";
	$result3 =mysqli_query($conn, $sql3);
	$row3 = $result3->fetch_assoc();
	$fn=$row3["Fname"];
	$ln=$row3["Lname"];
	$pnum=$row3["Pnumber"];
	$csql="INSERT INTO reminders (Text,Date,Time,End,AgentID,IDNKey) VALUES('CB:$fn $ln-$pnum','$cbtime','$cbt','$cbt','$idnum','$idnkey')";
	if (mysqli_query($conn, $csql)) {
		echo "New record created successfully<br>";
	} else {
		echo "Error: " . $csql . "<br>" . mysqli_error($conn);
	}
}
//Output a blank line and confirm the SQL command is correct
//echo "<br>";
//echo "$start<br> $mid<br>$end<br>";
$sql= $start.$mid.$end;
//echo $sql."<br>";
//Execute the SQL command for Booking result
$result =mysqli_query($conn, $sql);

echo "<form action='/Calendar/CreateNote.php' method='post'>
		Add Another Note:
		<input type='text' value='' name='text'><br>
		<input type='submit' value='Create Note'>
		</form><br>";
?>
<br>
<form action="/AutoMail/send.php" method="post">
Which AutoMail:(requires an email address)<select name='rad'>
<?php 
$nsql="SELECT * FROM numbers WHERE IDNKey='$idnkey'";
$nresult = mysqli_query($conn, $nsql);
$nrow = $nresult->fetch_assoc();
$email=$nrow["Email"];
$msql="SELECT * FROM mail";
$mresult = mysqli_query($conn, $msql);
while($mrow = $mresult->fetch_assoc()){
	$mname=$mrow["Name"];
	$mkey=$row["IDKey"];
	echo "<option value='$mkey'>#$mkey:$mname</option>";
}
echo "</select>";
echo "<input type='number' name='email' value='$email' hidden><br>";
?>

Send:<input type="submit" value="send">
</form>
<br>
<form action="/CallCenterAgents/getnextnumber.php" method="post">
<input type="submit" value="Next Number">
</form>
<br>
<form action="/CallCenterAgents/Callbacks.php" method="post">
Manage Callbacks:<input type="submit" value="Callbacks">
</form>
<form action="/CallCenterAgents/stats.php" method="post">
Stats:<input type="submit" value="view">
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>