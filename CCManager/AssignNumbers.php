<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<p id="demo"></p>


<?php 
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$idnum=$_SESSION["idnum"];
$zone=$_POST["zone"];

$who=$_POST["who"];


@assign(96,$zone,$idnum,$conn,$who);
function assign($timestorun,$zone,$idnum,$conn,$who){
	$numleft=94-$timestorun;
	echo "<script type='text/javascript'>
      document.body.innerHTML = '';
      </script>";
	echo "Assigning $numleft / 95 numbers!<br>";
	ob_end_flush();
	flush();
	$timestorun--;
	if($who=='0'){
		$sql="SELECT IDKey FROM agents WHERE SupervisorID='$idnum' AND AccountType='0'";
	}
	else{
		$sql="SELECT IDKey FROM agents WHERE IDKey='$who'";
	}
	//echo $sql;
	$result = mysqli_query($conn, $sql);
	while($row = $result->fetch_assoc()) {
		$uid=$row["IDKey"];// (Length(Pnumber)='14' OR Length(Pnumber)='10') AND
		$dsql="SELECT min(IDNKey) FROM numbers WHERE  (Zone LIKE '%$zone%' OR Address LIKE '%$zone%' OR Pcode LIKE '%$zone%') AND (AssignedUser IS NULL OR AssignedUser='0') AND Response='o'";
		$dresult = mysqli_query($conn, $dsql);
		if (mysqli_num_rows($dresult)==0) {
		echo "<br>No number assigned, Out of unassigned numbers in that area!<br>";
		break;
		}
		$drow = $dresult->fetch_assoc();
		$idn=$drow["min(IDNKey)"];
		$csql="UPDATE numbers SET AssignedUser='$uid' WHERE IDNKey='$idn'";
	//	echo $csql."<br>";
		if ($conn->query($csql) === TRUE) {
   	 echo "Record updated successfully";
		} else {
  	  echo "Error updating record: " . $conn->error;
		}
	}
	if($timestorun>0){
		@assign($timestorun,$zone,$idnum,$conn,$who);
	}	
}
?>
Reloaded all agents Successfully<br>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Cancel'></form><br>";
?>
</body>
</html>