<?php
function return_levelup($via_ajax = 0){
    global
        $trade_skill_recipe_table,
        $trade_skill_recipe_entries,
        $dbskills;

    $query = "
        SELECT 
		CASE
			WHEN d.`key` NOT LIKE '%]' AND d.`key` NOT LIKE '%['
			THEN (CASE
				WHEN d.`key` LIKE '%]%'
				THEN SUBSTRING(d.`key`, INSTR(d.`key`,'-')+1,INSTR(d.`key`,']')-INSTR(d.`key`,'-')-1)
				WHEN d.`key` LIKE '%[%'
				THEN SUBSTRING(d.`key`, INSTR(d.`key`,'-')+1,INSTR(d.`key`,'[')-INSTR(d.`key`,'-')-1)
				WHEN d.`key` LIKE '%-%'
				THEN SUBSTRING(d.`key`, INSTR(d.`key`,'-')+1)
				END)
			END AS 'Level',
		cd.id AS CharID,
		cd.`name` AS CharName,
		SUBSTRING(d.`value`, INSTR(d.`value`,'|')+1) AS 'Time'
	FROM 
		data_buckets d
	INNER JOIN character_data cd ON cd.id = SUBSTRING(d.`value`, INSTR(d.`value`,':')+1,INSTR(d.`value`,'|')-INSTR(d.`value`,':')-1)
	WHERE d.`key` LIKE 'FirstLevel%' 
	ORDER BY LEVEL, Class, Race ASC
    ";
    $result = db_mysql_query($query);
    if (mysqli_num_rows($result) > 0) {
            $return_buffer = "";
            if($via_ajax == 0){
                $return_buffer .= "<tr>";
                $return_buffer .= "<td><h2 class='section_header'>Item Drops</h2>";
            }
            $current_zone_iteration = "";
            while ($row = mysqli_fetch_array($result)) {
                if ($current_zone_iteration != $row["zone"]) {
                    if ($current_zone_iteration != "") {
                        $return_buffer .= "</ul>";
                        $return_buffer .= "</ul>";
                    }
                    $return_buffer .= "<ul>";
					$return_buffer .= "
					<li>
						<b><a href='?a=zone&name=" . $row["zone"] . "'>" .
							$row["long_name"] . "</a>
						</b>
					</li>";
					$return_buffer .= "<ul>";
					$current_zone_iteration = $row["zone"];
				}
                $return_buffer .= "
				<li>
					<a href='?a=npc&id=" . $row["id"] . "'>" .
						str_replace("_", " ", $row["name"]) . 
					"</a>";
					if ($item_add_chance_to_drop) {
						$return_buffer .= " has a " . ($row["chance"] * $row["probability"] / 100) . "% probability to drop this item at a multiplier of  " . $row["multiplier"] . ".";
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

    return;
}

?>