<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<script src="/sorttable.js"></script>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
echo "<div id='resultsect'>";
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$idnum=$_SESSION["idnum"];
$title=$_POST["title"];
$desc=$_POST["desc"]+" ";
$desc2=$_POST["desc2"]+" ";
$desc3=$_POST["desc3"]+" ";
$desc4=$_POST["desc4"]+" ";
$desc5=$_POST["desc5"]+" ";
$desc6=$_POST["desc6"]+" ";
$desc7=$_POST["desc7"]+" ";
$desc8=$_POST["desc8"]+" ";
$desc9=$_POST["desc9"]+" ";
$desc10=$_POST["desc10"]+" ";
$desc11=$_POST["desc11"]+" ";
$desc12=$_POST["desc12"]+" ";
$desc13=$_POST["desc13"]+" ";
$desc14=$_POST["desc14"]+" ";
$desc15=$_POST["desc15"]+" ";
$desc16=$_POST["desc16"]+" ";
$desc17=$_POST["desc17"]+" ";
$desc18=$_POST["desc18"]+" ";
$desc19=$_POST["desc19"]+" ";
$desc20=$_POST["desc20"]+" ";
$email=$_POST["email"];
$image1=$_POST["image1"];
$image2=$_POST["image2"];
$image3=$_POST["image3"];
$image4=$_POST["image4"];
$image5=$_POST["image5"];
$image6=$_POST["image6"];
$image7=$_POST["image7"];
$image8=$_POST["image8"];
$image9=$_POST["image9"];
$image10=$_POST["image10"];
$sect="http://www.kijiji.ca/p-post-ad.html?categoryId=".$_POST["sect"];
$url="http://www.kijiji.ca/h-".$_POST["city"];
$sql="INSERT INTO ads (URL,ADTitle,Description,Description2,Description3,Description4,Description5,Description6,Description7,Description8,Description9,Description10,Description11,Description12,Description13,Description14,Description15,Description16,Description17,Description18,Description19,Description20,PhoneNumber,Email,PosterID,Posted,sectionimage1,image2,image3,image4,image5,image6,image7,image8,image9,image10) 
		VALUES('$url','$title','$desc','$desc2','$desc3','$desc4','$desc5','$desc6','$desc7','$desc8','$desc9','$desc10','$desc11','$desc12','$desc13','$desc14','$desc15','$desc16','$desc17','$desc18','$desc19','$desc20','613-366-1200','$email','$idnum','0','$sect','$image1','$image2','$image3','$image4','$image5','$image6','$image7','$image8','$image9','$image10')";
$result = mysqli_query($conn, $sql);

?>
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>