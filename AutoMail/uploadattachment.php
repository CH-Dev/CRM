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
$sql="SELECT MAX(IDKey) FROM mail;";
$result= mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$filen=$row["MAX(IDKey)"]+1;
$mid=$_POST["mailid"];

$target_dir = "/AutoMail/Attachments/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$finaltarget="$target_dir$filen.$imageFileType";
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $finaltarget)) {
	echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	$bsql="INSERT mailimage (IDMKey,Link)VALUES('$mid','$finaltarget');";
	$result2= mysqli_query($conn, $bsql);
} else {
	echo "Sorry, there was an error uploading your file.";
}

echo "<form action='/AutoMail/uploadattachment.php' method='post' enctype='multipart/form-data'>
Choose a file:<input type='file' name='file' id='fileToUpload'>
<input type='text' value='$mid' name='mailid' hidden>
<input type='submit' value='Upload'>
</form>";
?>
<?php
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>