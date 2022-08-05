<?php
$page_title = "Current Hot Zones";
$print_buffer .= "<table class=''><tr valign=top><td>";

$query = "
			SELECT 
			short_name, long_name, hotzone_range
			, (CASE
					WHEN hotzone_range = 'newbie' THEN 1
					WHEN hotzone_range = '5 to 15' THEN 2
					WHEN hotzone_range = '16 to 25' THEN 3
					WHEN hotzone_range = '26 to 35' THEN 4
					WHEN hotzone_range = '36 to 45' THEN 5
					WHEN hotzone_range = '46 to 55' THEN 6
					WHEN hotzone_range = '56 to 60' THEN 7
					WHEN hotzone_range = '61 to 65' THEN 8
					ELSE 0
				END) as hotzonescore
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
			<td align=center>" . $row["hotzone_range"] . "</td>
		</tr>
	";
}

$print_buffer .= "</table>";
$print_buffer .= "</td><td width=0% nowrap>";
$print_buffer .= "</td></tr></table>";
?>