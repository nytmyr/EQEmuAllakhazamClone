<?php

$page_title = "Shard Vendored Items";
$print_buffer .= "<font color=grey>Not Available | <font color=green>Available<font color=white> | <font color=yellow> 1-Hour Remains<font color=white> | <font color=red> 15-Min Remains <font color=black>";
$print_buffer .= "<table class=''><tr valign=top><td>";

$itemtype = "";

$query = "
	SELECT 
		i.`id` AS ItemID,
		i.`Name` AS ItemName,
		m.`alt_currency_cost` AS ShardCost,
		(CASE
			WHEN i.`itemtype` = 0 THEN '1HS'
			WHEN i.`itemtype` = 1 THEN '2HS'
			WHEN i.`itemtype` = 2 THEN '1HP'
			WHEN i.`itemtype` = 3 THEN '1HB'
			WHEN i.`itemtype` = 4 THEN '2HB'
			WHEN i.`itemtype` = 5 THEN 'Bow'
			WHEN (i.`itemtype` = 7 OR i.`itemtype` = 19) THEN 'Thrown'
			WHEN i.`itemtype` = 8 THEN 'Shield'
			WHEN i.`itemtype` = 14 THEN 'Food'
			WHEN i.`itemtype` = 15 THEN 'Drink'
			WHEN i.`itemtype` = 21 THEN 'Potion'
			WHEN i.`itemtype` = 23 THEN 'Wind'
			WHEN i.`itemtype` = 24 THEN 'String'
			WHEN i.`itemtype` = 25 THEN 'Brass'
			WHEN i.`itemtype` = 26 THEN 'Drum'
			WHEN i.`itemtype` = 35 THEN '2HP'
			WHEN i.`itemtype` = 45 THEN 'H2H'
			WHEN (i.`itemtype` = 10 OR i.`itemtype` = 11 OR i.`itemtype` = 29 OR i.`itemtype` = 31)
				THEN i.slots
			ELSE 'NULL'
		END) AS ItemType,
		i.slots as Slots,
		n.`lastname` AS LastName,
		s.id AS ClickID,
		s.`name` as ClickName,
		ss.id AS WornID,
		ss.`name` as WornName,
		sss.id AS ProcID,
		sss.`name` as ProcName,
		ssss.id AS FocusID,
		ssss.`name` as FocusName,
		n.is_valeen_spawned AS SpawnStatus
	FROM $items_table i
	INNER JOIN $merchant_list_table m ON m.`item` = i.`id`
	INNER JOIN $npc_types_table n ON n.merchant_id = m.merchantid
	LEFT JOIN $spells_table s ON s.id = i.clickeffect
	LEFT JOIN $spells_table ss ON ss.id = i.worneffect
	LEFT JOIN $spells_table sss ON sss.id = i.proceffect
	LEFT JOIN $spells_table ssss ON ssss.id = i.focuseffect
	WHERE m.`item` > 599999
	AND m.`probability` > 0
	ORDER BY ShardCost
	";
	
$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
$print_buffer .= "
	<table class='display_table datatable container_div'><tr>
       <td style='font-weight:bold'align=left>Item</td>
       <td style='font-weight:bold'align=left>Shard Cost</td>
	    <td style='font-weight:bold'align=left>Type/Slot(s)</td>
	   <td style='font-weight:bold'align=left>Tier</td>
	   <td style='font-weight:bold'align=center>Click Effect</td>
	   <td style='font-weight:bold'align=center>Worn Effect</td>
	   <td style='font-weight:bold'align=right>Proc Effect</td>
	   <td style='font-weight:bold'align=right>Focus Effect</td>
";
while ($row = mysqli_fetch_array($result)) {
	$setcolor = "grey";
	$namechange = "";
	if ($row["SpawnStatus"] == 1) {
		$setcolor = "green";
		$namechange = "+";
	}
	if ($row["SpawnStatus"] == 2) {
		$setcolor = "yellow";
		$namechange = "+";
	}
	if ($row["SpawnStatus"] == 3) {
		$setcolor = "red";
		$namechange = "+";
	}
	if (is_numeric($row["ItemType"])) {
		$itemtype = get_slots_string($row["Slots"]);
	} else {
		$itemtype = $row["ItemType"];
	}
	$print_buffer .=
	"
		<tr>
			<td align=left><a href='?a=item&id=" . $row["ItemID"] . "'>" . $row["ItemName"] . "</a></td>
			<td align=left><font color=" . $setcolor . ">" . number_format($row["ShardCost"]) . "</td>
			<td align=left><font color=" . $setcolor . ">" . $itemtype . $namechange . "</td>
			<td align=left><font color=" . $setcolor . ">" . $row["LastName"] . "</td>
			<td align=center><a href='?a=spell&id=" . $row["ClickID"] . "'>" . $row["ClickName"] . "</a></td>
			<td align=center><a href='?a=spell&id=" . $row["WornID"] . "'>" . $row["WornName"] . "</a></td>
			<td align=right><a href='?a=spell&id=" . $row["ProcID"] . "'>" . $row["ProcName"] . "</a></td>
			<td align=right><a href='?a=spell&id=" . $row["FocusID"] . "'>" . $row["FocusName"] . "</a></td>
		</tr>
	";
}
$print_buffer .= "</table>";
$print_buffer .= "</td><td width=0% nowrap>";
$print_buffer .= "</td></tr></table>";