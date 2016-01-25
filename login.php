<html>
<head>
<link rel="stylesheet" type="text/css" href="Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />

</head>
<body>
<meta name="viewport" content="width=device-width, initial-scale=0.5">
<?php 
session_start();

$_SESSION["servername"]="localhost";
$_SESSION["Dusername"] = "web";
$_SESSION["Dpassword"] = "";
$_SESSION["dbname"] = "pnumbers";
$_SESSION["username"]=$_POST["user"];
$_SESSION["password"]=$_POST["pass"];
$_SESSION["idnum"]=0;
$accountype='-1';
echo "<div id='loginsect'>";
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
$username=$_SESSION["username"];
$password=$_SESSION["password"];
//echo "<br>".$username.$password."connected";

	$sql = "SELECT IDKey,AccountType,Cpoints FROM agents WHERE UserName = '$username' AND Password = '$password';";
	//echo "<br>".$sql."<br>";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) ==1) {
		//echo "Logged in successfully as:$username<br>";
		while($row = $result->fetch_assoc()){
			$cpoints=$row["Cpoints"];
			
			$accountype=$row["AccountType"];
			$_SESSION["AccountType"]=$accountype;
			$_SESSION["idnum"]= $row["IDKey"];
			$idnum= $row["IDKey"];
			if($accountype==0){
				echo "Your current Point total is: $cpoints<br>";
			}
			//echo "id: ". $row["IDKey"]. "<br>";
		}
	}
	else {
		echo "Incorrect Login/Server error";
	}
	echo "<table class='invis'>";
if($accountype=="0"){//Callcenter Agents
	echo "	Please Choose an Action:
					<br>
			<form action='/CallCenterAgents/getnextnumber.php' method='post'>
		<tr><td>Begin Calling:</td><td><input type='submit' value='Next Number'>
		</form></td></tr>
			<form action='/CallCenterAgents/Callbacks.php' method='post'>
		<tr><td>Manage Callbacks:</td><td><input type='submit' value='Callbacks'>
		</form></td></tr>
			<form action='/CallCenterAgents/stats.php' method='post'>
		<tr><td>Stats:</td><td><input type='submit' value='Stats'>
		</form></td></tr>
			<form action='/CallCenterAgents/viewbookings.php' method='post'>
		<tr><td>Bookings:</td><td><input type='submit' value='My Bookings'>
		</form></td></tr>
			<form action='/Calendar/event.php' method='post'>
		<tr><td>Shifts:</td><td><input type='submit' value='Shifts'>
		</form></td></tr>
			<form action='/Calendar/startpunch.php' method='post'>
		<tr><td>punch in/out:</td><td><input type='submit' value='Timeclock'>
		</form></td></tr>
			";
}
elseif($accountype=="1"){//Salesman
	echo "<link rel='stylesheet' type='text/css'' href='Big Style.css'>";
	$date = substr(date('Y/m/d H:i:s'),0,10);
	$date=str_replace('/', '-', $date);
	if($_POST["mode"]==1){
		$date=$_POST["date"];
	}
	echo "Today's leads";
	echo "<table class='flags'>";
	echo "<tr><td class='flagbox' valign='top'><form action='/login.php' method='post'>
	<input type='text' name='user' hidden value='$username'>
	<input type='password' name='pass' hidden value='$password'>
	<input type='text' name='mode' value='1' hidden>
	<input type='date' class='updatetext' name='date'></td><td class='flagbox' valign='top'>
	<input type='submit' value='Go' class='calbutton2'></form></td></tr>
	<tr><td class='flagbox'>$date</td></tr></table>
	";
	echo "<table cellpadding='0' cellspacing='0' class='calendar'>";
	$sql="SELECT bookings.IDKey,numbers.IDNKey,numbers.Pnumber,numbers.Fname,numbers.Lname,numbers.Address,shifts.End,shifts.Start,bookings.Fflag,bookings.Aflag,bookings.Tflag,bookings.Bflag,bookings.Sflag FROM numbers INNER JOIN bookings ON numbers.IDNKey=bookings.IDNKey INNER JOIN shifts ON bookings.AppointmentID=shifts.IDKey WHERE Cancelled IS NULL AND shifts.Date='$date' AND SalesmanID='$idnum' ORDER BY shifts.Start";
	$result = mysqli_query($conn, $sql);
	while($row = $result->fetch_assoc()){
		//echo "<tr class='calendar-row'>";
		$idb=$row["IDKey"];
		$pnum=$row["Pnumber"];
		$fname=$row["Fname"];
		$lname=$row["Lname"];
		$add=$row["Address"];
		$address="<a href='https://maps.google.com?saddr=Current+Location&daddr=$add'>$add</a>";
		$end=$row["End"];
		$start=$row["Start"];
		$fflag=echocheck($row["Fflag"]);
		$aflag=echocheck($row["Aflag"]);
		$tflag=echocheck($row["Tflag"]);
		$bflag=echocheck($row["Bflag"]);
		$sflag=echocheck($row["Sflag"]);
		echo "<b>$start - $end</b><br>";
		echo "<form action='/SalesAgents/updatebookings.php' method='post'><input type='submit' class='dayviewbutton' value='$fname $lname'><input type='text' name='rad' value='$idb'hidden></form><br>";
		echo "$pnum<br>";
		echo "$address<br>";
		echo "$fflag$aflag$bflag$tflag$sflag<br><br>";
		//echo "</tr></table>";
	}
	echo "<table><link rel='stylesheet' type='text/css'' href='Big Style.css'>";
	echo "
		
			<form action='/SalesAgents/bookings.php' method='post'>
		<tr><td><input type='submit' class='salesbuttons' value='Bookings'>
		</form></td>
			<form action='/SalesAgents/quotes.php' method='post'>
		<td><input type='submit' class='salesbuttons' value='Quotes'>
		</form></td></tr><tr>
			<form action='/SalesManager/createreminder.php' method='post'>
		<td><input type='number' value='0' name='idn' hidden><input type='submit' class='salesbuttons' value='Create Reminder'></form></td>
			<form action='/Admin/Addnumber.php' method='post'>
		<td><input class='salesbuttons' type='submit' value='Create Lead'></form></td></tr>
			<form action='/SalesAgents/viewReminders.php' method='post'>
		<input type='text' name='mode' value='0' hidden>
		<tr><td><input type='submit' value='Follow Ups' class='salesbuttons'>
		</form></td>
			<form action='/ToDoList.php' method='post'>
		<input type='text' name='mode' value='0' hidden>
		<td><input type='submit' value='To Do List' class='salesbuttons'>
		</form></td></tr>
			<tr><form action='index.php' method='post'>
		<td><input type='submit' value='Logout' class='salesbuttons'></form></td></tr>
		";
	//<form action='/Calendar/event.php' method='post'>
	//<tr><td>Shifts:</td><td><input type='submit' value='Shifts'>
	//</form></td></tr>
}
elseif($accountype=="2"){//Installer
	echo "Please Choose an Action:
		<br>
		<form action='/Installer/orders.php' method='post'>
		<tr><td>View orders:</td><td><input type='submit' value='Orders'>
		</form></td></tr>
		<form action='/Calendar/startpunch.php' method='post'>
		<tr><td>Make a Punch:</td><td><input type='submit' value='Orders'>
		</form></td></tr>
		";
}
elseif($accountype=="3")//Accounting
{
	echo "</table>
				<div id='accLeft'><table class='invis'>
		<tr><td><form action='/Accounting/CloseJobs.php' method='post'>
		<input type='submit' value='Completed Jobs'>
		</form></td></tr>
		<tr><td><form action='/Accounting/OpenJobsList.php' method='post'>
		<input type='submit' value='Opened Jobs'>
		</form></td></tr>
		<tr><td><form method='post' action='/Accounting/ViewPayments.php'>
				<select name='mode'>
				<option value='0'>Both</option>
				<option value='1'>Week</option>
				<option value='2'>Agent</option>
				</select>
		<select name='week'>";
		$sql="SELECT * FROM weeks ORDER BY PayDate DESC";
		$result = mysqli_query($conn, $sql);
		while($row = $result->fetch_assoc()) {
			$wid=$row["IDKey"];
			$pay=$row["PayDate"];
			echo "<option value='$wid'>$pay</option>";
		}
		echo "</select>
			<select name='who'>";
		$sql="SELECT * FROM agents WHERE AccountType='0' OR AccountType='1' OR Comm IS NOT NULL ORDER BY DateofTermination";
		$result = mysqli_query($conn, $sql);
		while($row = $result->fetch_assoc()) {
			$id=$row["IDKey"];
			$name=$row["Fname"]." ".$row["Lname"];
			echo "<option value='$id'>$name</option>";
		}
		echo "</select>
		<input type='submit' value='View Payments'>
		</form></td></tr>
				<form action='/ToDoList.php' method='post'>
		<input type='text' name='mode' value='0' hidden>
		<tr><td><input type='submit' value='To Do List' class='salesbuttons'>
		</form></td></tr>
		<tr><td><form action='Editaccount.php' method='post'>
		<input type='submit' value='Edit Account'>
		</form></td></tr>
		<tr><td><form action='index.php' method='post'>
		<input type='submit' value='Logout'>
		</form></td></tr>
				
				</table></div>";
		echo "<div id='accRight'><table class='invis'>";
		$sql="SELECT quotes.IDNKey,quotes.IDKey,quotes.Price,quotes.DateIssued,numbers.Lname FROM quotes INNER JOIN numbers ON quotes.IDNKey=numbers.IDNKey WHERE quotes.RequestJob='1' AND (quotes.Approved='0' OR quotes.Approved IS NULL)";
		$result = mysqli_query($conn, $sql);
		while($row = $result->fetch_assoc()){
			echo "<tr><td class='invis'>";
			$price=$row["Price"];
			$date=$row["DateIssued"];
			$ln=$row["Lname"];
			$idq=$row["IDKey"];
			$IDNKey=$row["IDNKey"];
			$sql2="SELECT * FROM invoices WHERE IDNKey='$IDNKey'";
			$result2 = mysqli_query($conn, $sql2);
			$row2 = $result2->fetch_assoc();
			$Invoicekey=$row2["IDKey"];
			echo "<form action='/Accounting/viewdetails.php' method='post'><input type='submit' class='dayviewbutton' value='$ln-$price, $date'><input type='text' name='rad' value='$IDNKey'hidden><input type='text' value='0' name='mode' hidden></form>";
			echo "<form action='/Accounting/viewdetails.php' method='post'><input type='submit' class='dayviewbutton' value='Invoice#:$Invoicekey'><input type='text' name='rad' value='$IDNKey'hidden><input type='text' value='0' name='mode' hidden></form>";
			echo "</td></tr>";
		}
		echo"</table></div>";
}
elseif($accountype=="4"){//Inventory Manager
	echo "Please Choose an Action:
				<br>
				<form action='/Inventory/viewitem.php' method='post'>
		<tr><td>View Inventory:</td><td><input type='submit' value='View Items'></form></td></tr>
					<form action='/Inventory/CreateCat.php' method='post'>
		<tr><td>Create Category:</td><td><input type='submit' value='Create Category'></form></td></tr>
					<form action='/Inventory/CreateUnit.php' method='post'>
		<tr><td>Create Unit:</td><td><input type='submit' value='Create Unit'></form></td></tr>
			<form action='/Inventory/createitem.php' method='post'>
		<tr><td>Create Item:</td><td><input type='submit' value='Create Item'></form></td></tr>
				<form action='/Admin/viewpreinspects.php' method='post'>
		<tr><td>Preinspects:</td><td><input type='submit' value='PreInspect'></form></td></tr>
				<form action='/Admin/Addnumber.php' method='post'>
		<tr><td>Add Number:</td><td><input type='submit' value='Add Number'></form></td></tr>
				<form action='/Inventory/viewjobs.php' method='post'>
		<tr><td>View Jobs:</td><td><input type='submit' value='Jobs'></form></td></tr>
				
				";
}
elseif($accountype=="5"){//Cleaner
	echo "Please Choose an Action:
		<br><br>
		<form action='/Cleaners/cleanform.php' method='post'>
		<tr><td>Complete Form:</td><td><input type='submit' value='Form'>
		</form></td></tr>
		";
}
elseif($accountype=="6"){//Training Sales Manager
	echo "Please Choose an Action
			<form action='/SalesAgents/bookings.php' method='post'>
		<tr><td>View Bookings:</td><td><input type='submit' value='Bookings'></form></td></tr>
			<form action='/SalesAgents/quotes.php' method='post'>
		<tr><td>Search Quotes:</td><td><input type='submit' value='Quotes'></form></td></tr>
			<form action='/SalesManager/createreminder.php' method='post'>
		<tr><td>Create Reminder:</td><td><input type='submit' value='Create'></form></td></tr>
			<form action='/Admin/Addnumber.php' method='post'>
		<tr><td>Add Numbers Manually:</td><td><input type='submit' value='Create'></form></td></tr>
		";
}
elseif($accountype=="7"){//Training Call Center Manager
	echo "	Please Choose an Action:
					<br>
			<form action='/CallCenterAgents/getnextnumber.php' method='post'>
		<tr><td>Begin Calling:</td><td><input type='submit' value='Next Number'>
		</form></td></tr>
			<form action='/CallCenterAgents/Callbacks.php' method='post'>
		<tr><td>Manage Callbacks:</td><td><input type='submit' value='Callbacks'>
		</form></td></tr>
			<form action='/CallCenterAgents/stats.php' method='post'>
		<tr><td>Stats:</td><td><input type='submit' value='Stats'>
		</form></td></tr>
			<form action='/CallCenterAgents/viewbookings.php' method='post'>
		<tr><td>Bookings:</td><td><input type='submit' value='My Bookings'>
		</form></td></tr>
			<form action='/Calendar/event.php' method='post'>
		<tr><td>Shifts:</td><td><input type='submit' value='Shifts'>
		</form></td></tr>
			<form action='/Calendar/startpunch.php' method='post'>
		<tr><td>punch in/out:</td><td><input type='submit' value='Timeclock'>
		</form></td></tr>
			
		<form action='/CCManager/AssignNumbers.php' method='post'>
				<tr><td>Assign Numbers:</td><td>Zone:<select name='zoneZ'>";
	$zsql="SELECT DISTINCT Zone FROM numbers";
	$result = mysqli_query($conn, $zsql);
	while($row = $result->fetch_assoc()) {
		$z=$row["Zone"];
		echo "<option value='$z'>$z</option>";
	}
	
	echo "</select>
		</td><td>Agent:<select name='who'>";
	
	$ysql="SELECT IDKey,Fname FROM agents WHERE (SupervisorID IN (SELECT SupervisorID FROM agents WHERE IDKey='$idnum') AND AccountType='0') OR (SupervisorID='$idnum' OR IDKey='$idnum') GROUP BY IDKey";
	
	
	$result = mysqli_query($conn, $ysql);
	echo "<option value='$0'>All</option>";
	while($row = $result->fetch_assoc()) {
		$z=$row["Fname"];
		$id=$row["IDKey"];
		echo "<option value='$id'>$z $id</option>";
	}
	echo"</select><input type='submit' value='Assign Numbers'></form></td></tr>";		
}
elseif($accountype=="9"){//Call Center Manager
	echo "Please Choose an Action:
				<br>
				<form action='/CCManager/registerUser.php' method='post'>
		<tr><td>Register New User:</td><td><input type='submit' value='New User'>
		</form></td></tr>
				<form action='/CCManager/changeresponse.php' method='post'>
		<tr><td>Update Response:</td><td>
				<input type='number' name='p1' style='width: 3em' value='613'><input type='number' name='p2' style='width: 4em'><input type='number' name='p3' style='width: 4em'>
				<select name='resp'>
					<option value='NA'>No Answer</option><option value='booked'>booked</option><option value='DNC'>Do Not Call</option><option value='NI'>Not Interested</option><option value='o'>Uncalled</option><option value='B'>Business</option><option value='oo'>No Answer</option><option value='NS'>No Signal</option><option value='CB'>Call Back</option><option value='DNQ'>Does Not Qualify</option><option value='APP'>Apartment</option>
				</select>
		</td><td>F Age:<input type='number' name='Fage' style='width: 3em'><br>AC Age:<input type='number' name='ACage' style='width: 3em'><input type='submit' value='Modify'>
		</form></td></tr>
		<tr><td>Unassign Numbers:<form action='/CCManager/UnassignNumbers.php' method='post'>
			</td><td>Agent:<select name='who'>";
	$ysql="SELECT * FROM agents WHERE SupervisorID='$idnum'";
	$result = mysqli_query($conn, $ysql);
	while($row = $result->fetch_assoc()) {
		$z=$row["Fname"];
		$id=$row["IDKey"];
		echo "<option value='$id'>$z $id</option>";
	}
		echo "</select><input type='submit' value='Unassign Numbers'></form></td></tr>";
		echo "<form action='/Admin/Addnumber.php' method='post'>
		<tr><td>Add Customers Manually:</td><td><input type='submit' value='Create'></form></td></tr>
		<form action='/Admin/createquote.php' method='post'>
		<tr><td>Autoregister quotes:</td><td><input type='submit' value='Create'></form>
		<form action='/CCManager/DetachOO.php' method='post'>
		<tr><td>Handle OO's:</td><td><input type='submit' value='Detach'>
		</form>
				<form action='/CCManager/ResetOO.php' method='post'>
		<input type='submit' value='Reset'>
		</form></td></tr>
				<form action='/CCManager/points.php' method='post'>
		<tr><td>Adjust Points:</td><td><input type='submit' value='Points'>
		</form></td></tr>
				<form action='/ads/ads.php' method='post'>
		<tr><td>Manage Ads:</td><td><input type='submit' value='Create Ad'></form></td></tr>
				<form action='/CCManager/AssignNumbers.php' method='post'>
				<tr><td>Assign Numbers:</td><td>Zone:<select name='zoneZ'>";
	$zsql="SELECT DISTINCT Zone FROM numbers";
	$result = mysqli_query($conn, $zsql);
	while($row = $result->fetch_assoc()) {
		$z=$row["Zone"];
		echo "<option value='$z'>$z</option>";
	}
	
	echo "</select>
			</td><td>Agent:<select name='who'>";
	$ysql="SELECT * FROM agents WHERE SupervisorID='$idnum'";
	$result = mysqli_query($conn, $ysql);
	echo "<option value='$0'>All</option>";
	while($row = $result->fetch_assoc()) {
		$z=$row["Fname"];
		$id=$row["IDKey"];
		echo "<option value='$id'>$z</option>";
	}
	
	echo"</select><input type='submit' value='Assign'>
		</td></tr></form>
			<form action='/CCManager/AssignNumbers.php' method='post'>
				<tr><td>Street Mode:</td><td><input type='text' name='zoneA'>
			</td><td>Agent:<select name='who'>";
	$ysql="SELECT * FROM agents WHERE SupervisorID='$idnum'";
	$result = mysqli_query($conn, $ysql);
	echo "<option value='$0'>All</option>";
	while($row = $result->fetch_assoc()) {
		$z=$row["Fname"];
		$id=$row["IDKey"];
		echo "<option value='$id'>$z $id</option>";
	}
		echo"</select><input type='submit' value='Assign Numbers'></form></td></tr>
		";		
}
elseif($accountype=="10"){//Crew Leader
	echo "Please Choose an Action:
				<br>
		<form action='/InstallLeader/jobs.php' method='post'>
			<tr><td>View Jobs:</td><td><input type='submit' value='jobs'>
			</form><br></td></tr>
		<form action='/Calendar/event.php' method='post'>
			<tr><td>Schedule Shifts:</td><td><input type='submit' value='shifts'>
			</form><br></td></tr>
		<form action='/InstallLeader/managecrew.php' method='post'>
			<tr><td>Manage Crew:</td><td><input type='submit' value='manage'>
			</form><br></td></tr>
		";
}
elseif($accountype=="11"){//Sales Manager
	echo "Please Choose an Action:
				<br>
				<form action='/SalesManager/bookings.php' method='post'>
		<tr><td>Manage Bookings:</td><td><input type='submit' value='Bookings'></form></td></tr>
				<form action='/SalesManager/quotes.php' method='post'>
		<tr><td>Manage Quotes:</td><td><input type='submit' value='Quotes'></form></td></tr>
				<form action='/SalesManager/viewagents.php' method='post'>
		<tr><td>View Agents:</td><td><input type='submit' value='View'></form></td></tr>
				<form action='/Calendar/event.php' method='post'>
		<tr><td>View Calendar:</td><td><input type='submit' value='Shifts'></form></td></tr>
				<form action='/ads/ads.php' method='post'>
		<tr><td>Manage Ads:</td><td><input type='submit' value='Create Ad'></form></td></tr>
				<form action='/SalesManager/uploadpamphlet.php' method='post'>
		<tr><td>Manage Pamphlets:</td><td><input type='submit' value='Upload a Pamphlet'></form></td></tr>
				<form action='/Admin/Addnumber.php' method='post'>
		<tr><td>Add Numbers Manually:</td><td><input type='submit' value='Create'></form></td></tr>
				<form action='/Admin/createquote.php' method='post'>
		<tr><td>Autoregister quotes:</td><td><input type='submit' value='Create'>WARNING:AutoRegister MUST only be used after adding numbers Manually! DO NOT USE OTHERWISE</form>	</td></tr>
				<form action='/SalesManager/createreminder.php' method='post'>
		<tr><td>Create Reminder:</td><td><input type='submit' value='Create'></form></td></tr>
		";
}
elseif($accountype=="12"){//Administrator
	echo "Please Choose an Action:
				<br>
				<form action='/Admin/Reports.php' method='post'>
				<tr><td>Check Stats</td><td><input type='submit' value='Stats'></form></td></tr>
				<form action='/Admin/Addnumber.php' method='post'>
		<tr><td>Add Numbers Manually:</td><td><input type='submit' value='Create'></form></td></tr>
				<form action='/Admin/getnextnumber.php' method='post'>
		<tr><td>Register Bookings:</td><td><input type='submit' value='Create'></form></td></tr>
				<form action='/Admin/createquote.php' method='post'>
		<tr><td>Autoregister quotes:</td><td><input type='submit' value='Create'></form></td></tr>	
				<form action='/Admin/reports.php' method='post'>
		<tr><td>Check Reports:</td><td><input type='submit' value='View'></form></td></tr>	
		";
}
elseif($accountype=="99"){
	echo "
						<tr><td>Salesman</td></tr>
	<form action='/SalesAgents/bookings.php' method='post'>
	<tr><td>View Bookings:</td><td><input type='submit' value='Bookings'>
	</form></td></tr>
	<form action='/SalesAgents/quotes.php' method='post'>
	<tr><td>Search Quotes:</td><td><input type='submit' value='Quotes'>
	</form></td></tr>
						<tr><td>Sales Manager</td></tr>
	<form action='/SalesManager/bookings.php' method='post'>
	<tr><td>Manage Bookings:</td><td><input type='submit' value='Bookings'></form></td></tr>
	<form action='/SalesManager/quotes.php' method='post'>
	<tr><td>Manage Quotes:</td><td><input type='submit' value='Quotes'></form></td></tr>
	<form action='/SalesManager/viewagents.php' method='post'>
	<tr><td>View Agents:</td><td><input type='submit' value='View'></form></td></tr>

							<tr><td>Inventory Manager</td></tr>
	<form action='/Admin/viewpreinspects.php' method='post'>
	<tr><td>Preinspects:</td><td><input type='submit' value='PreInspect'></form></td></tr>
	<form action='/Inventory/viewjobs.php' method='post'>
	<tr><td>View Jobs:</td><td><input type='submit' value='Jobs'></form></td></tr>
						
						<tr><td>Crew Leader</td></tr>
			<form action='/InstallLeader/jobs.php' method='post'>
			<tr><td>View Jobs:</td><td><input type='submit' value='jobs'>
			</form><br></td></tr>
						
						<tr><td>Accounting</td></tr>
		<form action='/Accounting/accountantportal.php' method='post'>
		<tr><td>Accounting Portal:</td><td><input type='submit' value='portal'>
		</form></td></tr>
	";
}

$_SESSION["accounttype"]=$accountype;
if($accountype!=1&&$accountype!=3){
	echo "<form action='/ToDoList.php' method='post'>
	<tr><td>To Do List:</td><input type='text' name='mode' value='0' hidden>
	<td><input type='submit' value='To Do List' class='salesbuttons'>
	</form></td></tr>
		<form action='Editaccount.php' method='post'>
	<tr><td>Edit Account:</td><td><input type='submit' value='Edit'>
	</form></td></tr>
	<form action='index.php' method='post'>
	<tr><td>Logout:</td><td><input type='submit' value='Logout'>";
}
?>

</form></td></tr>
</table>

<?php //Write out the extra HUD for Call Center Managers
echo "</div>";
$date = substr(date('Y/m/d H:i:s'),0,10);
$ddate=str_replace('/', '-', $date);
if($accountype=="9"||$accountype=="99"||$accountype=="7"){
	echo "<div id='HUDsect'>";
	echo "<table class='sortable'>";
	echo "<form action='/CCManager/AssignNumbers.php' method='post'>";
	$sql="SELECT IDKey,Fname,Lname,Cpoints FROM agents WHERE (SupervisorID IN (SELECT SupervisorID FROM agents WHERE IDKey='$idnum') AND AccountType='0') OR (SupervisorID='$idnum' OR IDKey='$idnum') GROUP BY IDKey";
	$result = mysqli_query($conn, $sql);
	echo "<tr>";
	echo "<td title='Agents First Name'>FN</td>";
	echo "<td title='Agents Last Name'>LN</td>";
	echo "<td title='Agents ID number'>ID</td>";
	echo "<td title='Agents Current Points'>CP</td>";
	echo "<td title='Agents Remaining Numbers'>RNum</td>";
	echo "<td title='Agents Called Numbers'>CNum</td>";
	echo "</tr>";
	while($row = $result->fetch_assoc()){
		
		$idt=$row["IDKey"];
		$fn=$row["Fname"];
		$ln=$row["Lname"];
		$cp=$row["Cpoints"];
		$oosql="SELECT count(*) FROM ootracker WHERE AgentID='$idt' AND DateofContact='$ddate'";
		$ooresult=mysqli_query($conn, $oosql);
		$oorow=$ooresult->fetch_assoc();
		$bsql="SELECT count(*) FROM numbers WHERE Response='o' AND AssignedUser='$idt'";
		$bresult = mysqli_query($conn, $bsql);
		$brow = $bresult->fetch_assoc();
		$rnum=$brow["count(*)"];
		$csql="SELECT count(*) FROM numbers WHERE Response<>'o' AND Response<>'oo' AND AssignedUser='$idt' AND DateofContact='$ddate'";
		$cresult = mysqli_query($conn, $csql);
		$crow = $cresult->fetch_assoc();
		$cnum=$crow["count(*)"];
		$coo=$oorow["count(*)"];
		if($cnum>0||$coo>0){
			echo "<tr>";
			echo "<td><input type='radio' name='who' value='$idt'>$fn</td>";
			echorow($ln);
			echorow($idt);
			echorow($cp);
			echorow($rnum);
			echorow($cnum+$coo);
			echo "</tr>";
		}
	}
	echo "<tr>";
	echo "<td><input type='text' name='zoneA' style='width: 3em'></td>";
	echo "<td><select name='zone'>";
	$zsql="SELECT DISTINCT Zone FROM numbers";
	$result = mysqli_query($conn, $zsql);
	while($row = $result->fetch_assoc()) {
		$z=$row["Zone"];
		echo "<option value='$z'>$z</option>";
	}
	echo "</select></td>";
	echo "<td><input type='submit' value='&#10004'></form></td>";
	if($accountype=="9"){
		echo "<td><form action='/Admin/Reports.php' method='post'><input type='submit' value='Stats'></form></td>";
		echo "<td><form action='/Admin/ooCDR.php' method='post'><input type='submit' value='CDR'></form></td>";
	}
	echo "</tr>";
	echo "</table>";
	echo "</div>";
}
function echorow($p){
	echo "<td class='HUD'>$p</td>";
}
function echorowB($p){
	echo "<td class='calendar-row'>$p</td>";
}
function echocheck($p){
	if($p=='1'){
		return "&#10004";
	}else{
		return "&#10006";
	}
}
?>
<br>
<br>
<?php
if($accountype!=1&&$accountype!=3){
echo "<div id='calsect'>"; 
session_write_close();
include '/Calendar/calendar.php';
$syear = substr($date, 0,4);
$smonth = substr($date, 5,2);
//echo "Month:$smonth<br> Year:$syear<br>";
echo draw_calendar($smonth,$syear,'1');
echo "</div>";
if($accountype==1){
	
	echo "<table><form action='Editaccount.php' method='post'>
	<tr><td><input type='submit' value='Edit'>
	</form></td></tr>
	<form action='index.php' method='post'>
	<tr><td><input type='submit' value='Logout'></table>";
}
}
?>
</div>

</body>
</html>