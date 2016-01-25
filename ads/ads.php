<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<script src="/sorttable.js"></script>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
Upload Pictures before filling in the rest of the form!
<form action="/ads/uploadpic.php" method="post">
<input type="submit" value="Upload Picture"><br>
</form>
<form action="createad.php" method="post">
Title:<input type="text" name="title"><br>
City:<input type="text" name="city">This is everything after "http://www.kijiji.ca/h-" on the kijii homepage<br>
of the city you want to post in<br>
Section:<input type="text" name="sect">This is everything After "http://www.kijiji.ca/p-post-ad.html?categoryId="<br>
When you manually navigate to the category you want to post in!<br>
Description:<input type="textbox" name="desc">Note each Description Field is 1 paragrah<br>
Description2:<input type="textbox" name="desc2"><br>
Description3:<input type="textbox" name="desc3"><br>
Description4:<input type="textbox" name="desc4"><br>
Description5:<input type="textbox" name="desc5"><br>
Description6:<input type="textbox" name="desc6"><br>
Description7:<input type="textbox" name="desc7"><br>
Description8:<input type="textbox" name="desc8"><br>
Description9:<input type="textbox" name="desc9"><br>
Description10:<input type="textbox" name="desc10"><br>
Description1:<input type="textbox" name="desc11"><br>
Description12:<input type="textbox" name="desc12"><br>
Description13:<input type="textbox" name="desc13"><br>
Description14:<input type="textbox" name="desc14"><br>
Description15:<input type="textbox" name="desc15"><br>
Description16:<input type="textbox" name="desc16"><br>
Description17:<input type="textbox" name="desc17"><br>
Description18:<input type="textbox" name="desc18"><br>
Description19:<input type="textbox" name="desc19"><br>
Description20:<input type="textbox" name="desc20"><br>
<select name="image1">
<option value='0'>None</option>
<?php 
session_start();
$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql="SELECT * FROM adimages;";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$id=$row["IDKey"];
	$name=$row["Name"];
	echo "<option value='$id'>$name</option>";
}
?>
</select>
<select name="image2">
<option value='0'>None</option>
<?php 
$sql="SELECT * FROM adimages;";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$id=$row["IDKey"];
	$name=$row["Name"];
	echo "<option value='$id'>$name</option>";
}
?>
</select>
<select name="image3">
<option value='0'>None</option>
<?php 
$sql="SELECT * FROM adimages;";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$id=$row["IDKey"];
	$name=$row["Name"];
	echo "<option value='$id'>$name</option>";
}
?>
</select>
<select name="image4">
<option value='0'>None</option>
<?php 
$sql="SELECT * FROM adimages;";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$id=$row["IDKey"];
	$name=$row["Name"];
	echo "<option value='$id'>$name</option>";
}
?>
</select>
<select name="image5">
<option value='0'>None</option>
<?php 
$sql="SELECT * FROM adimages;";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$id=$row["IDKey"];
	$name=$row["Name"];
	echo "<option value='$id'>$name</option>";
}
?>
</select><br>
<select name="image6">
<option value='0'>None</option>
<?php 
$sql="SELECT * FROM adimages;";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$id=$row["IDKey"];
	$name=$row["Name"];
	echo "<option value='$id'>$name</option>";
}
?>
</select>
<select name="image7">
<option value='0'>None</option>
<?php 
$sql="SELECT * FROM adimages;";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$id=$row["IDKey"];
	$name=$row["Name"];
	echo "<option value='$id'>$name</option>";
}
?>
</select>
<select name="image8">
<option value='0'>None</option>
<?php 
$sql="SELECT * FROM adimages;";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$id=$row["IDKey"];
	$name=$row["Name"];
	echo "<option value='$id'>$name</option>";
}
?>
</select>
<select name="image9">
<option value='0'>None</option>
<?php 
$sql="SELECT * FROM adimages;";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$id=$row["IDKey"];
	$name=$row["Name"];
	echo "<option value='$id'>$name</option>";
}
?>
</select>
<select name="image10">
<option value='0'>None</option>
<?php 
$sql="SELECT * FROM adimages;";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()) {
	$id=$row["IDKey"];
	$name=$row["Name"];
	echo "<option value='$id'>$name</option>";
}
?>
</select>
email:<input type="text" name="email"><br>
Submit:<input type="submit" value="Submit">
</form>
<?php 
$pass=$_SESSION["password"];$user=$_SESSION["username"];
echo "<form action='/login.php' method='post'>	<input type='text' name='user' value='$user' hidden><br> <input type='text' name='pass' value='$pass' hidden><br>
Back:<input type='submit' value='Main Menu'></form><br>";
?>
</body>
</html>