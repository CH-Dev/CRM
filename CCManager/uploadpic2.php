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
$sql="SELECT MAX(IDKey) FROM images;";
$result= mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$filen=$row["MAX(IDKey)"]+1;
$idq=$_SESSION["IDQKey"];
$sec=$_POST["security"];

//Upload stuff
$target_dir = "/HR/ID/";
$target_file = $target_dir.$filen.".png";
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	echo "The file $filen.png has been uploaded successfully.";
}
else{echo "Something broke! Do <b>NOT<b> delete local copy!<br>";}
//Database stuff
$bsql="INSERT images (IDQKey,Link,SecurityLVL)VALUES('$idq','$target_file','$sec');";
$result2= mysqli_query($conn, $bsql);
?>
Registration of the new user is now completed, please assign this user numbers as normal<br>
once they have completed basic training.<br>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>