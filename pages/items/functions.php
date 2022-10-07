<?php
/**
 * Created by PhpStorm.
 * User: cmiles
 * Date: 9/18/2016
 * Time: 4:45 PM
 */

function return_where_item_dropped_count($item_id){

    global
        $npc_types_table,
        $spawn2_table,
        $zones_table,
        $loot_table_entries,
        $loot_drop_entries_table,
        $spawn_entry_table,
        $merchants_dont_drop_stuff,
        $item_add_chance_to_drop,
		$item_add_chance_to_drop_as_rarity,
        $ignore_zones;
	$original_item_id = $item_id;
	
	if ($item_id >= 800000) {
		$item_id = $item_id - 800000;
	}
	else if ($item_id >= 600000) {
		$item_id = $item_id - 600000;
	}

    $is_item_dropped = get_field_result("item_id", 
		"
		SELECT item_id 
		FROM $loot_drop_entries_table 
			INNER JOIN $loot_table_entries on $loot_table_entries.lootdrop_id = $loot_drop_entries_table.lootdrop_id 
			INNER JOIN $npc_types_table ON $npc_types_table.loottable_id = $loot_table_entries.loottable_id 
		WHERE item_id=$item_id
			AND $loot_drop_entries_table.chance > 0 
		LIMIT 1
		");

    $return_buffer = "";
    if($is_item_dropped) {
        $return_buffer .= "<tr>";
		if ($original_item_id >= 600000) {
			$return_buffer .= "<td><h2 class='section_header'>The non-Vegas version of this item is dropped in zones</h2>";
		} else {
			$return_buffer .= "<td><h2 class='section_header'>This item is dropped in zones</h2>";
		}
        $return_buffer .= "</tr>";
        $return_buffer .= "<tr id='npc_dropped_view'>";
        $return_buffer .= "<td><ul><li><a onclick='npc_dropped_view(" . $item_id . ")'>Click to View</a></li></ul></td>";
        $return_buffer .= "</tr>";

        return $return_buffer;
    }

    return;
}

/* npcs dropping this (Very Heavy Query)*/
function return_where_item_dropped($item_id, $via_ajax = 0)
{
    global
            $npc_types_table,
            $spawn2_table,
            $zones_table,
            $loot_table_entries,
            $loot_drop_entries_table,
            $spawn_entry_table,
            $merchants_dont_drop_stuff,
            $item_add_chance_to_drop,
			$item_add_chance_to_drop_as_rarity,
            $ignore_zones,
			$show_all_item_drops;
	$original_item_id = $item_id;
	
	if ($item_id >= 800000) {
		$item_id = $item_id - 800000;
	}
	else if ($item_id >= 600000) {
		$item_id = $item_id - 600000;
	}
	
    $is_item_dropped = get_field_result("item_id", "SELECT item_id FROM $loot_drop_entries_table WHERE item_id=$item_id LIMIT 1");

    if($is_item_dropped) {
		if ($item_add_chance_to_drop_as_rarity == TRUE) {
			if ($show_all_item_drops != TRUE) {
				$query = "
					SELECT
						DISTINCT $npc_types_table.id,
						$npc_types_table.`name`,
						$spawn2_table.zone,
						$zones_table.long_name,
						$loot_table_entries.multiplier,
						$loot_table_entries.probability,
						CASE
							WHEN $loot_drop_entries_table.chance BETWEEN 0 AND 5
							THEN 'Ultra Rare'
							WHEN $loot_drop_entries_table.chance BETWEEN 6 and 15
							THEN 'Very Rare'
							WHEN $loot_drop_entries_table.chance BETWEEN 16 AND 25
							THEN 'Rare'
							WHEN $loot_drop_entries_table.chance BETWEEN 26 and 49
							THEN 'Uncommon'
							WHEN $loot_drop_entries_table.chance BETWEEN 50 AND 75
							THEN 'Common'
							WHEN $loot_drop_entries_table.chance BETWEEN 75 AND 99
							THEN 'Very Common'
							WHEN $loot_drop_entries_table.chance >= 100
							THEN 'Always'
							END AS chance
					FROM
						$npc_types_table,
						$spawn2_table,
						$spawn_entry_table,
						$loot_table_entries,
						$loot_drop_entries_table,
						$zones_table
					WHERE
						$npc_types_table.id = $spawn_entry_table.npcID
					AND $spawn_entry_table.spawngroupID = $spawn2_table.spawngroupID
					AND $npc_types_table.loottable_id = $loot_table_entries.loottable_id
					AND $loot_table_entries.lootdrop_id = $loot_drop_entries_table.lootdrop_id
					AND $loot_drop_entries_table.item_id = $item_id
					AND $item_id < 600000
					AND $zones_table.short_name = $spawn2_table.zone
					AND $zones_table.min_status = 0
					";
			} else {
				$query = "
					SELECT
						$npc_types_table.id,
						$npc_types_table.`name`,
						$zones_table.short_name,
						$zones_table.long_name,
						$loot_table_entries.multiplier,
						$loot_table_entries.probability,
						CASE
							WHEN $loot_drop_entries_table.chance BETWEEN 0 AND 5
							THEN 'Ultra Rare'
							WHEN $loot_drop_entries_table.chance BETWEEN 6 and 15
							THEN 'Very Rare'
							WHEN $loot_drop_entries_table.chance BETWEEN 16 AND 25
							THEN 'Rare'
							WHEN $loot_drop_entries_table.chance BETWEEN 26 and 49
							THEN 'Uncommon'
							WHEN $loot_drop_entries_table.chance BETWEEN 50 AND 75
							THEN 'Common'
							WHEN $loot_drop_entries_table.chance BETWEEN 75 AND 99
							THEN 'Very Common'
							WHEN $loot_drop_entries_table.chance >= 100
							THEN 'Always'
						END AS chance
					FROM
						$npc_types_table,
						loottable,
						$loot_table_entries,
						$loot_drop_entries_table,
						$zones_table
					WHERE
						$npc_types_table.loottable_id = loottable.id
					AND loottable.id = $loot_table_entries.loottable_id
					AND $loot_table_entries.lootdrop_id = $loot_drop_entries_table.lootdrop_id
					AND $loot_drop_entries_table.item_id = $item_id
					AND $zones_table.zoneidnumber = CAST(FLOOR($npc_types_table.id / 1000) AS INT)
					AND $loot_drop_entries_table.chance > 0
					AND $loot_table_entries.probability > 0
					AND $zones_table.min_status = 0
				";
			}
		} else {
			if ($show_all_item_drops != TRUE) {

				$query = "
				    SELECT
				        $npc_types_table.id,
				        $npc_types_table.`name`,
				        $spawn2_table.zone,
				        $zones_table.long_name,
				        $loot_table_entries.multiplier,
				        $loot_table_entries.probability,
				        $loot_drop_entries_table.chance
				    FROM
				        $npc_types_table,
				        $spawn2_table,
				        $spawn_entry_table,
				        $loot_table_entries,
				        $loot_drop_entries_table,
				        $zones_table
				    WHERE
				        $npc_types_table.id = $spawn_entry_table.npcID
				    AND $spawn_entry_table.spawngroupID = $spawn2_table.spawngroupID
				    AND $npc_types_table.loottable_id = $loot_table_entries.loottable_id
				    AND $loot_table_entries.lootdrop_id = $loot_drop_entries_table.lootdrop_id
				    AND $loot_drop_entries_table.item_id = $item_id
				    AND $zones_table.short_name = $spawn2_table.zone
					AND $zones_table.min_status = 0
				";
			} else {
				$query = "
					SELECT
						$npc_types_table.id,
						$npc_types_table.`name`,
						$zones_table.short_name,
						$zones_table.long_name,
						$loot_table_entries.multiplier,
						$loot_table_entries.probability,
						$loot_drop_entries_table.chance
					FROM
						$npc_types_table,
						loottable,
						$loot_table_entries,
						$loot_drop_entries_table,
						$zones_table
					WHERE
						$npc_types_table.loottable_id = loottable.id
					AND loottable.id = $loot_table_entries.loottable_id
					AND $loot_table_entries.lootdrop_id = $loot_drop_entries_table.lootdrop_id
					AND $loot_drop_entries_table.item_id = $item_id
					AND $zones_table.zoneidnumber = CAST(FLOOR($npc_types_table.id / 1000) AS INT)
					AND $loot_drop_entries_table.chance > 0
					AND $loot_table_entries.probability > 0
					AND $zones_table.min_status = 0
				";
			}
		}
        if ($merchants_dont_drop_stuff == TRUE) {
            $query .= " AND $npc_types_table.merchant_id=0";
        }
        foreach ($ignore_zones AS $zid) {
            $query .= " AND $zones_table.short_name!='$zid'";
        }
        $query .= " GROUP BY $npc_types_table.id ORDER BY $zones_table.long_name ASC";
        $result = db_mysql_query($query) or message_die('item.php', 'MYSQL_QUERY', $query, mysqli_error());
        if (mysqli_num_rows($result) > 0) {
            $return_buffer = "";
            if($via_ajax == 0){
                $return_buffer .= "<tr>";
				if ($original_item_id >= 600000) {
					$return_buffer .= "<td><h2 class='section_header'>The non-Vegas version of this item is dropped in zones</h2>";
				} else {
					$return_buffer .= "<td><h2 class='section_header'>This item is dropped in zones</h2>";
				}
                #$return_buffer .= "<td><h2 class='section_header'>This item is dropped in zones</h2>";
            }
            $current_zone_iteration = "";
            while ($row = mysqli_fetch_array($result)) {
                if ($current_zone_iteration != $row["short_name"]) {
                    if ($current_zone_iteration != "") {
                        $return_buffer .= "</ul>";
                        $return_buffer .= "</ul>";
                    }
                    $return_buffer .= "<ul>";
                    $return_buffer .= "<li><b>in <a href='?a=zone&name=" . $row["short_name"] . "'>" . $row["long_name"] . "</a> by </b></li>";
                    $return_buffer .= "<ul>";
                    $current_zone_iteration = $row["short_name"];
                }
                $return_buffer .= "<li><a href='?a=npc&id=" . $row["id"] . "'>" . get_npc_name_human_readable($row["name"]) . "</a>";
                if ($item_add_chance_to_drop) {
                    $return_buffer .= " (" . ($row["chance"] * $row["probability"] / 100) . "% x " . $row["multiplier"] . ")";
                }
				if ($item_add_chance_to_drop_as_rarity) {
					$return_buffer .= " - " . ($row["chance"]);
				}
                $return_buffer .= "</li>";
            }
            $return_buffer .= "</ul>";
            $return_buffer .= "</ul>";
            $return_buffer .= "</td>";
            if($via_ajax == 0){
                $return_buffer .= "</tr>";
            }
            return $return_buffer;
        }
    }
    return;
}

function return_where_item_sold($item_id){
    global
            $npc_types_table,
            $merchant_list_table,
            $spawn2_table,
            $zones_table,
            $spawn_entry_table,
            $item;
	$original_item_id = $item_id;
	
	if ($item_id >= 800000) {
		$item_id = $item_id - 800000;
	}
	else if ($item_id >= 600000) {
		$item_id = $item_id - 600000;
	}
	
    $is_item_sold_anywhere = get_field_result(
        "item",
        "SELECT item FROM $merchant_list_table WHERE item=$item_id LIMIT 1");

    if ($is_item_sold_anywhere) {
        // npcs selling this (Very Heavy Query)
        $query = "
            SELECT
                $npc_types_table.id,
                $npc_types_table.`name`,
                $spawn2_table.zone,
                $zones_table.long_name,
                $npc_types_table.class
            FROM
                $npc_types_table,
                $merchant_list_table,
                $spawn2_table,
                $zones_table,
                $spawn_entry_table
            WHERE
                $merchant_list_table.item = $item_id
            AND $npc_types_table.id = $spawn_entry_table.npcID
            AND $spawn_entry_table.spawngroupID = $spawn2_table.spawngroupID
            AND $merchant_list_table.merchantid = $npc_types_table.merchant_id
            AND $zones_table.short_name = $spawn2_table.zone
			AND $zones_table.min_status = 0
        ";

        $result = db_mysql_query($query);

        if (mysqli_num_rows($result) > 0) {
            $return_buffer = "";
            $return_buffer .= "<tr>";
			if ($original_item_id >= 600000) {
				$return_buffer .= "<td><h2 class='section_header'>The non-Vegas version of this item is sold:</h2>";
			} else {
				$return_buffer .= "<td><h2 class='section_header'>This item is sold:</h2>";
			}
           #$return_buffer .= "<td><h2 class='section_header'>This item is sold:</h2>";

            $current_zone_iteration = "";
            while ($row = mysqli_fetch_array($result)) {
                if ($current_zone_iteration != $row["zone"]) {
                    if ($current_zone_iteration != "") {
                        $return_buffer .= "</ul>";
                        $return_buffer .= "</ul>";
                    }
                    $return_buffer .= "<ul>";
                    $return_buffer .= "<li><b>in <a href='?a=zone&name=" . $row["zone"] . "'>" . $row["long_name"] . "</a> by </b></li>";
                    $return_buffer .= "<ul>";

                    $current_zone_iteration = $row["zone"];
                }

                $return_buffer .= "
                    <li>
                        <a href='?a=npc&id=" . $row["id"] . "'>
                            " . str_replace("_", " ", $row["name"]) . "
                        </a>
                ";

                if ($row["class"] == 41) $return_buffer .= " (" . price($item["price"]) . ")"; // NPC is a shopkeeper
                if ($row["class"] == 61) $return_buffer .= " (" . $item["ldonprice"] . " points)"; // NPC is a LDON merchant

                $return_buffer .= "</li>";
            }
            $return_buffer .= "</ul>";
            $return_buffer .= "</ul>";
            $return_buffer .= "</td>";
            $return_buffer .= "</tr>";

            return $return_buffer;
        }
    }

    return;
}

function return_where_item_ground_spawn($item_id){

    global
            $ground_spawns_table,
            $zones_table;
	$original_item_id = $item_id;
	
	if ($item_id >= 800000) {
		$item_id = $item_id - 800000;
	}
	else if ($item_id >= 600000) {
		$item_id = $item_id - 600000;
	}
	
    $query = "
        SELECT
            $ground_spawns_table.*,
            $zones_table.short_name,
            $zones_table.long_name
        FROM
            $ground_spawns_table,
            $zones_table
        WHERE
            item = $item_id
        AND $ground_spawns_table.zoneid = $zones_table.zoneidnumber
		AND $zones_table.min_status = 0
    ";

    $return_buffer = "";

    $result = db_mysql_query($query);
    if (mysqli_num_rows($result) > 0) {
        $return_buffer .= "<tr>";
		
		if ($original_item_id >= 600000) {
			$return_buffer .= "<td><h2 class='section_header'>The non-Vegas version of this item is sold:</h2>";
		} else {
			$return_buffer .= "<td><h2 class='section_header'>This item spawns on the ground</h2>";
		}
		#$return_buffer .= "<td><h2 class='section_header'>This item spawns on the ground</h2><br>";

        $current_zone_iteration = "";

        while ($row = mysqli_fetch_array($result)) {
            if ($current_zone_iteration != $row["short_name"]) {
                if ($current_zone_iteration != "") {
                    $return_buffer .= "</ul>";
                }
                $return_buffer .= "<b><a href='?a=zone&name=" . $row["short_name"] . "'>" . $row["long_name"] . "</a> at: </b>";
                $return_buffer .= "<ul>";
                $current_zone_iteration = $row["short_name"];
            }
            $return_buffer .= "<li>" . $row["max_x"] . " (X), " . $row["max_y"] . " (Y), " . $row["max_z"] . " (Z)</a></li>";
        }
        $return_buffer .= "</ul>";
        $return_buffer .= "</td>";
        $return_buffer .= "</tr>";
        return $return_buffer;
    }
    return;
}

function return_where_item_foraged($item_id){
    global
            $zones_table,
            $forage_table;
	$original_item_id = $item_id;
	
	if ($item_id >= 800000) {
		$item_id = $item_id - 800000;
	}
	else if ($item_id >= 600000) {
		$item_id = $item_id - 600000;
	}
	
    $query = "
        SELECT
            $zones_table.short_name,
            $zones_table.long_name,
            $forage_table.chance,
            $forage_table. LEVEL
        FROM
            $zones_table,
            $forage_table
        WHERE
            $zones_table.zoneidnumber = $forage_table.zoneid
        AND $forage_table.itemid = $item_id
		AND $zones_table.min_status = 0
        GROUP BY
            $zones_table.zoneidnumber
    ";
    $print_buffer = "";

    $result = db_mysql_query($query);
    if (mysqli_num_rows($result) > 0) {
		if ($original_item_id >= 600000) {
			$print_buffer .= "
            <tr>
                <td colspan='2'></td>
            <tr>
            <tr>
                <td>
                <h2 class='section_header'>The non-Vegas version of this item can be foraged in:</h2>
        ";
		} else {
			$print_buffer .= "
            <tr>
                <td colspan='2'></td>
            <tr>
            <tr>
                <td>
                <h2 class='section_header'>This item can be foraged in:</h2>
        ";
		}
        #$print_buffer .= "
        #    <tr>
        #        <td colspan='2'></td>
        #    <tr>
        #    <tr>
        #        <td>
        #        <h2 class='section_header'>This item can be foraged in:</h2>
        #";
        while ($row = mysqli_fetch_array($result)) {
            $print_buffer .= "
                <li>
                    <a href='?a=zone&name=" . $row["short_name"] . "'>" . str_replace("_", " ", $row["long_name"]) . "</a>
                </li>
            ";
        }
        $print_buffer .= "</td></tr>";
        return $print_buffer;
    }
    return;
}

function return_where_item_used_trade_skills($item_id){
    global
            $trade_skill_recipe_table,
            $trade_skill_recipe_entries,
            $dbskills;
	$original_item_id = $item_id;
	
	if ($item_id >= 800000) {
		$item_id = $item_id - 800000;
	}
	else if ($item_id >= 600000) {
		$item_id = $item_id - 600000;
	}
	
    $query = "
        SELECT
            $trade_skill_recipe_table.`name`,
            $trade_skill_recipe_table.id,
            $trade_skill_recipe_table.tradeskill
        FROM
            $trade_skill_recipe_table,
            $trade_skill_recipe_entries
        WHERE
            $trade_skill_recipe_table.id = $trade_skill_recipe_entries.recipe_id
        AND $trade_skill_recipe_entries.item_id = $item_id
        AND $trade_skill_recipe_entries.componentcount > 0
        GROUP BY
            $trade_skill_recipe_table.id
    ";
    $result = db_mysql_query($query);
    $return_buffer = "";
    if (mysqli_num_rows($result) > 0) {
		if ($original_item_id >= 600000) {
			$return_buffer .= "<td><h2 class='section_header'>The non-Vegas version of this item is used in tradeskill recipes</h2>";
		} else {
			$return_buffer .= "<td><h2 class='section_header'>This item is used in tradeskill recipes</h2>";
		}
        #$return_buffer .= '<tr><td colspan="2"><h2 class="section_header">This item is used in tradeskill recipes</h2></td></tr>';
        $return_buffer .= "<tr><td><ul>";
        while ($row = mysqli_fetch_array($result)) {
            $return_buffer .= "
                <li style='list-style-type:none'>
                    " . get_item_icon_from_id($item_id) . "
                    <a href='?a=recipe&id=" . $row["id"] . "'>
                        " . str_replace("_", " ", $row["name"]) . "
                    </a> (" . ucfirstwords(strip_underscores($dbskills[$row["tradeskill"]])) . ")
                </li>
            ";
        }
        $return_buffer .= "</ul></td></tr>";
    }
    return $return_buffer;
}

function return_where_item_result_trade_skill($item_id){
    global
        $trade_skill_recipe_table,
        $trade_skill_recipe_entries,
        $dbskills;
	$original_item_id = $item_id;
	
	if ($item_id >= 800000) {
		$item_id = $item_id - 800000;
	}
	else if ($item_id >= 600000) {
		$item_id = $item_id - 600000;
	}
	
    $query = "
        SELECT
            $trade_skill_recipe_table.`name`,
            $trade_skill_recipe_table.id,
            $trade_skill_recipe_table.tradeskill
        FROM
            $trade_skill_recipe_table,
            $trade_skill_recipe_entries
        WHERE
            $trade_skill_recipe_table.id = $trade_skill_recipe_entries.recipe_id
        AND $trade_skill_recipe_entries.item_id = $item_id
        AND $trade_skill_recipe_entries.successcount > 0
        GROUP BY
            $trade_skill_recipe_table.id
    ";
    $result = db_mysql_query($query);
    $return_buffer = "";
    if (mysqli_num_rows($result) > 0) {
		if ($original_item_id >= 600000) {
			$return_buffer .= "<td><h2 class='section_header'>The non-Vegas version of this item is the result of tradeskill recipes</h2>";
		} else {
			$return_buffer .= "<td><h2 class='section_header'>This item is the result of tradeskill recipes</h2>";
		}
        #$return_buffer .= "<tr><td><h2 class='section_header'>This item is the result of tradeskill recipes</h2><ul>";
        while ($row = mysqli_fetch_array($result)) {
            $return_buffer .= "
                <li style='list-style-type:none'>
                    " . get_item_icon_from_id($item_id) . "
                    <a href='?a=recipe&id=" . $row["id"] . "'>
                        " . str_replace("_", " ", $row["name"]) . "
                    </a>
                    (" . ucfirstwords(strip_underscores(strtolower($dbskills[$row["tradeskill"]]))) . ")
                </li>";
        }
        $return_buffer .= "</ul></td></tr>";

        return $return_buffer;
    }

    return;
}

?>