<html>
<head>
<link rel="stylesheet" type="text/css" href="/Big Style.css">
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

//Upload stuff
$target_dir = "QuoteImages/";
$target_file = $target_dir.$filen.".png";
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	echo "The file $filen.png has been uploaded successfully.";
	$bsql="INSERT images (IDQKey,Link)VALUES('$idq','$target_file');";
	$result2= mysqli_query($conn, $bsql);
}
else{echo "Something broke! Do <b>NOT</b> delete local copy!<br>Bring the Picture in for manual entry!!<br>";}
//Database stuff
?>
Upload Photos<br><br>
<form action="/SalesAgents/uploadpic2.php" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload" class='picbutton'><br>
    <input type="submit" value="Upload Image" name="submit" class='calbutton'>
    <input type="number" value="<?php echo $_POST["backnum"];?>" name="backnum" hidden>
</form>
<?php 
$at=$_SESSION["AccountType"];
if($at==1){
	echo "<form action='/SalesAgents/savebookings.php' method='post'>
		<input type='text' name='mode' value='0' hidden>";
}elseif($at==11){
		echo "<form action='/SalesManager/updatequotes.php' method='post'>";
}
echo"Return to Quote:<input type='submit' value='Back' class='calbutton'>";
$idq=$_POST["backnum"];
echo "<input type='number' name='rad' value='$idq' hidden>";
?>
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
<input type='text' name='mode' value='0' hidden>
<input type='submit' value='Main Menu' class='calbutton'></form><br>";
?>
</body>
</html>