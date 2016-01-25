<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$idnum=$_SESSION["idnum"];
$mid=$_POST["mid"];
$sql="SELECT * FROM mail WHERE IDKey='$mid'";
$result = mysqli_query($conn, $sql);
$row=$result->fetch_assoc();
$T1=$row["T1"];
$T2=$row["T2"];
$T3=$row["T3"];
$T4=$row["T4"];
$T5=$row["T5"];
$T6=$row["T6"];
$T7=$row["T7"];
$T8=$row["T8"];
$T9=$row["T9"];
$T10=$row["T10"];
$T11=$row["T11"];
$T12=$row["T12"];
$T13=$row["T13"];
$T14=$row["T14"];
$T15=$row["T15"];
$T16=$row["T16"];
$T17=$row["T17"];
$T18=$row["T18"];
$T19=$row["T19"];
$T20=$row["T20"];
$bsql="SELECT email FROM agents WHERE IDKey='$idnum'";
$bresult = mysqli_query($conn, $bsql);
$brow=$bresult->fetch_assoc();
$email=$brow["Email"];
echo "
<script>
local SERVER = '<SMTP SERVER>'
local USERNAME = '<SMTP USERNAME>'
local PASSWORD = '<SMTP PASSWORD>'
 
local response = http.request { url = request.form.url }
-- get the last segment of the URL as a filename
local filename = string.match(request.form.url, '[^/]+$')
 
email.send {
	server=SERVER, username=USERNAME, password=PASSWORD,
	from='hello@webscript.io',
	to=$mailto,
	subject='$subject',
	text='$T1 '..'$T2'
		,
	attachments = { {
		filename = filename,
		type = response.headers['Content-Type'],
		content = response.content
	} }
}

<return>'Email sent.'
</script>
";

?>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>