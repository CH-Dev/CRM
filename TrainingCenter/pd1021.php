<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<iframe width="854" height="510" src="https://www.youtube.com/embed/D5hMN_XkPQA" frameborder="0" allowfullscreen></iframe>

<br><br>
<?php 
echo "Link to the Next Page will appear below after the video ends.";
ob_end_flush();
flush();
sleep(250);
echo "<form action='/TrainingCenter/pd1321.php' method='post'>
	<input type='submit' value='Continue'>
	</form>";
?>
</body>
</html>