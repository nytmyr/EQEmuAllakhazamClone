<?php

$name = (isset($_GET['name']) ? addslashes($_GET['name']) : '');
$order = (isset($_GET['order']) ? addslashes($_GET["order"]) : 'name');
$mode = (isset($_GET['mode']) ? addslashes($_GET["mode"]) : 'npcs');

if ($order == "ordertype") {
	$order = "raid_target DESC,rare_spawn DESC";
}

if ($use_custom_zone_list == TRUE && $name != '') {
    $ZoneNote = get_field_result("note", "SELECT note FROM $zones_table WHERE short_name='$name'");
    if (substr_count(strtolower($ZoneNote), "disabled") >= 1) {
        header("Location: index.php");
        exit();
    }
}

$page_title = get_field_result("long_name", "SELECT long_name FROM $zones_table WHERE short_name='$name'") . " ($name)";

if (!isset($name)) {
    $print_buffer .= "<script>document.location=\"zones.php\";</script>";
}

$ZoneDebug = FALSE; // this is new in 0.5.3 but undocumented, it is for world builders

$resources_menu = "<h2 class='section_header'>Resources</h2>";
$resources_menu .= "<ul>";
$resources_menu .= "<li><a href=?a=zone&name=$name&mode=npcs>" . $zone["long_name"] . " Bestiary List</a>";
if ($display_named_npcs_info == TRUE) {
    $resources_menu .= "<li><a href=?a=zone_named&name=$name&mode=npcs>" . $zone["long_name"] . " Named Mobs List</a>";
}
$resources_menu .= "<li><a href=?a=zone&name=$name&mode=items>" . $zone["long_name"] . " Equipment List </a>";
if (file_exists($maps_dir . $name . ".jpg")) {
    $resources_menu .= "<li><a href=" . $maps_url . $name . ".jpg>" . $zone["long_name"] . " Map</a>";
}
if ($display_spawn_group_info == TRUE) {
    $resources_menu .= "<li><a href=?a=zone&name=$name&mode=spawngroups>" . $zone["long_name"] . " Spawn Groups</a>";
}
$resources_menu .= "<li><a href=?a=zone&name=$name&mode=forage>" . $zone["long_name"] . " Forageable items</a>";
if ($display_task_info == TRUE) {
    $resources_menu .= "<li><a href=?a=zone&name=$name&mode=tasks>" . $zone["long_name"] . " Tasks</a>";
}
if ($allow_quests_npc == TRUE) {
    $resources_menu .= "<li><a href=$root_url" . "quests/zones.php?aZone=$name>" . $zone["long_name"] . " Quest NPCs</a>";
}
$resources_menu .= '</ul';


$print_buffer .= '<table class="display_table container_div"><tr><td>';

$print_buffer .= $resources_menu;


$query = "
    SELECT
        $zones_table.*, CAST(((($zones_table.zone_exp_multiplier/1) + (CASE WHEN $zones_table.hotzone = 1 THEN .5 ELSE 0 END)) - 1)*100 AS INT) AS Bonus
    FROM
        $zones_table
    WHERE
        $zones_table.short_name = '$name'
";
$result = db_mysql_query($query) or message_die('zones.php', 'MYSQL_QUERY', $query, mysqli_error());
$zone = mysqli_fetch_array($result);

$set_color = "black";
$hotzone = "";
if ($zone["Bonus"] < -20) {
	$setcolor = "firebrick";
}
if ($zone["Bonus"] < 0) {
	$setcolor = "red";
}
if ($zone["Bonus"] == 0) {
	$setcolor = "grey";
}
if ($zone["Bonus"] > 0) {
	$setcolor = "CornflowerBlue";
}
if ($zone["Bonus"] >= 36) {
	$setcolor = "blue";
}
if ($zone["Bonus"] >= 70) {
	$setcolor = "green";
}
if ($zone["Bonus"] >= 100) {
	$setcolor = "limegreen";
}
if ($zone["hotzone"] == 1) {
	//$setcolor = "green";
	$hotzone = "<font color=red>[HOTZONE]";
}

$print_buffer .= "<br><br><br><p><b>Connected Zones: </b>";
$querytwo = "
	SELECT DISTINCT z.zoneidnumber, z.short_name AS TargetZone, zp.zone AS ZoneFrom, zz.long_name
	FROM $zones_table z
	LEFT JOIN $zone_points_table zp ON zp.target_zone_id = z.zoneidnumber
	INNER JOIN $zones_table zz ON zp.zone = zz.short_name
	WHERE z.short_name = '$name'
	AND z.min_level = 0
	AND z.`version` = 0
	AND zp.zone != z.short_name
	AND zp.min_expansion != 127
";
$resulttwo = db_mysql_query($querytwo) or message_die('zones.php', 'MYSQL_QUERY', $querytwo, mysqli_error());
$resultcount = 1;
$num_rows = mysqli_num_rows($resulttwo);
while ($zonelinks = mysqli_fetch_array($resulttwo)) {
	if ($resultcount == 1) {
		$print_buffer .= "<a href='?a=zone&name=" . $zonelinks["ZoneFrom"] . "''>" . $zonelinks["long_name"] . "</a>";
	}
	else if ($resultcount < $num_rows) {
		$print_buffer .= ", <a href='?a=zone&name=" . $zonelinks["ZoneFrom"] . "''>" . $zonelinks["long_name"] . "</a>";
	}
	else if ($resultcount == $num_rows) {
		$print_buffer .= " and <a href='?a=zone&name=" . $zonelinks["ZoneFrom"] . "''>" . $zonelinks["long_name"] . "</a>";
	}
	++$resultcount;
}

$print_buffer .= "<br><br><p><b>Zone Experience Rate: <font color=" . $setcolor . ">" . $zone["Bonus"] . "% " . $hotzone . "</b><font color=black>";
$print_buffer .= "<table style='width:100%'><tr valign=top><td>";
$print_buffer .= "<p><b>Succor point : X (</b>" . floor($zone["safe_x"]) . ")  Y (" . floor($zone["safe_y"]) . ") Z (" . floor($zone["safe_z"]) . ")";

$req = "";
if ($zone["flag_needed"] != '') {
	$setcolor = "red";
	$req .= "[Flag Required]";
}
if ($zone["zoneidnumber"] == 39 || $zone["zoneidnumber"] == 89 || $zone["zoneidnumber"] == 105 || $zone["zoneidnumber"] == 108 || $zone["zoneidnumber"] == 128) {
	if ($show_item_as_key_req == true) {
		$setcolor = "red";
		if ($zone["zoneidnumber"] == 39) {
			$req .= "[<img src='$icons_url\item_539.png' width='25px' height='25px'/><a href=?a=item&id=6379>Hole Key</a>]";
		}
		if ($zone["zoneidnumber"] == 89) {
			$req .= "[<img src='$icons_url\item_894.png' width='25px' height='25px'/><a href=?a=item&id=20883>Trakanon Idol</a>]";
		}
		if ($zone["zoneidnumber"] == 105) {
			$req .= "[<img src='$icons_url\item_1081.png' width='25px' height='25px'/><a href=?a=item&id=20600>Key to Charasis</a>]";
		}
		if ($zone["zoneidnumber"] == 108) {
			$req .= "[<img src='$icons_url\item_1081.png' width='25px' height='25px'/><a href=?a=item&id=20884>Key of Veeshan</a>]";
		}
		if ($zone["zoneidnumber"] == 128) {
			$req .= "[<img src='$icons_url\item_1080.png' width='25px' height='25px'/><a href=?a=item&id=27265>Sleeper's Key</a>]";
		}
	} else {
		$setcolor = "red";
		$req .= "[Key Required]";
	}
}
if ($zone["min_level"] > 0) {
	$req .= "[Level " . $zone["min_level"] . "]";
	$setcolor = "red";
}

if ($zone["flag_needed"] == "" && $zone["min_level"] == 0 && $zone["zoneidnumber"] != 39 && $zone["zoneidnumber"] != 89 && $zone["zoneidnumber"] != 105 && $zone["zoneidnumber"] != 108 && $zone["zoneidnumber"] != 128) {
	$req .= "None";
	$setcolor = "green";
}

$print_buffer .= "<p><u><b><font color=" . $setcolor . ">Requirements To Enter: $req </b></u><font color=black>";

if ($mode == "npcs") {
    ////////////// NPCS
    //$query = "SELECT $npc_types_table.id,$npc_types_table.class,$npc_types_table.level,$npc_types_table.trackable,$npc_types_table.maxlevel,$npc_types_table.race,$npc_types_table.`name`,$npc_types_table.`lastname`,$npc_types_table.maxlevel,$npc_types_table.loottable_id,$npc_types_table.rare_spawn,$npc_types_table.raid_target
	//	FROM $npc_types_table,$spawn2_table,$spawn_entry_table,$spawn_group_table";
    //$query .= " WHERE $spawn2_table.zone='$name'
	//	AND $spawn_entry_table.spawngroupID=$spawn2_table.spawngroupID
	//	AND $spawn_entry_table.npcID=$npc_types_table.id
	//	AND $spawn_group_table.id=$spawn_entry_table.spawngroupID
	//	AND $spawn2_table.enabled = 1
	//	";
	$query = "SELECT $npc_types_table.id,$npc_types_table.class,$npc_types_table.level,$npc_types_table.trackable,$npc_types_table.maxlevel,$npc_types_table.race,$npc_types_table.`name`,$npc_types_table.`lastname`,$npc_types_table.maxlevel,$npc_types_table.loottable_id,$npc_types_table.rare_spawn,$npc_types_table.raid_target
		FROM $npc_types_table,$zones_table";
    $query .= " WHERE $zones_table.short_name = '$name'
				AND CAST(FLOOR($npc_types_table.`id` / 1000) AS INT) = $zones_table.zoneidnumber
		";

    if ($hide_invisible_men == TRUE) {
        //$query .= " AND $npc_types_table.race!=127 AND $npc_types_table.race!=240";
		$query .= "
			AND (($npc_types_table.`race` = 127 AND $npc_types_table.`mindmg` != 1 AND $npc_types_table.`maxdmg` != 4 AND $npc_types_table.`show_name` = 1) OR ($npc_types_table.`race` != 127))
			AND (($npc_types_table.`race` = 240 AND $npc_types_table.`mindmg` != 1 AND $npc_types_table.`maxdmg` != 4 AND $npc_types_table.`show_name` = 1) OR ($npc_types_table.`race` != 240))
			AND ($npc_types_table.`mindmg` != 0 AND $npc_types_table.`maxdmg` != 4)
			AND $npc_types_table.`level` < 81
		";
    }
    if ($group_npcs_by_name == TRUE) {
        $query .= " GROUP BY $npc_types_table.`name`, $npc_types_table.`lastname`";
    } else {
        $query .= " GROUP BY $npc_types_table.id";
    }
    $query .= " ORDER BY $order";
    $result = db_mysql_query($query) or message_die('zone.php', 'MYSQL_QUERY', $query, mysqli_error());
    if (mysqli_num_rows($result) > 0) {
        $print_buffer .= "<p>Bestiary<p><table ><tr>";
        if ($ZoneDebug == TRUE) {
            $print_buffer .= "<td class='menuh'><b><a href=?a=zone&name=$name&order=id>Id</a></b></td>";
        }
        $print_buffer .= "<td align='left'  class='menuh'><b><a href=?a=zone&name=$name&order=name>Name</a></b></td>";
        if ($ZoneDebug == TRUE) {
            $print_buffer .= "<td class='menuh' align='left'><b><a href=?a=zone&name=$name&order=loottable_id>Loottable</a></b></td>";
        }
        $print_buffer .= "<td align='left'  class='menuh'><b><a href=?a=zone&name=$name&order=level>Level Range</a></b></td>";
        $print_buffer .= "<td align='left' class='menuh'><b><a href=?a=zone&name=$name&order=race>Race</a></b></td>";
         $print_buffer .= "<td align='left' class='menuh'><b><a href=?a=zone&name=$name&order=ordertype>Type</a></b></td>";
		//$print_buffer .= "<td align='left' class='menuh'><b>Type</b></td>";

        $RowClass = "lr";
        while ($row = mysqli_fetch_array($result)) {
            if ((get_npc_name_human_readable($row["name"])) != '' && ($row["trackable"] > 0 || $trackable_npcs_only == FALSE)) {
                $print_buffer .= "<tr class='" . $RowClass . "'>";
                if ($ZoneDebug == TRUE) {
                    $print_buffer .= "<td>" . $row["id"] . "</td>";
                }
				if ($row["lastname"] != '') {
					$print_buffer .= "<td><a href=?a=npc&id=" . $row["id"] . ">" . get_npc_name_human_readable($row["name"] . " (" . $row["lastname"] . ")") . "</a>";
				} else {
					$print_buffer .= "<td><a href=?a=npc&id=" . $row["id"] . ">" . get_npc_name_human_readable($row["name"]) . "</a>";
				}
                if ($ZoneDebug == TRUE) {
                    $print_buffer .= "</td><td>" . $row["loottable_id"];
                }

                if ($row['maxlevel'] == 0) {
                    $MaxLevel = $row['level'];
                } else {
                    $MaxLevel = $row['maxlevel'];
                }

                $print_buffer .= "</td><td align=left>" . $row["level"] . " - " . $MaxLevel . " </td>";
                $print_buffer .= "<td align=left>" . $dbiracenames[$row["race"]] . "</td>";
				if ($row["rare_spawn"] == 1) {
					$print_buffer .= "<td align=left>Named/Rare</td></tr>";
				} else if ($row["raid_target"] == 1) {
					$print_buffer .= "<td align=left>Raid Target</td></tr>";
				} else {
					$print_buffer .= "<td align=left>Normal</td></tr>";
				}
                if ($RowClass == "lr") {
                    $RowClass = "dr";
                } else {
                    $RowClass = "lr";
                }
            }
        }
        $print_buffer .= "</table>";
    } else {
        $print_buffer .= "<br><b>No NPCs Found</b>";
    }
} // end npcs

if ($mode == "items") {
    $ItemsFound = 0;

    $EquiptmentTable = "<p>Equipment List<p><table border=0><tr>
		<th class='menuh'>Icon</a></th>
		<th class='menuh'><a href=?a=zone&name=$name&mode=items&order=Name>Name</a></th>
		<th class='menuh'><a href=?a=zone&name=$name&mode=items&order=itemtype>Item type</a></th>
		</tr>";

    $query = "
        SELECT
            $npc_types_table.id
        FROM
            $npc_types_table,
            $spawn2_table,
            $spawn_entry_table,
            $spawn_group_table
        WHERE
            $spawn2_table.zone = '$name'
        AND $spawn_entry_table.spawngroupID = $spawn2_table.spawngroupID
        AND $spawn_entry_table.npcID = $npc_types_table.id
        AND $spawn_group_table.id = $spawn_entry_table.spawngroupID
    ";

    if ($merchants_dont_drop_stuff == TRUE) {
        foreach ($dbmerchants AS $c) {
            $query .= " AND $npc_types_table.class!=$c";
        }
    }
    $query .= " GROUP BY $npc_types_table.id";

    $result = db_mysql_query($query) or message_die('zone.php', 'MYSQL_QUERY', $query, mysqli_error());
    $ItemsData = array();
    $RowClass = "lr";
    while ($row = mysqli_fetch_array($result)) {
        //# For each NPC in the zone...
        $query = "SELECT $items_table.*";
        $query .= " FROM $items_table,$loot_table_entries,$npc_types_table,$loot_drop_entries_table";
        if ($discovered_items_only == TRUE) {
            $query .= ",$discovered_items_table";
        }
        $query .= " WHERE $npc_types_table.id=" . $row["id"] . "
			AND $npc_types_table.loottable_id=$loot_table_entries.loottable_id
			AND $loot_table_entries.lootdrop_id=$loot_drop_entries_table.lootdrop_id
			AND $loot_drop_entries_table.item_id=$items_table.id";
        if ($discovered_items_only == TRUE) {
            $query .= " AND $discovered_items_table.item_id=$items_table.id";
        }
        $query .= " GROUP BY $items_table.id ORDER BY $items_table.`name`";

        $result2 = db_mysql_query($query) or message_die('zone.php', 'MYSQL_QUERY', $query, mysqli_error());

        if (mysqli_num_rows($result2) > 0) {
            $ItemsFound = mysqli_num_rows($result2);
        }

        while ($res = mysqli_fetch_array($result2)) {
            $ItemsData[$res["id"]] = $res;
        }
    }

    $ToolTips = "";

    $sortby = $order;
    if ($sortby == "name") {
        $sortby = "Name";
    }

    // Sort the Array by the desired field of the items table
    $tmp = Array();
    foreach ($ItemsData as &$MultiKey) {
        $tmp[] = &$MultiKey[$sortby];
    }

    array_multisort($tmp, $ItemsData);

    foreach ($ItemsData as $key => $ItemData) {
        if ($ItemData["itemtype"] > 0) {
            $ItemType = $dbitypes[$ItemData["itemtype"]];
        } else {
            if ($ItemData["bagslots"] > 0) {
                $ItemType = "Bag";
            } else {
                $ItemType = $dbitypes[$ItemData["itemtype"]];
            }
        }
        $EquiptmentTable .= "<tr class='" . $RowClass . "'>
		<td><img src='" . $icons_url . "item_" . $ItemData["icon"] . ".png' align='left'/>
		<img src='" . $images_url . "spacer_1.png' align='left'/>
		</td><td><a href=?a=item&id=" . $ItemData["id"] . " id='" . $ItemData["id"] . "'>" . $ItemData["Name"] . "</a></td>
		<td>" . $ItemType . "</td></tr>";
        if ($RowClass == "lr") {
            $RowClass = "dr";
        } else {
            $RowClass = "lr";
        }
    }

    $EquiptmentTable .= "</table>";
    if ($ItemsFound > 0) {
        $print_buffer .= $EquiptmentTable;
        $print_buffer .= $ToolTips;

    } else {
        $print_buffer .= "<br><b>No Items Found</b>";
    }

} // end items

if ($mode == "spawngroups") {
    if ($display_spawn_group_info == TRUE) {
        $print_buffer .= "";
        $query = "
            SELECT
                $spawn_group_table.*, $spawn2_table.x,
                $spawn2_table.y,
                $spawn2_table.z,
                $spawn2_table.respawntime
            FROM
                $spawn2_table,
                $spawn_group_table
            WHERE
                $spawn2_table.zone = '$name'
            AND $spawn_group_table.id = $spawn2_table.spawngroupID
            ORDER BY
                $spawn_group_table.`name` ASC
        ";
        $result = db_mysql_query($query) or message_die('zone.php', 'MYSQL_QUERY', $query, mysqli_error());

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $print_buffer .= "<li><a href=spawngroup.php?id=" . $row["id"] . ">" . $row["name"] . "</a> (" .
                    floor($row["y"]) . " / " . floor($row["x"]) . " / " . floor($row["z"]) . ") (respawn time : " .
                    translate_time($row["respawntime"]) . ")<ul>";
                $query = "
                    SELECT
                        $spawn_entry_table.npcID,
                        $npc_types_table.`name`,
                        $spawn_entry_table.chance,
                        $npc_types_table.level
                    FROM
                        $spawn_entry_table,
                        $npc_types_table
                    WHERE
                        $spawn_entry_table.npcID = $npc_types_table.id
                    AND $spawn_entry_table.spawngroupID = " . $row["id"] . "
                    ORDER BY
                        $npc_types_table.`name` ASC
                ";
                $result2 = db_mysql_query($query) or message_die('zone.php', 'MYSQL_QUERY', $query, mysqli_error());
                while ($res = mysqli_fetch_array($result2)) {
                    $print_buffer .= "<li><a href=?a=npc&id=" . $res["npcID"] . ">" . $res["name"] . "</a>, chance " . $res["chance"] . "%";
                    $print_buffer .= " (level " . $res["level"] . ")";
                }
                $print_buffer .= "</ul>";
            }
        } else {
            $print_buffer .= "<br><b>No Spawns Found</b>";
        }

    }

} // end spawngroups

if ($mode == "forage") {
    $query = "
        SELECT
            $items_table.name,
            $items_table.id
        FROM
            $items_table,
            $forage_table,
            $zones_table
        WHERE
            $items_table.id = $forage_table.itemid
        AND $forage_table.zoneid = $zones_table.zoneidnumber
        AND $zones_table.short_name = '$name'
        ORDER BY
            $items_table.name ASC
    ";
    $result = db_mysql_query($query) or message_die('zone.php', 'MYSQL_QUERY', $query, mysqli_error());
    if (mysqli_num_rows($result) > 0) {
        $print_buffer .= "<p>Forageable Items<p><table border=1><tr>
			<td class=tab_title>Name</a></td>
			</tr>";
        while ($row = mysqli_fetch_array($result)) {
            $print_buffer .= "<tr><td><a href=?a=item&id=" . $row["id"] . ">" . $row["name"] . "</a></td></tr>";
        }
        $print_buffer .= "</table>";
    } else {
        $print_buffer .= "<br><b>No Forageable Items Found</b>";
    }
} // end forage

if ($mode == "tasks") {

    if ($display_task_info == TRUE) {
        $ZoneID = get_field_result("zoneidnumber", "SELECT zoneidnumber FROM zone WHERE short_name = '$name'");
        $query = "
            SELECT
                $tasks_table.id,
                $tasks_table.title,
                $tasks_table.startzone,
                $tasks_table.minlevel,
                $tasks_table.maxlevel,
                $tasks_table.reward,
                $tasks_table.rewardid,
                $tasks_table.rewardmethod
            FROM
                $tasks_table
            WHERE
                $tasks_table.startzone = $ZoneID
            ORDER BY
                $tasks_table.id ASC
        ";

        $result = db_mysql_query($query) or message_die('zone.php', 'MYSQL_QUERY', $query, mysqli_error());

        if (mysqli_num_rows($result) > 0) {
            $print_buffer .= "<table border=0 width=100% cellpadding='5' cellspacing='0'><tr valign=top><td width=100%>";
            $print_buffer .= "<table border=0 cellpadding='5' cellspacing='0'><tr>
				<td class='menuh'>Task Name</td>
				<td class='menuh'>Task ID</td>
				<td class='menuh'>MinLevel</td>
				<td class='menuh'>MaxLevel</td>
				<td class='menuh'>Reward</td>
				";

            $RowClass = "lr";
            while ($row = mysqli_fetch_array($result)) {
                $Reward = $row["reward"];
                if ($row["rewardmethod"] == 0) {
                    if ($row["rewardid"] > 0) {
                        $ItemID = $row["rewardid"];
                        $ItemName = get_field_result("Name", "SELECT Name FROM items WHERE id = $ItemID");
                        $Reward = "<a href=?a=item&id=" . $ItemID . ">" . $ItemName . "</a>";
                    }
                }

                $print_buffer .= "<tr class='" . $RowClass . "'>
					<td><a href=task.php?id=" . $row["id"] . ">" . $row["title"] . "</a></td>
					<td align=center valign='top'>" . $row["id"] . "</td>
					<td align=center valign='top'>" . $row["minlevel"] . "</td>
					<td align=center valign='top'>" . $row["maxlevel"] . "</td>
					<td>" . $Reward . "</td>
					</tr>";
                if ($RowClass == "lr") {
                    $RowClass = "dr";
                } else {
                    $RowClass = "lr";
                }
            }
            $print_buffer .= "</table>";
            $print_buffer .= "</td><td width=0% nowrap>";
            $print_buffer .= "</td></tr></table>";
        } else {
            $print_buffer .= "<br><b>No Tasks Found</b>";
        }
    }

} // end Tasks

$print_buffer .= "</td><td>"; // end first column
$print_buffer .= "</td></tr>";
$print_buffer .= "</table>";

$print_buffer .= '</td></tr></table>';

?>