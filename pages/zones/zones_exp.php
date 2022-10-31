<?php

$order = (isset($_GET['order']) ? addslashes($_GET["order"]) : "Bonus DESC, long_name");
$zonetype = (isset($_GET['zonetype']) ? $_GET['zonetype'] : "null");

$page_title = "Zone Experience Rates (Including Hot Zone Bonuses)";
$print_buffer .= "<table class=''><tr valign=top><td>";
$print_buffer .= "<li><a href=?a=zones_exp&zonetype=City id='city'>Cities</a>";
$print_buffer .= "<li><a href=?a=zones_exp&zonetype=Newbie id='raid'>Newbie</a>";
$print_buffer .= "<li><a href=?a=zones_exp&zonetype=5%20to%2015 id='raid'>5 to 15</a>";
$print_buffer .= "<li><a href=?a=zones_exp&zonetype=16%20to%2025 id='raid'>16 to 25</a>";
$print_buffer .= "<li><a href=?a=zones_exp&zonetype=26%20to%2035 id='raid'>26 to 35</a>";
$print_buffer .= "<li><a href=?a=zones_exp&zonetype=36%20to%2045 id='raid'>36 to 45</a>";
$print_buffer .= "<li><a href=?a=zones_exp&zonetype=46%20to%2055 id='raid'>46 to 55</a>";
$print_buffer .= "<li><a href=?a=zones_exp&zonetype=56%20to%2060 id='raid'>56 to 60</a>";
$print_buffer .= "<li><a href=?a=zones_exp&zonetype=61%20to%2065 id='raid'>61 to 65</a>";
$print_buffer .= "<li><a href=?a=zones_exp&zonetype=Raid id='raid'>Raid Zones</a>";

if (isset($zonetype) && $zonetype != "null") {
	$query = "
				SELECT z.short_name, z.long_name, z.zoneidnumber, z.flag_needed, z.min_level, z.hotzone, z.hotzone_range
				, CAST((((z.zone_exp_multiplier/1) + (CASE WHEN z.hotzone = 1 THEN .5 ELSE 0 END)) - 1)*100 AS INT) AS Bonus
				, CAST((((z.new_zem/1) + (CASE WHEN z.hotzone = 1 THEN .5 ELSE 0 END)) - 1)*100 AS INT) AS NewBonus
				, (CASE
						WHEN hotzone_range LIKE '%City%' THEN 0
						WHEN hotzone_range LIKE '%Newbie%' THEN 1
						WHEN hotzone_range LIKE '%5 to 15%' THEN 2
						WHEN hotzone_range LIKE '%16 to 25%' THEN 3
						WHEN hotzone_range LIKE '%26 to 35%' THEN 4
						WHEN hotzone_range LIKE '%36 to 45%' THEN 5
						WHEN hotzone_range LIKE '%46 to 55%' THEN 6
						WHEN hotzone_range LIKE '%56 to 60%' THEN 7
						WHEN hotzone_range LIKE '%61 to 65%' THEN 8
						WHEN hotzone_range LIKE '%Raid%' THEN 9
						ELSE 0
					END) as hotzonescore
				FROM $zones_table z
				WHERE z.min_status = 0
				AND z.`expansion`< 99
				AND z.hotzone_range LIKE '%$zonetype%'
				ORDER BY $order
	";
	
	$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
	$columns = mysqli_num_fields($result);
	
	$print_buffer .= 
	"
		<table class='display_table datatable container_div'><tr>
		<td style='font-weight:bold' align=left><u><b><a href=?a=zones_exp&zonetype=" . rawurlencode($zonetype) . "&order=long_name>Zone Name</a></b></u></td>
		<td style='font-weight:bold' align=center><u><b>Level Range</u></b></td>
		<td style='font-weight:bold' align=center><a href=?a=zones_exp&zonetype=" . rawurlencode($zonetype) . "&order=Bonus%20DESC>Bonus</a></b></u></td>
		<td style='font-weight:bold' align=center><u><b>Pre-Reqs</u></b></td>
	";
	
	while ($row = mysqli_fetch_array($result)) {
		$setcolor = "white";
		$hotzone = "";
		$req = "";
		if ($row["flag_needed"] > 0) {
			$req .= "<img src='$icons_url\item_flag.png' width='15px' height='15px'/>";
		}
		if ($row["zoneidnumber"] == 39 || $row["zoneidnumber"] == 89 || $row["zoneidnumber"] == 105 || $row["zoneidnumber"] == 108 || $row["zoneidnumber"] == 128) {
			$req .= "<img src='$icons_url\item_1077.png' width='25px' height='15px'/>";
		}
		if ($row["min_level"] > 0) {
			$req .= "L" . $row["min_level"];
		}
		
		if ($row["Bonus"] < -20) {
			$setcolor = "firebrick";
		}
		else if ($row["Bonus"] < 0) {
			$setcolor = "red";
		}
		else if ($row["Bonus"] == 0) {
			$setcolor = "grey";
		}
		else if ($row["Bonus"] >= 100) {
			$setcolor = "limegreen";
		}
		else if ($row["Bonus"] >= 70) {
			$setcolor = "green";
		}
		else if ($row["Bonus"] >= 36) {
			$setcolor = "blue";
		}
		else if ($row["Bonus"] > 0) {
			$setcolor = "CornflowerBlue";
		}
		if ($row["NewBonus"] <= -50) {
			$newcolor = "firebrick";
		}
		else if ($row["NewBonus"] <= -20) {
			$newcolor = "red";
		}
		else if ($row["NewBonus"] < 0) {
			$newcolor = "coral";
		}
		else if ($row["NewBonus"] >= 75) {
			$newcolor = "limegreen";
		}
		else if ($row["NewBonus"] >= 45) {
			$newcolor = "green";
		}
		else if ($row["NewBonus"] >= 25) {
			$newcolor = "blue";
		}
		else if ($row["NewBonus"] >= 0) {
			$newcolor = "CornflowerBlue";
		}
		if ($row["hotzone"] == 1) {
			//$setcolor = "green";
			$hotzone = "<font color=red>[HOTZONE]";
		}
		
		$print_buffer .=
		"
			<tr>
				<td><a href='?a=zone&name=" . $row["short_name"] . "''>" . $row["long_name"] . " " . $hotzone . "</a></td>
				<td align=center>" . $zonetype . "</td>
				<td align=center><font color=" . $setcolor . ">" . $row["Bonus"] . "%</td>
				<td align=center><font color=" . $setcolor . ">$req</td>
			</tr>
		";
	}
	
	$print_buffer .= "</table>";
	$print_buffer .= "</td><td width=0% nowrap>";
	$print_buffer .= "</td></tr></table>";
}
?>