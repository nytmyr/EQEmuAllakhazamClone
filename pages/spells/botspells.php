<?php

#ini_set('display_errors', 'On');
#error_reporting(E_ALL);

$page_title = "Bot Spell Search";
require_once($includes_dir . 'spell.inc.php');

$opt = (isset($_GET['opt']) ? $_GET['opt'] : '');
$namestring = (isset($_GET['name']) ? $_GET['name'] : '');
$level = (isset($_GET['level']) ? $_GET['level'] : 0);
$type = (isset($_GET['type']) ? $_GET['type'] : 0);
$spelltype = (isset($_GET['spelltype']) ? $_GET['spelltype'] : 0);
$leveltwo = (isset($_GET['leveltwo']) ? $_GET['leveltwo'] : '');

$check1 = "";
$check2 = "";
$check3 = "";
$check4 = "";

if ($opt == 1) {
    $check1 = "checked";
    $OpDiff = 0;
    $ClassOper = "=";
} elseif ($opt == 2) {
    $check2 = "checked";
    $OpDiff = -1;
    $ClassOper = ">=";
} elseif ($opt == 3) {
    $check3 = "checked";
    $OpDiff = 1;
    $ClassOper = "<=";
} elseif ($opt == 4) {
	$check4 = "checked";
	$OpDiff = -1; #checkme
	$ClassOper = " BETWEEN "; #checkme
} else {
    $check2 = "checked";
    $OpDiff = 0;
    $ClassOper = ">=";
}

/* Display Spell Form */
$print_buffer .= '<table border="0" class="display_table container_div" style="width:90%"><tr align="left"><td>';
$print_buffer .= '
			<form name="f" action="">
			<input type="hidden" name="a" value="botspells">
			<table border="0" cellspacing="0" cellpadding="3">
			<tr><td>Search For:</td><td><input type="text" name="name" size="40" value="' . $namestring . '" /> <small><i>Searches name, description and casting messages</i></small></td></tr>
			<tr><td>Class:</td><td><select name="type">
			<option value="0"' . ($type == 0 ? ' selected="1"' : '') . '>------</option>
			<option value="3008"' . ($type == 3008 ? ' selected="1"' : '') . '>Bard</option>
			<option value="3015"' . ($type == 3015 ? ' selected="1"' : '') . '>Beastlord</option>
			<option value="3002"' . ($type == 3002 ? ' selected="1"' : '') . '>Cleric</option>
			<option value="3006"' . ($type == 3006 ? ' selected="1"' : '') . '>Druid</option>
			<option value="3014"' . ($type == 3014 ? ' selected="1"' : '') . '>Enchanter</option>
			<option value="3013"' . ($type == 3013 ? ' selected="1"' : '') . '>Magician</option>
			<option value="3007"' . ($type == 3007 ? ' selected="1"' : '') . '>Monk</option>
			<option value="3011"' . ($type == 3011 ? ' selected="1"' : '') . '>Necromancer</option>
			<option value="3003"' . ($type == 3003 ? ' selected="1"' : '') . '>Paladin</option>
			<option value="3004"' . ($type == 3004 ? ' selected="1"' : '') . '>Ranger</option>
			<option value="3009"' . ($type == 3009 ? ' selected="1"' : '') . '>Rogue</option>
			<option value="3005"' . ($type == 3005 ? ' selected="1"' : '') . '>Shadowknight</option>
			<option value="3010"' . ($type == 3010 ? ' selected="1"' : '') . '>Shaman</option>
			<option value="3001"' . ($type == 3001 ? ' selected="1"' : '') . '>Warrior</option>
			<option value="3012"' . ($type == 3012 ? ' selected="1"' : '') . '>Wizard</option>
			</select></td></tr>
			<tr><td>Spell Type:</td><td><select name="spelltype">
			<option value="0"' . ($spelltype == 0 ? ' selected="1"' : '') . '>------</option>
			<option value="1"' . ($spelltype == 1 ? ' selected="1"' : '') . '>Nuke</option>
			<option value="2"' . ($spelltype == 2 ? ' selected="1"' : '') . '>Heal</option>
			<option value="4"' . ($spelltype == 4 ? ' selected="1"' : '') . '>Root</option>
			<option value="8"' . ($spelltype == 8 ? ' selected="1"' : '') . '>Buff</option>
			<option value="16"' . ($spelltype == 16 ? ' selected="1"' : '') . '>Escape</option>
			<option value="32"' . ($spelltype == 32 ? ' selected="1"' : '') . '>Pet</option>
			<option value="64"' . ($spelltype == 64 ? ' selected="1"' : '') . '>Lifetap</option>
			<option value="128"' . ($spelltype == 128 ? ' selected="1"' : '') . '>Snare</option>
			<option value="256"' . ($spelltype == 256 ? ' selected="1"' : '') . '>DoT</option>
			<option value="512"' . ($spelltype == 512 ? ' selected="1"' : '') . '>Dispel</option>
			<option value="1024"' . ($spelltype == 1024 ? ' selected="1"' : '') . '>In-Combat Buff</option>
			<option value="2048"' . ($spelltype == 2048 ? ' selected="1"' : '') . '>Mesmerize</option>
			<option value="4096"' . ($spelltype == 4096 ? ' selected="1"' : '') . '>Charm</option>
			<option value="8192"' . ($spelltype == 8192 ? ' selected="1"' : '') . '>Slow</option>
			<option value="16384"' . ($spelltype == 16384 ? ' selected="1"' : '') . '>Debuff</option>
			<option value="32768"' . ($spelltype == 32768 ? ' selected="1"' : '') . '>Cure</option>
			<option value="65536"' . ($spelltype == 65536 ? ' selected="1"' : '') . '>Resurrect</option>
			<option value="131072"' . ($spelltype == 131072 ? ' selected="1"' : '') . '>Hate Redux</option>
			<option value="262144"' . ($spelltype == 262144 ? ' selected="1"' : '') . '>In-Combat Buff Song</option>
			<option value="524288"' . ($spelltype == 524288 ? ' selected="1"' : '') . '>Out-of-Combat Buff</option>
			<option value="1048576"' . ($spelltype == 1048576 ? ' selected="1"' : '') . '>Pre-Combat Buff</option>
			<option value="2097152"' . ($spelltype == 2097152 ? ' selected="1"' : '') . '>Pre-Combat Buff Song</option>
			<tr><td>Level:</td><td><select name="level">
			<option value="">-----</option>';

for ($i = 1; $i <= $server_max_level; $i++) {
    $print_buffer .= '<option value="' . $i . '"' . ($level == $i ? ' selected="1"' : '') . '>' . $i . '</option>';
}

$print_buffer .= '</select>
				<label><input type="radio" name="opt" value="1" ' . $check1 . ' />Only</label>
				<label><input type="radio" name="opt" value="2" ' . $check2 . ' />And Higher</label>
				<label><input type="radio" name="opt" value="3" ' . $check3 . ' />And Lower</label></td></tr>
			';
$print_buffer .= '
				<tr><td><label><input type="radio" name="opt" value="4" ' . $check4 . ' />Between</label></td></tr>
				<tr><td>Max Level: </td><td>
				<select name="leveltwo">
				<option value="">-----</option>
			';
for ($i = 1; $i <= $server_max_level; $i++) {
	$print_buffer .= '<option value="' . $i . '"' . ($leveltwo == $i ? ' selected="1"' : '') . '>' . $i . '</option>';
}

$print_buffer .= '</select></td></tr>
			<tr>
			<td colspan="2">
			<br>
			<a class="button submit">Search</a>
            <a class="button" href="?a=botspells">Reset</a>
			</td>
			</td></tr>
			</table>
			</form>';
/* End Display Spell Form */

/* Start Data Pull */

if (($type != 0 && $level != 0) || $namestring != '') {
    if (!$level) {
        $level = 0;
        $ClassOper = ">";
    }
    $sql = 'SELECT 
			b.id AS bs_id, b.npc_spells_id as bs_class, b.type as bs_type, b.spell_name, b.minlevel, b.maxlevel, b.priority, s.*
			FROM ' . $bot_spells_table . ' b
			INNER JOIN
			' . $spells_table . ' s ON s.id = b.spellid
			WHERE';

    if ($type) {
		if ($opt == 4) {
			$sql .= ' b.npc_spells_id = ' . $type . ' 
				AND (b.minlevel ' . $ClassOper . ' ' . $level . ' AND ' . $leveltwo . '
				OR b.maxlevel ' . $ClassOper . ' ' . $level . ' AND ' . $leveltwo . ')
				 AND';
		} else {
			$sql .= ' b.npc_spells_id = ' . $type . ' AND b.minlevel ' . $ClassOper . ' ' . $level . ' AND';
		}
    }
    $sql .= ' b.minlevel <= ' . $server_max_level . ' AND b.spell_name LIKE \'%' . addslashes($namestring) . '%\'';
    if ($use_spell_globals == TRUE) {
        $sql .= ' AND ISNULL((SELECT ' . $spell_globals_table . '.spellid FROM ' . $spell_globals_table . '
				WHERE ' . $spell_globals_table . '.spellid = b.id))';
    }
	if ($spelltype AND $spelltype > 0) {
		$sql .= ' AND b.`type` = ' . $spelltype . '';
	}
    if ($type != 0) {
        $sql .= ' ORDER BY b.minlevel, b.spell_name';
    } else {
        $sql .= ' ORDER BY b.minlevel, b.spell_name LIMIT ' . $max_items_returned;
    }

    $result = db_mysql_query($sql);
    if (!$result) {
        die('Invalid query: ' . mysqli_error());
    }

    $print_buffer .= ' <table border="0" cellpadding="1" cellspacing="1" style="width:90%">';
    $LevelCheck = $level + $OpDiff;
	#$ClassName = $dbclasses[$type-3000];

    $RowClass = "lr";
    while ($row = mysqli_fetch_array($result)) {
        /* This will only come through when the Level Changes */
        $DBSkill = $dbskills[$row["skill"]];
        if ($LevelCheck != $row["minlevel"]) {
            $LevelCheck = $row["minlevel"];
            $print_buffer .= '<tr><td colspan="4"><b>Level: ' . $row['minlevel'] . '</b></td></tr>';
            $print_buffer .= '<tr>
					<td class="menuh" align=center colspan=2>Name</td>
					<td class="menuh" align=center>Class</td>
					<td class="menuh" align=center>Level Range</td>
					<td class="menuh" align=center>Category</td>
					<td class="menuh" align=center>Priority</td>
					<td class="menuh" align=center>Effect(s)</td>
					<td class="menuh" align=center>Mana</td>
					<td class="menuh" align=center>Skill</td>
					<td class="menuh" align=center>Target Type</td>
				  </tr>';
        }
		$SpellCat = "Unknown.";
		$Priority = $row["priority"];
		$MaxLevel = $row["maxlevel"];
		$ClassName = $row['bs_class'] - 3000;
		$ClassName = $dbclasses[$ClassName];
		if ($row["maxlevel"] == 254) { $MaxLevel = 65; }
		if ($row["bs_type"] == 1) { $SpellCat = "Nuke"; } if ($row["bs_type"] == 2) { $SpellCat = "Heal"; } if ($row["bs_type"] == 4) { $SpellCat = "Root"; }  if ($row["bs_type"] == 8) { $SpellCat = "Buff"; } 
		if ($row["bs_type"] == 16) { $SpellCat = "Escape"; } if ($row["bs_type"] == 32) { $SpellCat = "Pet"; } if ($row["bs_type"] == 64) { $SpellCat = "Lifetap"; }  if ($row["bs_type"] == 128) { $SpellCat = "Snare"; } 
		if ($row["bs_type"] == 256) { $SpellCat = "DoT"; } if ($row["bs_type"] == 512) { $SpellCat = "Dispel"; } if ($row["bs_type"] == 1024) { $SpellCat = "In-Combat Buff"; }  if ($row["bs_type"] == 2048) { $SpellCat = "Mez"; } 
		if ($row["bs_type"] == 4096) { $SpellCat = "Charm"; } if ($row["bs_type"] == 8192) { $SpellCat = "Slow"; } if ($row["bs_type"] == 16384) { $SpellCat = "Debuff"; }  if ($row["bs_type"] == 32678) { $SpellCat = "Cure"; } 
		if ($row["bs_type"] == 65536) { $SpellCat = "Rez"; } if ($row["bs_type"] == 131072) { $SpellCat = "Hate Redux"; } if ($row["bs_type"] == 262144) { $SpellCat = "In-Combat Buff Song"; }  if ($row["bs_type"] == 524288) { $SpellCat = "Out-of-Combat Buff"; } 
		if ($row["bs_type"] == 1048576) { $SpellCat = "Pre-Combat Buff"; } if ($row["bs_type"] == 2097152) { $SpellCat = "Pre-Combat Buff Song"; } 
        $print_buffer .= '<tr class="' . $RowClass . '">
					<td align=center><a href="?a=spell&id=' . $row['id'] . '"><img src="' . $icons_url . $row['new_icon'] . '.gif" align="center" border="1" width="25px" height="25px"></a></td>
					<td align=center><a href="?a=spell&id=' . $row['id'] . '">' . $row['name'] . '</a></td>
					<td align=center>' . $ClassName . '</td>
					<td align=center><b>' . $LevelCheck . '</b><font color=grey>-><font color=black><b>' . $MaxLevel . '</b></td>
					<td align=center>' . $SpellCat . '</td>
					<td align=center>' . $Priority . '</td>
					<td align=center><small>';
		for ($n = 1; $n <= 12; $n++) {
			if ($row['effectid'.$n.''] != 10 || ($row['effectid'.$n.''] == 10 && ($row['effect_base_value'.$n.''] != 0 || $row['effect_limit_value'.$n.''] != 0 || $row['max'.$n.''] != 0))) {
				$print_buffer .= SpellDescription(getspell($row['id']), $n);
			}
		}
		$print_buffer .= '</small></td>
					<td align=center>' . $row['mana'] . '</td>
					<td align=center>' . ucwords(strtolower($DBSkill)) . '</td>
					<td align=center>';
        if ($dbspelltargets[$row["targettype"]] != "") {
            $print_buffer .= $dbspelltargets[$row["targettype"]];
        }
        $print_buffer .= '</td></tr>';

        if ($RowClass == "lr") {
            $RowClass = "dr";
        } else {
            $RowClass = "lr";
        }
    }
    $print_buffer .= '</tr></table>';
}
$print_buffer .= '</tr></table>';


?>