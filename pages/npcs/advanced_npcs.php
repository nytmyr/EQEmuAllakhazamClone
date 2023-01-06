<?php
$page_title = "Advanced NPC Search";

$isearch = (isset($_GET['isearch']) ? $_GET['isearch'] : '');
$id = (isset($_GET['id']) ? addslashes($_GET['id']) : '');
$iname = (isset($_GET['iname']) ? $_GET['iname'] : '');
$iminlevel = (isset($_GET['iminlevel']) ? $_GET['iminlevel'] : '');
$imaxlevel = (isset($_GET['imaxlevel']) ? $_GET['imaxlevel'] : '');
$inamed = (isset($_GET['inamed']) ? $_GET['inamed'] : '');
$ishowlevel = (isset($_GET['ishowlevel']) ? $_GET['ishowlevel'] : '');
$irace = (isset($_GET['irace']) ? $_GET['irace'] : '');
$imindiff = (isset($_GET['imindiff']) ? $_GET['imindiff'] : '');
$imaxdiff = (isset($_GET['imaxdiff']) ? $_GET['imaxdiff'] : '');
$iminexpansion = (isset($_GET['iminexpansion']) ? $_GET['iminexpansion'] : 0);
$imaxexpansion = (isset($_GET['imaxexpansion']) ? $_GET['imaxexpansion'] : 0);
$irare = (isset($_GET['irare']) ? $_GET['irare'] : '');
$iraid = (isset($_GET['iraid']) ? $_GET['iraid'] : '');
$imustdropitems  = (isset($_GET['imustdropitems']) ? $_GET['imustdropitems'] : '');
$ishowdifficulty  = (isset($_GET['ishowdifficulty']) ? $_GET['ishowdifficulty'] : '');
$ishowexpansion  = (isset($_GET['ishowexpansion']) ? $_GET['ishowexpansion'] : '');

if ($irace == 0) {
    $irace = '';
}
$ibodytype = (isset($_GET['ibodytype']) ? $_GET['ibodytype'] : '');
if ($ibodytype == 0) {
    $ibodytype = '';
}


$print_buffer .= "<table border=0 width=0%>";
$print_buffer .= "<form method=GET action=$PHP_SELF>";
$print_buffer .= '<input type="hidden" name="a" value="advanced_npcs">';
// LEFT SIDE START
$print_buffer .= "<tr><td><b>Name : </b></td><td><input type=text value=\"$iname\" size=30 name=iname ></td></tr>";
$print_buffer .= "<tr><td><b>Level : </b></td><td>Between ";
$print_buffer .= SelectLevel("iminlevel", $server_max_npc_level, $iminlevel);
$print_buffer .= " and ";
$print_buffer .= SelectLevel("imaxlevel", $server_max_npc_level, $imaxlevel);
$print_buffer .= "</tr>";
if ($show_npcs_difficulty_search == TRUE) {
	$print_buffer .= "<tr><td><b>Difficulty : </b></td><td><input type=text value=\"$imindiff\" size=6 name=imindiff > to <input type=text value=\"$imaxdiff\" size=6 name=imaxdiff ></td></tr>";
}
if ($show_npcs_expansion_search == TRUE) {
	$print_buffer .= "<td><b>------------------</b></td>";
	$print_buffer .= "<tr><td><b>Expansion Range </b></td><td>";
	$print_buffer .= SelectExpansion("iminexpansion", $iminexpansion);
	$print_buffer .= " <b>to</b> ";
	$print_buffer .= SelectExpansion("imaxexpansion", $imaxexpansion);
	$print_buffer .= "</td></tr>";
	$print_buffer .= "<td><b>------------------</b></td>";
}
$print_buffer .= "<tr><td><b>Race : </b></td><td>";
$print_buffer .= SelectMobRace("irace", $irace);
$print_buffer .= "</td></tr>";
$print_buffer .= "<tr><td><b>Body Type : </b></td><td>";
$print_buffer .= SelectMobBodyType("ibodytype", $ibodytype);
$print_buffer .= "</td></tr>";
//$print_buffer .= "<tr><td><b>Named mob : </b></td><td><input type=checkbox name=inamed " . ($inamed ? " checked" : "") . "></td></tr>";
$print_buffer .= "<tr><td><b>Named/Rare : </b></td><td><input type=checkbox name=irare " . ($irare ? " checked" : "") . "></td></tr>";
$print_buffer .= "<tr><td><b>Raid : </b></td><td><input type=checkbox name=iraid " . ($iraid ? " checked" : "") . "></td></tr>";
#$print_buffer .= "</table></td>";
// LEFT SIDE END
// RIGHT SIDE START
$print_buffer .= "<tr><td><b>Show level </td><td><input type=checkbox name=ishowlevel " . ($ishowlevel ? " checked" : "") . "></b></td></tr>";
#$print_buffer .= "<br>";
$print_buffer .= "<tr><td><b> Show difficulty </td><td><input type=checkbox name=ishowdifficulty " . ($ishowdifficulty ? " checked" : "") . "></b></td></tr>";
#$print_buffer .= "<br>";
$print_buffer .= "<tr><td><b> Must drop items/cash </td><td><input type=checkbox name=imustdropitems " . ($imustdropitems ? " checked" : "") . "</b></td></tr>";
// RIGHT SIDE END
$print_buffer .= "<br><br><tr align=center colspan=2><td colspan=2><input type=submit value=Search name=isearch class=form></td></tr>";
$print_buffer .= "</td></tr>";
$print_buffer .= "</form></table>";

if (isset($isearch) && $isearch != '') {
    $query = "
        SELECT
            -- $npc_types_table.id,
            -- $npc_types_table.`name`,
            -- $npc_types_table.level
			*
        FROM
            $npc_types_table
        WHERE
            1 = 1
    ";
    if ($iminlevel > $imaxlevel) {
        $c = $iminlevel;
        $iminlevel = $imaxlevel;
        $imaxlevel = $c;
    }
    if ($iminlevel > 0 && is_numeric($iminlevel)) {
        $query .= " AND $npc_types_table.level>=$iminlevel";
    }
    if ($imaxlevel > 0 && is_numeric($imaxlevel)) {
        $query .= " AND $npc_types_table.level<=$imaxlevel";
    }
    //if ($inamed) {
    //    $query .= " AND substring($npc_types_table.`name`,1,1)='#'";
    //}
    if ($irace > 0 && is_numeric($irace)) {
        $query .= " AND $npc_types_table.race=$irace";
    }
	if ($ibodytype > 0 && is_numeric($ibodytype)) {
        $query .= " AND $npc_types_table.bodytype=$ibodytype";
    }
    if ($iname != "") {
        $iname = str_replace('`', '%', str_replace(' ', '%', addslashes($iname)));
        $query .= " AND $npc_types_table.`name` LIKE '%$iname%'";
    }
	if ($show_npcs_difficulty_search == TRUE) {
		if ($imaxdiff > 0 && is_numeric($imaxdiff)) {
			if ($imindiff == "" OR !is_numeric($imindiff) OR $imindiff <= 0) {
				$imindiff = 0;
			}
			$query .= " AND $npc_types_table.`difficulty` BETWEEN $imindiff AND $imaxdiff";
		}
	}
	if ($iminexpansion > 0 && $imaxexpansion > 0) {
		if ($iminexpansion == 1) { $erarangemin = 1; }
		if ($iminexpansion == 2) { $erarangemin = 78000; }
		if ($iminexpansion == 3) { $erarangemin = 110000; }
		if ($iminexpansion == 4) { $erarangemin = 150000; }
		if ($iminexpansion == 5) { $erarangemin = 200000; }
		if ($imaxexpansion == 1) { $erarangemax = 77999; }
		if ($imaxexpansion == 2) { $erarangemax = 109999; }
		if ($imaxexpansion == 3) { $erarangemax = 129999; }
		if ($imaxexpansion == 4) { $erarangemax = 179999; }
		if ($imaxexpansion == 5) { $erarangemax = 223999; }
		$query .= " AND $npc_types_table.`id` BETWEEN $erarangemin AND $erarangemax";
	}
	if ($irare && !$iraid) {
		$query .= " AND $npc_types_table.`rare_spawn` = 1";
	}
	if ($iraid && !$irare) {
		$query .= " AND $npc_types_table.`raid_target` = 1";
	}
	if ($irare && $iraid) {
		$query .= " AND ($npc_types_table.`rare_spawn` = 1 OR $npc_types_table.`raid_target` = 1)";
	}
	if ($imustdropitems) {
		$query .= " AND $npc_types_table.`loottable_id` > 0";
	}
    if ($hide_invisible_men == TRUE) {
        $query .= "
			AND (($npc_types_table.`race` = 127 AND $npc_types_table.`mindmg` != 1 AND $npc_types_table.`maxdmg` != 4 AND $npc_types_table.`show_name` = 1) OR ($npc_types_table.`race` != 127))
			AND (($npc_types_table.`race` = 240 AND $npc_types_table.`mindmg` != 1 AND $npc_types_table.`maxdmg` != 4 AND $npc_types_table.`show_name` = 1) OR ($npc_types_table.`race` != 240))
		";
    }
    $query .= " ORDER BY $npc_types_table.`name`";
    $result = db_mysql_query($query) or message_die('npcs.php', 'MYSQL_QUERY', $query, mysqli_error());
    $n = mysqli_num_rows($result);
    if ($n > $max_npcs_returned) {
        $print_buffer .= "$n ncps found, showing the $max_npcs_returned first ones...";
        $query .= " LIMIT $max_npcs_returned";
        $result = db_mysql_query($query) or message_die('npcs.php', 'MYSQL_QUERY', $query, mysqli_error());
    }
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $print_buffer .= "<li><a href=?a=npc&id=" . $row["id"] . ">" . get_npc_name_human_readable($row["name"]) . "</a>";
            if ($ishowlevel) {
                $print_buffer .= " (<b>L" . $row["level"] . "</b>)";
            }
			if ($ishowdifficulty) {
				$print_buffer .= " --- [Diff: <b>" . number_format($row["difficulty"], 2) . "</b>]";
			}
        }
    } else {
        $print_buffer .= "<li>No npc found.";
    }
}


?>