<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<iframe width="560" height="315" src="https://www.youtube.com/embed/Gaj3Xl9vasc" frameborder="0" allowfullscreen></iframe>
<br><br>
<?php 
echo "Link to the Next Page will appear below after the video ends.";
ob_end_flush();
flush();
sleep(2116);
echo "<form action='/TrainingCenter/pd1021.php' method='post'>
	<input type='submit' value='Continue'>
	</form>";
?>
</body>
</html>