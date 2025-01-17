<html>
<head>
<link rel="stylesheet" type="text/css" href="Main Style.css">
<title>CoolHeat comfort CRM Index</title>
<script src="/sorttable.js"></script>
<link rel="shortcut icon" href="/icon.ico" />
</head>
<body>
<?php 



/* draws a calendar */
function draw_calendar($month,$year,$sess){
	if($sess='0'){
		session_start();
	}
	$id=$_SESSION["idnum"];
	$conn = new mysqli($_SESSION["servername"], $_SESSION["Dusername"], $_SESSION["Dpassword"],$_SESSION["dbname"]);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sun','Monday','Tuesday','Wednesday','Thursday','Friday','Sat');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';
			$sqldate=$year.'-'.$month.'-'.$list_day;
			$sql="SELECT * FROM reminders WHERE Date='$sqldate' AND AgentID='$id'";
			$result = mysqli_query($conn, $sql);
			$calendar.= str_repeat('<p> </p>',1);
			while($row = $result->fetch_assoc()) {
				$time=$row["Time"];
				$end=$row["End"];
				$text=$row["Text"];
				$IDN=$row["IDNKey"];
				
				if($time!=$end){
					$display="<p class='caltext'>$text, $time-$end </p>";
				}else{
					$display="<p class='caltext'>$text, $time </p>";
				}
				if($IDN!='0'&& $IDN!=NULL){
					$display="<form action='/Calendar/Viewgeneric.php' method='post'><p class='caltext'>$display</p><input type='number'  value='$IDN' name='idnkey' hidden><input type='submit' class='calbutton' value='Go'></form>";				
				}
				
				$calendar.= str_repeat($display,1);
			}
			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}
?>
</body>
</html>