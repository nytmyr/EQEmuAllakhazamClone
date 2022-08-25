<?php
$page_title = "Current Hot Zones";
$print_buffer .= "<b>Hot Zones reset weekly on Monday at 12:00AM Midnight CST</b>";

date_default_timezone_set("America/Chicago");
$timetoreset = strtotime('next Monday');
$print_buffer .= "<br><br><font color=dodgerblue>Reset in: " . dateDifference($timetoreset, time() + 6) . "<font color=black>";

$print_buffer .= "<table class=''><tr valign=top><td>";

$query = "
			SELECT 
			short_name, long_name, chosen_range,
			(CASE
					WHEN chosen_range LIKE '%Raid%' THEN 9
					WHEN chosen_range LIKE '%61 to 65%' THEN 8
					WHEN chosen_range LIKE '%56 to 60%' THEN 7
					WHEN chosen_range LIKE '%46 to 55%' THEN 6
					WHEN chosen_range LIKE '%36 to 45%' THEN 5
					WHEN chosen_range LIKE '%26 to 35%' THEN 4
					WHEN chosen_range LIKE '%16 to 25%' THEN 3
					WHEN chosen_range LIKE '%5 to 15%' THEN 2
					WHEN chosen_range LIKE '%Newbie%' THEN 1
					WHEN chosen_range LIKE '%City%' THEN 0
					ELSE 0
				END) as hotzonescore,
			chosen_range as hotzone_title
			FROM $zones_table 
			WHERE hotzone != 0 
			ORDER BY hotzonescore ASC
";

$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
$columns = mysqli_num_fields($result);

$print_buffer .= 
"
	<table class='display_table datatable container_div'><tr>
	<td style='font-weight:bold' align=left><u><b>Zone Name</u></b></td>
	<td style='font-weight:bold' align=center><u><b>Level Range</u></b></td>
";

while ($row = mysqli_fetch_array($result)) {
	$print_buffer .=
	"
		<tr>
			<td><a href='?a=zone&name=" . $row["short_name"] . "''>" . $row["long_name"] . "</a></td>
			<td align=center>" . $row["hotzone_title"] . "</td>
		</tr>
	";
}

$print_buffer .= "</table>";
$print_buffer .= "</td><td width=0% nowrap>";
$print_buffer .= "</td></tr></table>";

function dateDifference($startdate, $enddate)
{
    $d1 = $startdate;
    $d2 = $enddate;

    $diff_secs = abs($d1 - $d2);

    $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	
	$days = floor($diff_secs / (3600 * 24));
	$diff_secs = $diff_secs - ($days * (3600 * 24));
	$hours = floor($diff_secs / 3600);
	$diff_secs = $diff_secs - ($hours * (3600));
	$minutes = floor($diff_secs / 60);
	$diff_secs = $diff_secs - ($minutes * (60));
	$seconds = $diff_secs;
    
	$remain = "" . $days . " days, " . $hours . " hours, " . $minutes . " minutes and " . $seconds . " seconds.";
	return $remain;
}
?>