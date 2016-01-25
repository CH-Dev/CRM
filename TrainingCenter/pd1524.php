<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<iframe width="640" height="390" src="https://www.youtube.com/embed/5NxnVEXGR4Y" frameborder="0" allowfullscreen></iframe>

<br><br>
<?php 
echo "Link to the Next Page will appear below after the video ends.";
ob_end_flush();
flush();
sleep(575);
echo "<form action='/TrainingCenter/pd6524.php' method='post'>
	<input type='submit' value='Continue'>
	</form>";
?>
</body>
</html>