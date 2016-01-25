<html>
<head>
<link rel="stylesheet" type="text/css" href="/Main Style.css">
<title>CoolHeat comfort CRM</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<p id="xout"></p>
<br><br>
<?php 
x(1);
function x($int){
	ob_end_flush();
	flush();
	sleep($int);
	echo "<script>window.alert($int);</script>";
	x($int+1);
}


echo "<form action='/TrainingCenter/pd1524.php' method='post'>
	<input type='submit' value='Continue'>
	</form>";
?>
</body>
</html>