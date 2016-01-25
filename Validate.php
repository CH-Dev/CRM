
<?php
function validateinput($input){
	$output=str_replace("'", "", $input);
	return $output;
}
?>