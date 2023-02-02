<?php

$itemtype = (isset($_GET['itemtype']) ? $_GET['itemtype'] : "null");
$order = (isset($_GET['order']) ? addslashes($_GET["order"]) : "ItemName ASC");

$page_title = "Item Achievements";
$print_buffer .= "<table class=''><tr valign=top><td>";
$print_buffer .= "<h1>Choose a category</h1><ul style='text-align:left'>";
$print_buffer .= "<li><a href=?a=achiev_items&itemtype=rare id='rare'>Rare Items</a>";
$print_buffer .= "<li><a href=?a=achiev_items&itemtype=bridles id='bridles'>Bridles</a>";
$print_buffer .= "<li><a href=?a=achiev_items&itemtype=wrbags id='wrbags'>Weight-Reduction Bags</a>";
$print_buffer .= "<li><a href=?a=achiev_items&itemtype=epic id='epic'>Epic Items</a>";
$print_buffer .= "<li><a href=?a=achiev_items&itemtype=tokenepic id='tokenepic'>Epic Items via An Epic Token</a>";
$print_buffer .= "</ul>";

if (isset($itemtype) && $itemtype != "null") {
	$key = "";
	if($itemtype == "rare") {
		$key = "FirstItem%";
	}
	if($itemtype == "bridles") {
		$key = "FirstBridle%";
	}
	if($itemtype == "wrbags") {
		$key = "FirstWRBag%";
	}
	if($itemtype == "epic") {
		$key = "FirstEpic%";
	}
	if($itemtype == "tokenepic") {
		$key = "FirstTokenEpic%";
	}
	$query = "
			SELECT 
				i.`id` AS ItemID,
				i.`Name` AS ItemName,
				cd.id AS CharID,
				CASE
					WHEN cd.`name` LIKE '%-deleted-%'
						THEN SUBSTRING(cd.`name`, 1, INSTR(cd.`name`, '-deleted-')-1)
					ELSE cd.`name` 
				END AS CharName,
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
			INNER JOIN $items_table i ON i.id = SUBSTRING(d.`key`, INSTR(d.`key`,'-')+1)
			INNER JOIN $character_table cd ON cd.id = SUBSTRING(d.`value`, INSTR(d.`value`,':')+1,INSTR(d.`value`,'|')-INSTR(d.`value`,':')-1)
			WHERE d.`key` LIKE '$key' 
			ORDER BY $order
	";
    $result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());

	if ($itemtype == "rare") {
	$print_buffer .= '<h1>' . "Rare Item Firsts" . '</h1>';
	}
	if ($itemtype == "bridles") {
	$print_buffer .= '<h1>' . "Bridle Firsts" . '</h1>';
	}
	if ($itemtype == "wrbags") {
	$print_buffer .= '<h1>' . "Weight-Reduction Bag Firsts" . '</h1>';
	}
	if ($itemtype == "epic") {
	$print_buffer .= '<h1>' . "Epic Item Firsts" . '</h1>';
	}
	if ($itemtype == "tokenepic") {
	$print_buffer .= '<h1>' . "Epic Item via An Epic Token Firsts" . '</h1>';
	}
	$print_buffer .= "<table class='display_table datatable container_div'><tr>";
	$print_buffer .= "<td style='font-weight:bold' align=center><u><b><a href=?a=achiev_items&itemtype=" . $itemtype . "&order=ItemName>Item</a></b></u></td>";
	$print_buffer .= "<td style='font-weight:bold' align=center><u><b><a href=?a=achiev_items&itemtype=" . $itemtype . "&order=CharName>Character</a></b></u></td>";
	$print_buffer .= "<td style='font-weight:bold' align=right><u><b><a href=?a=achiev_items&itemtype=" . $itemtype . "&order=TimeScore>Date</a></b></u></td>";
	while ($row = mysqli_fetch_array($result)) {
		$print_buffer .= "<tr class='" . $RowClass . "'>";
		$print_buffer .= "<td align=center><a href='?a=item&id=" . $row["ItemID"] . "'>" . $row["ItemName"] . "</a></td>";
		$print_buffer .= "<td align=center><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>";
		$print_buffer .= "<td style='font-weight:bold' align=right>" . $row["Time"] . "</td>";
		$print_buffer .= "</tr>";
	}
	$print_buffer .= "</table>";
	$print_buffer .= "</td><td width=0% nowrap>";
	$print_buffer .= "</td></tr></table>";
}

$print_buffer .= "</table>";
$print_buffer .= "</tr>";

?>
