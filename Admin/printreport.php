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
$mode=$_POST["mode"];
$week=$_POST["week"];
$day=$_POST["day"];
$wsql="SELECT * FROM shifts WHERE Date='$day'";
$days=1;
$lowdate=$day;
if($mode=="W"){
	$days=7;
	$wsql="SELECT * FROM weeks WHERE IDKey='$week'";
	$wresult = mysqli_query($conn, $wsql);
	$wrow = $wresult->fetch_assoc();
	$lowdate=$wrow["Start"];
	echo $lowdate;
}
$sql="SELECT * FROM agents WHERE AccountType='0' AND (DateofTermination>'$lowdate' OR DateofTermination IS NULL)";
//echo $sql;
echo "<table border='6' style='width:100%' class='sortable'>";
echo "<tr>";
echo "<td title='Agents First Name'>First Name</td>";
echo "<td title='Agents Last Name'>Last Name</td>";
echo "<td title='Agents Hours'>Hours</td>";
echo "<td title='Agents total Calls'>Calls</td>";
echo "<td title='Agents Unanswered Calls'>Unanswered</td>";
echo "<td title='Agents Calls per Answer ratio'>Answer %</td>";
echo "<td title='Agents Bookings made'>Bookings</td>";
echo "<td title='Agents Calls Per hour Average'>calls per hour</td>";
echo "<td title='Calls per booking'>Calls per Booking</td>";
echo "<td title='Hours per booking'>Hours per booking</td>";

echo "</tr>";
RowTicker("start");
$result = mysqli_query($conn, $sql);
$globalcalls=0;
$globalbookings=0;
$globalunanswered=0;
$globaldnq=0;
$globalni=0;
while($row = $result->fetch_assoc()){
	$fn=$row["Fname"];
	$ln=$row["Lname"];
	$aid=$row["IDKey"];
	$count=0;
	$csql="SELECT count(Pnumber) FROM numbers WHERE Response<>'o' AND Response<>'oo' AND AssignedUser='$aid' AND(";
	$dsql="SELECT count(IDKey) FROM ooTracker WHERE AgentID='$aid' AND(";//DEAL WITH THE ooTRACKER!!!!!
	$esql="SELECT count(Pnumber) FROM numbers WHERE Response='booked' AND AssignedUser='$aid' AND(";
	$dnqsql="SELECT count(Pnumber) FROM numbers WHERE AssignedUser='$aid' AND ( Response='DNQ' OR Response='DNC' OR Response='APP' OR Response='B') AND(";
	$nisql="SELECT count(Pnumber) FROM numbers WHERE Response<>'NI' AND AssignedUser='$aid' AND(";
	$csql="$csql DateofContact='$lowdate'";
	$dsql="$dsql DateofContact='$lowdate'";
	$esql="$esql DateofContact='$lowdate'";
	$dnqsql="$dnqsql DateofContact='$lowdate'";
	$nisql="$nisql DateofContact='$lowdate'";
	//$count+=calculatehours($lowdate,$conn,$aid);\
	$count+=calcfrompunch($lowdate,$conn,$aid);
	$ndate=$lowdate;
	for($x=0;$x<$days;$x++){//Week mode logic
		$workingdate = date_create($ndate);
		date_modify($workingdate, '+1 day');
		$ndate=date_format($workingdate, 'Y-m-d');
		$csql="$csql OR DateofContact='$ndate'";
		$dsql="$dsql OR DateofContact='$ndate'";
		$esql="$esql OR DateofContact='$ndate'";
		$dnqsql="$dnqsql OR DateofContact='$ndate'";
		$nisql="$nisql OR DateofContact='$ndate'";
		$count+=calculatehours($ndate,$conn,$aid);
		
	}
	$csql="$csql )";
	$dsql="$dsql )";
	$esql="$esql )";
	$dnqsql="$dnqsql )";
	$nisql="$nisql )";
	/*while($wrow = $wresult->fetch_assoc()){//Apply date sorting to the system
		$id=$wrow["IDKey"];
		$bsql="SELECT * FROM shifts WHERE AgentID='$aid' AND IDKey='$id'";
		$bresult = mysqli_query($conn, $bsql);
		while($brow = $bresult->fetch_assoc()){
		$date=$brow["Date"];
			$x=filter_var($brow["Start"], FILTER_SANITIZE_NUMBER_INT);
			$y=filter_var($brow["End"], FILTER_SANITIZE_NUMBER_INT);
			if($x>9){
				$y+=12;
			}
			$dif=$y-$x;
			$count+=$dif;
		}
	}*/
	//echo "$csql <br> $dsql <br>";
	$cresult= mysqli_query($conn, $csql);
	$crow = $cresult->fetch_assoc();
	
	$dresult= mysqli_query($conn, $dsql);
	$drow = $dresult->fetch_assoc();
	$unanswered=$drow["count(IDKey)"];
	$eresult= mysqli_query($conn, $esql);
	$erow = $eresult->fetch_assoc();
	$dnqresult= mysqli_query($conn, $dnqsql);
	$dnqrow = $dnqresult->fetch_assoc();
	$niresult= mysqli_query($conn, $nisql);
	$nirow = $niresult->fetch_assoc();
	$bookings=$erow["count(Pnumber)"];
	$totalcalls=$crow["count(Pnumber)"]+$drow["count(IDKey)"];
	RowTicker("next");
	$bp=0;
	$bh=0;
	$ch=0;
	$aper=0;
	$bperc=0;
	$a=$unanswered;//calculate answer %
	$b=$totalcalls;
	$c=$count;
	$d=$bookings;
	$e=$b-$a;
	if($a>0){
		if($b>0){
			$bper=$a/$b;
			$cper=$bper*100 ;
			$aper=100-$cper;
		}
	}
	if($c>0){
		if($b>0){
			$ch=$b/$c;//calls per hour
		}
	}
	if($d>0){
		$bperc=$e/$d;
	}
	if($d>0){//booking %
		if($c>0){
			$bh=$c/$d;//hours per booking
		}
		if($a>0){
			$bp=$d/$b;
			$bp=$bp*100;
		}
	}
	$dnq=$dnqrow["count(Pnumber)"];
	$ni=$nirow["count(Pnumber)"];
	$globalcalls+=$b;
	$globalbookings+=$d;
	$globalunanswered+=$a;
	$globaldnq+=$dnq;
	$globalni+=$ni;
	$ch= substr($ch,0,5);
	$bp= substr($bp,0,5);
	$bh= substr($bh,0,5);
	$aper= substr($aper,0,5);
	
	echorow($fn);
	echorow($ln);
	echovalid($count);//hours
	echovalid($totalcalls);//Calls made
	echovalid($unanswered);//Unanswered Calls
	echovalid($aper);//Answer %
	echovalid($bookings);
	echovalid($ch);
	echovalid($bperc);
	echovalid($bh);
	echo "</tr>";
}
echo "</table>";
echo "Total Calls:$globalcalls/$globalunanswered Unanswered Calls<br>Total Bookings:$globalbookings<br>Total NI:$globalni Total DNQ:$globaldnq";
?>

<?php 
function echorow($p){
	echo "<td>$p</td>";
}
function echovalid($p){
	if($p<>0){
		echorow($p);
	}
	else{
		echorow("-");
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
function calcfrompunch($day,$conn,$aid){
	$hsql="SELECT * FROM punches WHERE AgentID='$aid' AND Time LIKE '$day%' AND Type='0'";
	$hresult = mysqli_query($conn, $hsql);
	$hrow = $hresult->fetch_assoc();
	$x=substr($hrow["Time"],11,14);
	$hsql="SELECT * FROM punches WHERE AgentID='$aid' AND Time LIKE '$day%' AND Type='1' ORDER BY Time DESC";
	$hresult = mysqli_query($conn, $hsql);
	$hrow = $hresult->fetch_assoc();
	$y=substr($hrow["Time"],11,14);
	if($y==0&&$x<>0){
		$y= substr(date('Y/m/d H:i:s'),11,14);
	}
	//echo "$x , $y<br>";
	$dif=$y-$x;
	return $dif;
}
function calculatehours($day,$conn,$aid){
	$hsql="SELECT * FROM shifts WHERE AgentID='$aid' AND Date='$day'";
	$hresult = mysqli_query($conn, $hsql);
	$hrow = $hresult->fetch_assoc();
	$x=filter_var($hrow["Start"], FILTER_SANITIZE_NUMBER_INT);
	$y=filter_var($hrow["End"], FILTER_SANITIZE_NUMBER_INT);
	if($x>9){
		$y+=12;
	}
	$dif=$y-$x;
	return $dif;
}
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>