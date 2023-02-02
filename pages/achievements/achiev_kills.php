<?php

$killtype = (isset($_GET['killtype']) ? $_GET['killtype'] : "null");
$order = (isset($_GET['order']) ? addslashes($_GET["order"]) : "ZoneLN ASC, NPCName ASC, Time ASC");

$page_title = "First Kill Achievements";
$print_buffer .= "<table class=''><tr valign=top><td>";
$print_buffer .= "<h1>Choose a category</h1><ul style='text-align:left'>";
$print_buffer .= "<li><a href=?a=achiev_kills&killtype=rare>First Rare Kills</a>";
$print_buffer .= "<li><a href=?a=achiev_kills&killtype=raid>First Raid Kills</a>";
$print_buffer .= "</ul>";

if (isset($killtype) && $killtype != "null") {
	if ($killtype == "rare") {
		$query = "
			SELECT 
				n.id AS NPCID, 
				REPLACE(REPLACE(n.`name`,'_',' '),'#','') AS NPCName, 
				z.`short_name` AS ZoneSN,
				z.`long_name` AS ZoneLN,
				SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) AS 'Time',
				CAST(SUBSTRING(d.`value`, (LENGTH(d.`value`)-3), 4) AS INT) * ((60 * 60 * 24 * 31) * 12) -- Year
				+
				CASE
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Jan%' THEN (60 * 60 * 24 * 31) * 1 -- Month 
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Feb%' THEN (60 * 60 * 24 * 31) * 2
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Mar%' THEN (60 * 60 * 24 * 31) * 3
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Apr%' THEN (60 * 60 * 24 * 31) * 4
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%May%' THEN (60 * 60 * 24 * 31) * 5
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Jun%' THEN (60 * 60 * 24 * 31) * 6
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Jul%' THEN (60 * 60 * 24 * 31) * 7
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Aug%' THEN (60 * 60 * 24 * 31) * 8
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Sep%' THEN (60 * 60 * 24 * 31) * 9
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Oct%' THEN (60 * 60 * 24 * 31) * 10
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Nov%' THEN (60 * 60 * 24 * 31) * 11
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Dec%' THEN (60 * 60 * 24 * 31) * 12 -- Month
				END 
				+
					CAST(SUBSTRING(d.`value`, (LENGTH(d.`value`)-15), 2) AS INT) * (60 * 60 * 24) -- Day
				+
					CAST(SUBSTRING(d.`value`, (LENGTH(d.`value`)-12), 2) AS INT) * (60 * 60) -- Hours
				+
					CAST(SUBSTRING(d.`value`, (LENGTH(d.`value`)-9), 2) AS INT) * 60 -- Minutes
				+
					CAST(SUBSTRING(d.`value`, (LENGTH(d.`value`)-6), 2) AS INT) -- Seconds
				AS TimeScore
			FROM
				$data_buckets_table d
			INNER JOIN $npc_types_table n ON n.id = SUBSTRING(d.`key`, INSTR(d.`key`,'-')+1)
			INNER JOIN $zones_table z ON z.short_name = SUBSTRING(d.`value`, INSTR(d.`value`,']')+1,INSTR(d.`value`,'|')-INSTR(d.`value`,']')-1)
			WHERE d.`key` LIKE 'FirstRareKill%' 
			ORDER BY $order
		";
	}
	if ($killtype == "raid") {
		$query = "
			SELECT 
				n.id AS NPCID, 
				REPLACE(REPLACE(n.`name`,'_',' '),'#','') AS NPCName, 
				z.`short_name` AS ZoneSN,
				z.`long_name` AS ZoneLN,
				SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) AS 'Time',
				CAST(SUBSTRING(d.`value`, (LENGTH(d.`value`)-3), 4) AS INT) * ((60 * 60 * 24 * 31) * 12) -- Year
				+
				CASE
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Jan%' THEN (60 * 60 * 24 * 31) * 1 -- Month 
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Feb%' THEN (60 * 60 * 24 * 31) * 2
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Mar%' THEN (60 * 60 * 24 * 31) * 3
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Apr%' THEN (60 * 60 * 24 * 31) * 4
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%May%' THEN (60 * 60 * 24 * 31) * 5
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Jun%' THEN (60 * 60 * 24 * 31) * 6
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Jul%' THEN (60 * 60 * 24 * 31) * 7
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Aug%' THEN (60 * 60 * 24 * 31) * 8
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Sep%' THEN (60 * 60 * 24 * 31) * 9
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Oct%' THEN (60 * 60 * 24 * 31) * 10
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Nov%' THEN (60 * 60 * 24 * 31) * 11
					WHEN SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) LIKE '%Dec%' THEN (60 * 60 * 24 * 31) * 12 -- Month
				END 
				+
					CAST(SUBSTRING(d.`value`, (LENGTH(d.`value`)-15), 2) AS INT) * (60 * 60 * 24) -- Day
				+
					CAST(SUBSTRING(d.`value`, (LENGTH(d.`value`)-12), 2) AS INT) * (60 * 60) -- Hours
				+
					CAST(SUBSTRING(d.`value`, (LENGTH(d.`value`)-9), 2) AS INT) * 60 -- Minutes
				+
					CAST(SUBSTRING(d.`value`, (LENGTH(d.`value`)-6), 2) AS INT) -- Seconds
				AS TimeScore
			FROM 
				$data_buckets_table d
			INNER JOIN $npc_types_table n ON n.id = SUBSTRING(d.`key`, INSTR(d.`key`,'-')+1)
			INNER JOIN $zones_table z ON z.short_name = SUBSTRING(d.`value`, INSTR(d.`value`,']')+1,INSTR(d.`value`,'|')-INSTR(d.`value`,']')-1)
			WHERE d.`key` LIKE 'FirstRaidKill%' 
			ORDER BY $order
		";
	}
	$result = db_mysql_query($query) or message_die('achiev_kills.php', 'MYSQL_QUERY', $query, mysqli_error());
	
	if ($killtype == "rare") {
			$print_buffer .= '<h1>' . "Rare Kills" . '</h1>';
		}
	if ($killtype == "raid") {
			$print_buffer .= '<h1>' . "Raid Kills" . '</h1>';
	}
	$print_buffer .= "
		<table class='display_table datatable container_div'><tr>
		<td style='font-weight:bold' align=center><u><b><a href=?a=achiev_kills&killtype=" . $killtype . "&order=NPCName>NPC</a></b></u></td>
		<td style='font-weight:bold' align=center><u><b><b><a href=?a=achiev_kills&killtype=" . $killtype . "&order=ZoneLN>Zone</a></b></u></td>
		<td style='font-weight:bold' align=right><u><b><a href=?a=achiev_kills&killtype=" . $killtype . "&order=TimeScore>Time</a></b></u></td>
	";
	while ($row = mysqli_fetch_array($result)) {
		$print_buffer .=
		"
			<tr>
				<td align=center><a href='?a=npc&id=" . $row["NPCID"] . "'>" . $row["NPCName"] . "</a></td>
				<td align=center><a href='?a=zone&name=" . $row["ZoneSN"] . "'>" . $row["ZoneLN"] . "</a></td>
				<td align=right>" . $row["Time"] . "</td>
			</tr>
		";
	}
	$print_buffer .= "</table>";
	$print_buffer .= "</td><td width=0% nowrap>";
	$print_buffer .= "</td></tr></table>";
}
?>
