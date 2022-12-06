<?php
/** If the parameter 'isearch' is set, queries for the items matching the criterias and displays them, along with an item search form.
 *    If only one and only one item is found then this item is displayed.
 *  If 'isearch' is not set, displays a search item form.
 *  If no criteria is set then it is equivalent to searching for all items.
 *  For compatbility with Wikis and multi-word searches, underscores are treated as jokers in 'iname'.
 */

$order = (isset($_GET['order']) ? addslashes($_GET["order"]) : "$items_table.Name ASC");
$isearch = (isset($_GET['isearch']) ? $_GET['isearch'] : '');
$iname = (isset($_GET['iname']) ? $_GET['iname'] : '');
$iclass = (isset($_GET['iclass']) ? addslashes($_GET['iclass']) : '');
$irace = (isset($_GET['irace']) ? addslashes($_GET['irace']) : '');
$islot = (isset($_GET['islot']) ? addslashes($_GET['islot']) : '');
$istat1 = (isset($_GET['istat1']) ? addslashes($_GET['istat1']) : '');
$istat1comp = (isset($_GET['istat1comp']) ? addslashes($_GET['istat1comp']) : '');
$istat1value = (isset($_GET['istat1value']) ? addslashes($_GET['istat1value']) : '');
$istat2 = (isset($_GET['istat2']) ? addslashes($_GET['istat2']) : '');
$istat2comp = (isset($_GET['istat2comp']) ? addslashes($_GET['istat2comp']) : '');
$istat2value = (isset($_GET['istat2value']) ? addslashes($_GET['istat2value']) : '');
$iresists = (isset($_GET['iresists']) ? addslashes($_GET['iresists']) : '');
$iresistscomp = (isset($_GET['iresistscomp']) ? addslashes($_GET['iresistscomp']) : '');
$iresistsvalue = (isset($_GET['iresistsvalue']) ? addslashes($_GET['iresistsvalue']) : '');
$iheroics = (isset($_GET['iheroics']) ? addslashes($_GET['iheroics']) : '');
$iheroicscomp = (isset($_GET['iheroicscomp']) ? addslashes($_GET['iheroicscomp']) : '');
$iheroicsvalue = (isset($_GET['iheroicsvalue']) ? addslashes($_GET['iheroicsvalue']) : '');
$imod = (isset($_GET['imod']) ? addslashes($_GET['imod']) : '');
$imodcomp = (isset($_GET['imodcomp']) ? addslashes($_GET['imodcomp']) : '');
$imodvalue = (isset($_GET['imodvalue']) ? addslashes($_GET['imodvalue']) : '');
$iskillmod = (isset($_GET['iskillmod']) ? addslashes($_GET['iskillmod']) : '');
$iskillmodcomp = (isset($_GET['iskillmodcomp']) ? addslashes($_GET['iskillmodcomp']) : '');
$iskillmodvalue = (isset($_GET['iskillmodvalue']) ? addslashes($_GET['iskillmodvalue']) : '');
$ibardskillmod = (isset($_GET['ibardskillmod']) ? addslashes($_GET['ibardskillmod']) : '');
$ibardskillmodcomp = (isset($_GET['ibardskillmodcomp']) ? addslashes($_GET['ibardskillmodcomp']) : '');
$ibardskillmodvalue = (isset($_GET['ibardskillmodvalue']) ? addslashes($_GET['ibardskillmodvalue']) : '');
$itype = (isset($_GET['itype']) ? addslashes($_GET['itype']) : -1);
$iaugslot = (isset($_GET['iaugslot']) ? addslashes($_GET['iaugslot']) : '');
$ieffect = (isset($_GET['ieffect']) ? addslashes($_GET['ieffect']) : '');
$ireqlevel = (isset($_GET['ireqlevel']) ? addslashes($_GET['ireqlevel']) : '');
$iminlevel = (isset($_GET['iminlevel']) ? addslashes($_GET['iminlevel']) : '');
$imaxreclevel = (isset($_GET['imaxreclevel']) ? addslashes($_GET['imaxreclevel']) : '');
$iminreclevel = (isset($_GET['iminreclevel']) ? addslashes($_GET['iminreclevel']) : '');
$inodrop = (isset($_GET['inodrop']) ? addslashes($_GET['inodrop']) : '');
$iavailability = (isset($_GET['iavailability']) ? addslashes($_GET['iavailability']) : '');
$iavailevel = (isset($_GET['iavailevel']) ? addslashes($_GET['iavailevel']) : '');
$ideity = (isset($_GET['ideity']) ? addslashes($_GET['ideity']) : '');
$ibeingsold = (isset($_GET['ibeingsold']) ? addslashes($_GET['ibeingsold']) : '');
$itier = (isset($_GET['itier']) ? addslashes($_GET['itier']) : '');
$ilowprice = (isset($_GET['ilowprice']) ? addslashes($_GET['ilowprice']) : '');
$ihighprice = (isset($_GET['ihighprice']) ? addslashes($_GET['ihighprice']) : '');
$ivegas = (isset($_GET['ivegas']) ? addslashes($_GET['ivegas']) : '');
$ishardvalue = (isset($_GET['ishardvalue']) ? addslashes($_GET['ishardvalue']) : '');
$ieffectlevel = (isset($_GET['ieffectlevel']) ? addslashes($_GET['ieffectlevel']) : '');
$ieffectlevelcomp = (isset($_GET['ieffectlevelcomp']) ? addslashes($_GET['ieffectlevelcomp']) : '');
$ieffecttype = (isset($_GET['ieffecttype']) ? addslashes($_GET['ieffecttype']) : '');
$imindiff = (isset($_GET['imindiff']) ? addslashes($_GET['imindiff']) : '');
$imaxdiff = (isset($_GET['imaxdiff']) ? addslashes($_GET['imaxdiff']) : '');
$iraiditemsonly = (isset($_GET['iraiditemsonly']) ? addslashes($_GET['iraiditemsonly']) : '');

if (count($_GET) > 2) {
    $query = "SELECT *, $items_table.icon AS ItemIcon ";
	
	if ($ibeingsold != -1) {
		$query .= ", $items_table.id AS ItemID, $items_table.Name AS ItemName, $items_table.hp AS ItemHP, $items_table.mana AS ItemMana, npc.lastname AS LastName, npc.is_valeen_spawned AS ValeenStatus";
	}
	
	if ($ieffect != "") {
		$query .= ", $items_table.id AS ItemID, $items_table.Name AS ItemName, proc_s.icon AS ProcIcon, worn_s.icon AS WornIcon, focus_s.icon AS FocusIcon, click_s.icon AS ClickIcon";
	}
	$query .= " FROM ($items_table";

    if ($discovered_items_only == TRUE) {
        $query .= ",discovered_items";
    }

    if ($iavailability == 1) {
        // mob dropped
        $query .= ",$loot_drop_entries_table,$loot_table_entries,$npc_types_table";
    }
	
	$query .= ")";
	
	$s = " WHERE";
	
	if ($ibeingsold != -1) {
		$query .= " INNER JOIN $merchant_list_table AS merch ON merch.item = $items_table.`id`";
		$query .= " INNER JOIN $npc_types_table AS npc ON npc.merchant_id = merch.merchantid";
	}
	
    if ($ieffect != "") {
        $effect = "%" . str_replace(',', '%', str_replace(' ', '%', addslashes($ieffect))) . "%";

        $query .= " LEFT JOIN $spells_table AS proc_s ON proceffect=proc_s.id";
        $query .= " LEFT JOIN $spells_table AS worn_s ON worneffect=worn_s.id";
        $query .= " LEFT JOIN $spells_table AS focus_s ON focuseffect=focus_s.id";
        $query .= " LEFT JOIN $spells_table AS click_s ON clickeffect=click_s.id";
        $query .= " WHERE (proc_s.`name` LIKE '$effect'
				OR worn_s.`name` LIKE '$effect'
				OR focus_s.`name` LIKE '$effect'
				OR click_s.`name` LIKE '$effect') ";
        $s = "AND";
    }
	
	$query .= " $s $items_table.minstatus = 0";
	$s = "AND";	
	
	if ($ivegas == 1) {
		$query .= " $s $items_table.name NOT LIKE '%*'";
		$s = "AND";
	}
	if ($ibeingsold != -1) {
		$query .= " $s npc.`name` LIKE 'Valeen'";
		$s = "AND";
	}
	if ($ibeingsold == 1) {
		$query .= " $s npc.is_valeen_spawned = 1";
		$s = "AND";
	}
	if ($ibeingsold != -1 AND $itier > 0) {
		$query .= " $s npc.`lastname` LIKE CONCAT('T', $itier,'')";
		$s = "AND";
	}
	if ($ibeingsold != -1 AND $ilowprice > 0) {
		$query .= " $s merch.alt_currency_cost >= $ilowprice";
		$s = "AND";
	}
	if ($ibeingsold != -1 AND $ihighprice > 0) {
		$query .= " $s merch.alt_currency_cost <= $ihighprice";
		$s = "AND";
	}
    if (($istat1 != "") AND ($istat1value != "")) {
        if ($istat1 == "ratio") {
            $query .= " $s ($items_table.damage/$items_table.delay $istat1comp $istat1value) AND ($items_table.damage>0)";
            $s = "AND";
        } else {
            $query .= " $s ($items_table.$istat1 $istat1comp $istat1value)";
            $s = "AND";
        }
    }
    if (($istat2 != "") AND ($istat2value != "")) {
        if ($istat2 == "ratio") {
            $query .= " $s ($items_table.damage/$items_table.delay $istat2comp $istat2value) AND ($items_table.damage>0)";
            $s = "AND";
        } else {
            $query .= " $s ($items_table.$istat2 $istat2comp $istat2value)";
            $s = "AND";
        }
    }
	if (($iresists != "") AND ($iresistsvalue != "")) {
        $query .= " $s ($items_table.$iresists $iresistscomp $iresistsvalue)";
        $s = "AND";
    }
    if (($imod != "") AND ($imodvalue != "")) {
        $query .= " $s ($items_table.$imod $imodcomp $imodvalue)";
        $s = "AND";
    }
	if (($iskillmod != "") AND ($iskillmodvalue != "")) {
		$query .= " $s ($items_table.skillmodtype = $iskillmod AND $items_table.skillmodvalue $iskillmodcomp $iskillmodvalue)";
		$s = "AND";
	}
	if (($ibardskillmod != "") AND ($ibardskillmodvalue != "")) {
		$query .= " $s ($items_table.bardtype = $ibardskillmod AND $items_table.bardvalue $ibardskillmodcomp $ibardskillmodvalue)";
		$s = "AND";
	}
	
    if ($iavailability == 1) // mob dropped
    {
        $query .= " $s $loot_drop_entries_table.item_id=$items_table.id
				AND $loot_table_entries.lootdrop_id=$loot_drop_entries_table.lootdrop_id
				AND $loot_table_entries.loottable_id=$npc_types_table.loottable_id";
        if ($iavaillevel > 0) {
            $query .= " AND $npc_types_table.level<=$iavaillevel";
        }
        $s = "AND";
    }
    if ($iavailability == 2) // merchant sold
    {
        $query .= ",$merchant_list_table $s $merchant_list_table.item=$items_table.id";
        $s = "AND";
    }
    if ($discovered_items_only == TRUE) {
        $query .= " $s discovered_items.item_id=$items_table.id";
        $s = "AND";
    }
    if ($iname != "") {
        $name = addslashes(str_replace("_", "%", str_replace(" ", "%", $iname)));
        $query .= " $s ($items_table.Name like '%" . $name . "%')";
        $s = "AND";
    }
    if ($iclass > 0) {
        $query .= " $s ($items_table.classes & $iclass) ";
        $s = "AND";
    }
    if ($ideity > 0) {
        $query .= " $s ($items_table.deity   & $ideity) ";
        $s = "AND";
    }
    if ($irace > 0) {
        $query .= " $s ($items_table.races   & $irace) ";
        $s = "AND";
    }
	if ($itype == 0) {
		$query .= " $s ($items_table.itemtype=$itype AND $items_table.slots != 0 AND ($items_table.damage > 0 OR $items_table.delay > 0)) ";
		$s = "AND";
	}
    if ($itype > 0) {
        $query .= " $s ($items_table.itemtype=$itype) ";
        $s = "AND";
    }
    if ($islot > 0) {
        $query .= " $s ($items_table.slots   & $islot) ";
        $s = "AND";
    }
    if ($iaugslot > 0) {
        $AugSlot = pow(2, $iaugslot) / 2;
        $query .= " $s ($items_table.augtype & $AugSlot) ";
        $s = "AND";
    }
    if ($iminlevel > 0) {
        $query .= " $s ($items_table.reqlevel>=$iminlevel) ";
        $s = "AND";
    }
    if ($ireqlevel > 0) {
        $query .= " $s ($items_table.reqlevel<=$ireqlevel) ";
        $s = "AND";
    }
	if ($iminreclevel > 0) {
        $query .= " $s ($items_table.reclevel>=$iminreclevel) ";
        $s = "AND";
    }
    if ($imaxreclevel > 0) {
        $query .= " $s ($items_table.reclevel<=$imaxreclevel) ";
        $s = "AND";
    }
    if ($inodrop == 1) {
        $query .= " $s ($items_table.nodrop=1)";
        $s = "AND";
    }
	if ($imaxdiff > 0) { // && is_numeric($imaxdiff)) {
		if ($imindiff == "" OR !is_numeric($imindiff) OR $imindiff <= 0) {
				$imindiff = 0;
		}
			$query .= " $s ($items_table.difficulty BETWEEN $imindiff AND $imaxdiff)";
			$s = "AND";
	}
	if ($iraiditemsonly != "") {
		$query .= " $s ($items_table.raidonly = " . $iraiditemsonly . ")";
        $s = "AND";
	}
	if ($ieffecttype != "") {
		$query .= " $s ($items_table." . $ieffecttype . "effect > 0)";
        $s = "AND";
		if ($ieffectlevel != "") {
		$query .= " $s ($items_table." . $ieffecttype . "level " . $ieffectlevelcomp . " " . $ieffectlevel . ")";
        $s = "AND";
		}
	}
    $query .= " GROUP BY $items_table.id ORDER BY $order LIMIT " . (get_max_query_results_count($max_items_returned) + 1);
	
	if ($showquerydebug == true) {
		$userip = getIPAddress(); 
		if ($userip == $defaultedlocalhost || $userip == $localipaddress || $userip == $defaultgateway) {
			echo $query;
		}
	}
	
    $QueryResult = db_mysql_query($query);
	
    $field_values = '';
    foreach ($_GET as $key => $val){
        $field_values .= '$("#'. $key . '").val("'. $val . '");';
    }

    $footer_javascript .= '<script type="text/javascript">' . $field_values . '</script>';
    // $footer_javascript .= '<script type="text/javascript">highlight_element("#item_search_results");</script>';


} else {
    $iname = "";
}

$page_title = "Item Search";

$print_buffer .= '<table><tr><td>';

$print_buffer .= file_get_contents('pages/items/item_search_form.html');

if(!isset($_GET['v_ajax'])){
    $footer_javascript .= '
        <script src="pages/items/items.js"></script>
    ';
}

// Print the query results if any
if (isset($QueryResult)) {

    $Tableborder = 0;

    $num_rows = mysqli_num_rows($QueryResult);
    $total_row_count = $num_rows;
    if ($num_rows > get_max_query_results_count($max_items_returned)) {
        $num_rows = get_max_query_results_count($max_items_returned);
    }
    $print_buffer .= "";
    if ($num_rows == 0) {
        $print_buffer .= "<b>No items found...</b><br>";
    } else {
        $OutOf = "";
        if ($total_row_count > $num_rows) {
            $OutOf = " (Searches are limited to 100 Max Results)";
        }
        # $print_buffer .= "<b>" . $num_rows . " " . ($num_rows == 1 ? "item" : "items") . " displayed</b>" . $OutOf . "<br>";
        $print_buffer .= "<br>";

        $print_buffer .= "<table class='display_table container_div datatable' id='item_search_results' style='width:90%'>";
		$url = $_SERVER['QUERY_STRING'];
		$url = str_replace("&v_ajax","",$url);
		#$url = $_SERVER['REQUEST_URI'];
		#$url = str_replace("Allaclone/?","",$url);
		#$print_buffer .= "<br><br>" . $url . "<br><br>";
		#<th class='menuh'><a href=?" . $url . "&order=ac%20desc>AC</a></th>
		#<th class='menuh'>AC</th>
        $print_buffer .= "
            <thead>
                <th class='menuh'>Icon</th>
                <th class='menuh'>Item Name<a href=?" . $url . "&order=$items_table.name%20desc>-</a>/<a href=?" . $url . "&order=$items_table.name%20asc>+</a></th>
                <th class='menuh'>Item Type<a href=?" . $url . "&order=$items_table.itemtype%20desc>-</a>/<a href=?" . $url . "&order=$items_table.itemtype%20asc>+</a></th>
                <th class='menuh'>AC<a href=?" . $url . "&order=$items_table.ac%20desc>-</a>/<a href=?" . $url . "&order=$items_table.ac%20asc>+</a></th>
                <th class='menuh'>HP<a href=?" . $url . "&order=$items_table.hp%20desc>-</a>/<a href=?" . $url . "&order=$items_table.hp%20asc>+</a></th>
				<th class='menuh'>Mana<a href=?" . $url . "&order=$items_table.mana%20desc>-</a>/<a href=?" . $url . "&order=$items_table.mana%20asc>+</a></th>
                <th class='menuh'>Damage<a href=?" . $url . "&order=$items_table.damage%20desc>-</a>/<a href=?" . $url . "&order=$items_table.damage%20asc>+</a></th>
                <th class='menuh'>Delay<a href=?" . $url . "&order=$items_table.delay%20desc>-</a>/<a href=?" . $url . "&order=$items_table.delay%20asc>+</a></th>
				<th class='menuh'>Dmg Bonus</th>
        ";
		if (($istat1 != "") AND ($istat1value != "") AND ($istat1 != "ac") AND ($istat1 != "hp") AND ($istat1 != "mana") AND ($istat1 != "damage") AND ($istat1 != "delay")) {
			if ($istat1 == "attack") { $istat1chosen = "ATK";}
			if ($istat1 == "aagi") { $istat1chosen = "AGI";}
			if ($istat1 == "acha") { $istat1chosen = "CHA";}
			if ($istat1 == "adex") { $istat1chosen = "DEX";}
			if ($istat1 == "aint") { $istat1chosen = "INT";}
			if ($istat1 == "asta") { $istat1chosen = "STA";}
			if ($istat1 == "astr") { $istat1chosen = "STR";}
			if ($istat1 == "awis") { $istat1chosen = "WIS";}
			if ($istat1 == "ratio") { $istat1chosen = "Ratio";}
			if ($istat1 == "haste") { $istat1chosen = "Haste";}
			if ($istat1 == "regen") { $istat1chosen = "Regen";}
			if ($istat1 == "manaregen") { $istat1chosen = "Mana Regen";}
			if ($istat1 == "enduranceregen") { $istat1chosen = "End Regen";}
			if ($istat1 == "aagi" OR $istat1 == "acha" OR $istat1 == "adex" OR $istat1 == "aint" OR $istat1 == "asta" OR $istat1 == "astr" OR $istat1 == "awis") {
				$print_buffer .= "
					<th class='menuh'>$istat1chosen<a href=?" . $url . "&order=$items_table.$istat1%20desc>-</a>/<a href=?" . $url . "&order=$items_table.$istat1%20asc>+</a></th>
				";
			} 
			else if ($istat1 == "ratio") {
				$print_buffer .= "
					<th class='menuh'>$istat1chosen<a href=?" . $url . "&order=$items_table.damage/$items_table.delay%20desc>-</a>/<a href=?" . $url . "&order=$items_table.damage/$items_table.delay%20asc>+</a></th>
				";
			} else {
				$print_buffer .= "
					<th class='menuh'>$istat1chosen<a href=?" . $url . "&order=$items_table.$istat1chosen%20desc>-</a>/<a href=?" . $url . "&order=$items_table.$istat1chosen%20asc>+</a></th>
				";
			}
		}
		if (($istat2 != "") AND ($istat2value != "") AND ($istat2 != "ac") AND ($istat2 != "hp") AND ($istat2 != "mana") AND ($istat2 != "damage") AND ($istat2 != "delay")) {
			if ($istat2 == "attack") { $istat2chosen = "ATK";}
			if ($istat2 == "aagi") { $istat2chosen = "AGI";}
			if ($istat2 == "acha") { $istat2chosen = "CHA";}
			if ($istat2 == "adex") { $istat2chosen = "DEX";}
			if ($istat2 == "aint") { $istat2chosen = "INT";}
			if ($istat2 == "asta") { $istat2chosen = "STA";}
			if ($istat2 == "astr") { $istat2chosen = "STR";}
			if ($istat2 == "awis") { $istat2chosen = "WIS";}
			if ($istat2 == "ratio") { $istat2chosen = "Ratio";}
			if ($istat2 == "haste") { $istat2chosen = "Haste";}
			if ($istat2 == "regen") { $istat2chosen = "Regen";}
			if ($istat2 == "manaregen") { $istat2chosen = "Mana Regen";}
			if ($istat2 == "enduranceregen") { $istat2chosen = "End Regen";}
			if ($istat2 == "aagi" OR $istat2 == "acha" OR $istat2 == "adex" OR $istat2 == "aint" OR $istat2 == "asta" OR $istat2 == "astr" OR $istat2 == "awis") {
				$print_buffer .= "
					<th class='menuh'>$istat2chosen<a href=?" . $url . "&order=$items_table.$istat2%20desc>-</a>/<a href=?" . $url . "&order=$items_table.$istat2%20asc>+</a></th>
				";
			} 
			else if ($istat2 == "ratio") {
				$print_buffer .= "
					<th class='menuh'>$istat2chosen<a href=?" . $url . "&order=$items_table.damage/$items_table.delay%20desc>-</a>/<a href=?" . $url . "&order=$items_table.damage/$items_table.delay%20asc>+</a></th>
				";
			} else {
				$print_buffer .= "
					<th class='menuh'>$istat2chosen<a href=?" . $url . "&order=$items_table.$istat2chosen%20desc>-</a>/<a href=?" . $url . "&order=$items_table.$istat2chosen%20asc>+</a></th>
				";
			}
		}
		if (($iresists != "") AND ($iresistsvalue != "")) {
			if ($iresists == "mr") { $iresistschosen = "MR";}
            if ($iresists == "fr") { $iresistschosen = "FR";}
            if ($iresists == "cr") { $iresistschosen = "CR";}
            if ($iresists == "pr") { $iresistschosen = "PR";}
            if ($iresists == "dr") { $iresistschosen = "DR";}
			$print_buffer .= "
				<th class='menuh'>$iresistschosen<a href=?" . $url . "&order=$items_table.$iresistschosen%20desc>-</a>/<a href=?" . $url . "&order=$items_table.$iresistschosen%20asc>+</a></th>
			";
		}
		if (($imod != "") AND ($imodvalue != "")) {
			$imodchosen = 1;
			$print_buffer .= "
				<th class='menuh'>Mod<a href=?" . $url . "&order=$items_table.$imod%20desc>-</a>/<a href=?" . $url . "&order=$items_table.$imod%20asc>+</a></th>
			";
		}
		if (($iskillmod != "") AND ($iskillmodvalue != "")) {
			$print_buffer .= "
				<th class='menuh'>SkillMod<a href=?" . $url . "&order=$items_table.skillmodvalue%20desc>-</a>/<a href=?" . $url . "&order=$items_table.skillmodvalue%20asc>+</a></th>
			";
		}
		if (($ibardskillmod != "") AND ($ibardskillmodvalue != "")) {
			$print_buffer .= "
				<th class='menuh'>BardMod<a href=?" . $url . "&order=$items_table.bardvalue%20desc>-</a>/<a href=?" . $url . "&order=$items_table.bardvalue%20asc>+</a></th>
			";
		}
		if ($ireqlevel > 0 OR $iminlevel > 0) {
			$print_buffer .= "
				<th class='menuh'>LvlReq<a href=?" . $url . "&order=$items_table.reqlevel%20desc>-</a>/<a href=?" . $url . "&order=$items_table.reqlevel%20asc>+</a></th>
			";
		}
		if ($imaxreclevel > 0 OR $iminreclevel > 0) {
			$print_buffer .= "
				<th class='menuh'>RecLvl<a href=?" . $url . "&order=$items_table.reclevel%20desc>-</a>/<a href=?" . $url . "&order=$items_table.reclevel%20asc>+</a></th>
			";
		}
		if ($ibeingsold != -1) {
			$print_buffer .= "
				<th class='menuh'>In Stock</th>
			";
		}
		if ($ibeingsold != -1) {
			$print_buffer .= "
				<th class='menuh'>Tier</th>
			";
		}
		if ($ibeingsold != -1 OR $ishardvalue == 1) {
			if ($ibeingsold != -1) {
				$print_buffer .= "
					<th class='menuh'>Price<a href=?" . $url . "&order=alt_currency_cost%20desc>-</a>/<a href=?" . $url . "&order=alt_currency_cost%20asc>+</a></th>
				";
			} else {
				$print_buffer .= "
					<th class='menuh'>Price<a href=?" . $url . "&order=GearScore%20desc>-</a>/<a href=?" . $url . "&order=GearScore%20asc>+</a></th>
				";
			}
		}
		if ($imaxdiff > 0) {
			$print_buffer .= "
				<th class='menuh'>Difficulty<a href=?" . $url . "&order=$items_table.difficulty%20desc>-</a>/<a href=?" . $url . "&order=$items_table.difficulty%20asc>+</a></th>
			";
		}
		$print_buffer .= "</thead>";
        $RowClass = "lr";
        for ($count = 1; $count <= $num_rows; $count++) {
            $TableData = "";
            $row = mysqli_fetch_array($QueryResult);
            $TableData .= "<tr valign='center' class='" . $RowClass . "'><td>";
            if (file_exists($icons_dir . "item_" . $row["ItemIcon"] . ".png")) {
                $TableData .= "<img src='" . $icons_url . "item_" . $row["ItemIcon"] . ".png' align='left'/>";
            } else {
                $TableData .= "<img src='" . $icons_url . "item_.gif' align='left'/>";
            }
            $TableData .= "</td><td align=center>";

            # CreateToolTip($row["id"], return_item_stat_box($row, 1));
			if ($ibeingsold == -1 AND $ieffect == "") {
				$TableData .= "<a href='?a=item&id=" . $row["id"] . "' id='" . $row["id"] . "'>" . $row["Name"] . "</a>";
			} else {
				$TableData .= "<a href='?a=item&id=" . $row["ItemID"] . "' id='" . $row["ItemID"] . "'>" . $row["ItemName"] . "</a>";
			}
            $TableData .= "</td><td align=center>";
            $TableData .= $dbitypes[$row["itemtype"]];
            $TableData .= "</td><td align=center>";
            $TableData .= $row["ac"];
            $TableData .= "</td><td align=center>";
			if ($ibeingsold == -1) {
				$TableData .= $row["hp"];
			} else {
				$TableData .= $row["ItemHP"];
			}
            $TableData .= "</td><td align=center>";
            if ($ibeingsold == -1) {
				$TableData .= $row["mana"];
			} else {
				$TableData .= $row["ItemMana"];
			}
            $TableData .= "</td><td align=center>";
            $TableData .= $row["damage"];
            $TableData .= "</td><td align=center>";
            $TableData .= $row["delay"];
			$TableData .= "</td><td align=center>";
			$TableData .= $dam2h[$row["delay"]];
			if ($istat1chosen) {
				if ($istat1chosen == "Ratio") {
					$TableData .= "</td><td align=center>";
					$TableData .= $row["damage"] / $row["delay"];
				} else {
					$TableData .= "</td><td align=center>";
					$TableData .= $row["$istat1"];
				}
			}
			if ($istat2chosen) {
				if ($istat2chosen == "Ratio") {
					$TableData .= "</td><td align=center>";
					$TableData .= $row["damage"] / $row["delay"];
				} else {
					$TableData .= "</td><td>";
					$TableData .= $row["$istat2"];
				}
			}
			if ($iresistschosen) {
				$TableData .= "</td><td align=center>";
				$TableData .= $row["$iresists"];
			}
			if (($iskillmod != "") AND ($iskillmodvalue != "")) {
				$TableData .= "</td><td align=center>";
				$TableData .= $row["skillmodvalue"];
			}
			if (($ibardskillmod != "") AND ($ibardskillmodvalue != "")) {
				$TableData .= "</td><td align=center>";
				$TableData .= $row["bardvalue"];
			}
			if ($imodchosen) {
				$TableData .= "</td><td align=center>";
				$TableData .= $row["$imod"];
			}
			if ($ireqlevel OR $iminlevel) {
				$TableData .= "</td><td align=center>";
				$TableData .= $row["reqlevel"];
			}
			if ($imaxreclevel OR $iminreclevel) {
				$TableData .= "</td><td align=center>";
				$TableData .= $row["reclevel"];
			}
			if ($ibeingsold != -1) {
				$TableData .= "</td><td align=center>";
				if ($row["ValeenStatus"] == 1) {
					$valeenstatus = "<font color=green>Yes";
				} else {
					$valeenstatus = "<font color=red>No";
				}
				$TableData .= $valeenstatus;
			}
			if ($ibeingsold != -1) {
				$TableData .= "</td><td align=center>";
				$TableData .= $row["LastName"];
			}
			if ($ibeingsold != -1 OR $ishardvalue == 1) {
				if ($ibeingsold != -1) {
					$TableData .= "</td><td align=center>";
					$TableData .= $row["alt_currency_cost"] . "<img src='$icons_url\item_2240.png' width='20px' height='10px'/>";
				} else {
					$TableData .= "</td><td align=center>";
					if ($row["GearScore"] > 257) { $TableData .= intval($row["GearScore"] * 3.25); }
					else if ($row["GearScore"] > 191) { $TableData .= intval($row["GearScore"] * 3); }
					else if ($row["GearScore"] > 156) { $TableData .= intval($row["GearScore"] * 2.75); }
					else if ($row["GearScore"] > 128) { $TableData .= intval($row["GearScore"] * 2.5); }
					else if ($row["GearScore"] > 106) { $TableData .= intval($row["GearScore"] * 2.25); }
					else if ($row["GearScore"] > 88) { $TableData .= intval($row["GearScore"] * 2); }
					else if ($row["GearScore"] > 72) { $TableData .= intval($row["GearScore"] * 1.75); }
					else if ($row["GearScore"] > 58) { $TableData .= intval($row["GearScore"] * 1.5); }
					else if ($row["GearScore"] > 45) { $TableData .= intval($row["GearScore"] * 1.25); }
					else if ($row["GearScore"] > 0) { $TableData .= intval($row["GearScore"]); }
					else { $TableData .= 0; }
					$TableData .= " <img src='$icons_url\item_2240.png' width='20px' height='10px'/>";
				}
			}
			if ($imaxdiff > 0) {
				$TableData .= "</td><td align=center>";
				$TableData .= number_format($row["difficulty"], 2);
			}
            $TableData .= "</td><td align=center>";

            if ($RowClass == "lr") {
                $RowClass = "dr";
            } else {
                $RowClass = "lr";
            }

            $print_buffer .= $TableData;
        }
        $print_buffer .= "</td></table>";
    }

    $footer_javascript .= '
        <script>
            $(document).ready(function() {
                var table = $(".datatable").DataTable( {
                    paging:         false,
                    "searching": false,
                    "ordering": true,
                } );
                table.order( [ 1, "asc" ] );
                table.draw();
            });
        </script>
    ';
}

$print_buffer .= '</tr></table>';


?>
