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

$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$start="UPDATE numbers SET DateofContact='$date',";//Setup our SQL template for easy access
$end=" WHERE AssignedUser='$idnum' AND IDNKey='$idnkey'";
$mid="o";
//Handle Furnace and AC Ages
$submit=false;
$fage=$_POST["fage"];
$acage=$_POST["acage"];
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
//Submit Comments to the Database
$comment=$_POST["comment"];
$comment2=$_POST["comment2"];
$mid=" Comments1='$comment', Comments2='$comment2'";
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
}
if($_POST["rad"]=="NI"){
	echo "Not interested!";
	$mid= " Response='NI'";
}
if($_POST["rad"]=="DNQ"){
	echo "Not Qualified!";
	$mid= " Response='DNQ'";
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
	
	$l=count($flags);
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
	}
	
	$bsql="INSERT INTO bookings (DateofBooking,LastContactID,AppointmentID,Comments1,Comments2,IDNKey,Fflag,Aflag,Tflag,Bflag,SalesmanID)
		VALUES('$date','$idnum','$apptID','$comment','$comment2','$idnkey','$Fflag','$Aflag','$Tflag','$Bflag','0');";	
	if (mysqli_query($conn, $bsql)) {
		echo "New record created successfully<br>";
	} else {
		echo "Error: " . $bsql . "<br>" . mysqli_error($conn);
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
	$slots=$row["slots"]-1;
	$gsql="UPDATE shifts SET slots='$slots' WHERE IDKey='$apptID'";
	$gresult = mysqli_query($conn, $gsql);
}
if($_POST["rad"]=="CB"){
	$cbtime=$_POST["cbtime"];
	$cbt=$_POST["cbt"];
	echo "Call em back! at:$cbtime";
	$mid = " Response='CB',CBdate='$cbtime',CBTime='$cbt'";
}
//Output a blank line and confirm the SQL command is correct
echo "<br>";
$sql= $start.$mid.$end;
//echo $sql."<br>";
//Execute the SQL command for Booking result
$result =mysqli_query($conn, $sql);
?>
<br>
<br>
<form action="/Admin/getnextnumber.php" method="post">
<input type="submit" value="Next Number">
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>