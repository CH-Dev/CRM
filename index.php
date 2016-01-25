<html>
<head>
<link rel="stylesheet" type="text/css" href="Main Style.css">
<title>CoolHeat comfort CRM Index</title>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<h3>Login<button title="Click to show/hide content" type="button" onclick="if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}"style="height:10px; width:10px;background-color:white;border-style: solid;border-color:white"></button>
</h3>
<form action="login.php" method="post">
Name: <input type="text" name="user"><br>
Password: <input type="password" name="pass"><br><input type="text" name="mode" value="0" hidden>
<input type="submit" value="Login">
</form>
<br>

<div id="spoiler" style="display:none">
<h3>MonkeyMines:</h3>
<form action="/Monkey/monkeyhome.php" method="post">
<input type="text" name="user"><br>
<input type="password" name="pass">
<input type="submit" value="Login">
</form>
<img alt="monkeys" src="/Monkey/miningmonkeys.jpg" width='192' height='108'>
</div>
</body>
</html>