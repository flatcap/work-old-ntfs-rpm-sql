<?php

include_once 'utils.php';

function thanks_get_names()
{
	$cols = 3;
	$output = "";

	$sql = "SELECT pid,pname,nickname,email,webpage FROM rpm_person ORDER BY pname";
	$people = get_table($sql);
	$count = intval((count($people) + ($cols-1)) / $cols);

	$col1 = array_slice($people, 0,        $count);
	$col2 = array_slice($people, 1*$count, $count);
	$col3 = array_slice($people, 2*$count, $count);
	//$col4 = array_slice($people, 3*$count, $count);

	$output .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'>\n";

	for ($i = 0; $i < $count; $i++) {
		$output .= "  <tr>\n";
		$output .= "    <td>" . get_name(current($col1)) . "</td>\n";
		$output .= "    <td>" . get_name(current($col2)) . "</td>\n";
		$output .= "    <td>" . get_name(current($col3)) . "</td>\n";
		//$output .= "    <td>" . get_name(current($col4)) . "</td>\n";
		$output .= "  </tr>\n";
		next($col1);
		next($col2);
		next($col3);
		//next($col4);
	}
	$output .= "</table>\n";

	return $output;
}

function thanks_main()
{
	include 'conf.php';
	include 'menu.php';

	$connection = mysql_connect($db_host, $db_user, $db_pass)
		or die("Could not connect: " . mysql_error());

	mysql_select_db("rpm")
		or die("Could not select database<br>");

	$output = "";

	$output .= '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
	$output .= "<html>\n";
	$output .= "<head>\n";
	$output .= "<script type='text/javascript'>\n";
	$output .= "<!--\n";
	$output .= "function sf(){document.focus.html.focus();}\n";
	$output .= "// -->\n";
	$output .= "</script>\n";
	$output .= '<link rel="stylesheet" href="style.css" type="text/css">';
	$output .= '<title>Thanks</title>';
	$output .= "</head>\n";
	$output .= "<body onload='sf()'>\n";

	$output .= layout_header();
	$output .= layout_menu($_SERVER['PHP_SELF']);

	$output .= '<div class="content">';
	$output .= '<h2>Thanks</h2>';

	$thanks = thanks_get_names();
	$output .= $thanks;

	$output .= "<br>";
	$output .= "<br>";

	$output .= "<form name='focus' action='' method='post'>";
	$output .= "<textarea name='html' cols='100' rows='20'>";
	$output .= htmlentities($thanks);
	$output .= "</textarea>";
	$output .= "</form>";

	mysql_close($connection);

	$output .= '</div>';
	$output .= "</body>\n";
	$output .= "</html>\n";

	echo $output;
}


thanks_main();

?>

