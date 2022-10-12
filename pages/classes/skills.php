<?php

#ini_set('display_errors', 'On');
#error_reporting(E_ALL);

$page_title = "Skills";

$order = (isset($_GET['order']) ? addslashes($_GET["order"]) : "class ASC");
$opt = (isset($_GET['opt']) ? $_GET['opt'] : '');
$level = (isset($_GET['level']) ? $_GET['level'] : 0);
$class = (isset($_GET['class']) ? $_GET['class'] : 0);
$skill = (isset($_GET['skill']) ? $_GET['skill'] : -1);

$check1 = "";
$check2 = "";
$check3 = "";

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
} else {
    $check2 = "checked";
    $OpDiff = 0;
    $ClassOper = ">=";
}

/* Display Spell Form */
$print_buffer .= '<table border="0" class="display_table container_div" style="width:90%"><td>';
$print_buffer .= '
			<form name="f" action="">
			<input type="hidden" name="a" value="skills">
			<table border="0" width="0%" cellspacing="0" cellpadding="3">
			<tr><td style="text-align:left">Class:</td><td><select name="class">
			<option value="0"' . ($class == 0 ? ' selected="1"' : '') . '>------</option>
			<option value="8"' . ($class == 8 ? ' selected="1"' : '') . '>Bard</option>
			<option value="15"' . ($class == 15 ? ' selected="1"' : '') . '>Beastlord</option>
			<option value="16"' . ($class == 16 ? ' selected="1"' : '') . '>Berserker</option>
			<option value="2"' . ($class == 2 ? ' selected="1"' : '') . '>Cleric</option>
			<option value="6"' . ($class == 6 ? ' selected="1"' : '') . '>Druid</option>
			<option value="14"' . ($class == 14 ? ' selected="1"' : '') . '>Enchanter</option>
			<option value="13"' . ($class == 13 ? ' selected="1"' : '') . '>Magician</option>
			<option value="7"' . ($class == 7 ? ' selected="1"' : '') . '>Monk</option>
			<option value="11"' . ($class == 11 ? ' selected="1"' : '') . '>Necromancer</option>
			<option value="3"' . ($class == 3 ? ' selected="1"' : '') . '>Paladin</option>
			<option value="4"' . ($class == 4 ? ' selected="1"' : '') . '>Ranger</option>
			<option value="9"' . ($class == 9 ? ' selected="1"' : '') . '>Rogue</option>
			<option value="5"' . ($class == 5 ? ' selected="1"' : '') . '>Shadowknight</option>
			<option value="10"' . ($class == 10 ? ' selected="1"' : '') . '>Shaman</option>
			<option value="1"' . ($class == 1 ? ' selected="1"' : '') . '>Warrior</option>
			<option value="12"' . ($class == 12 ? ' selected="1"' : '') . '>Wizard</option>
			</select></td></tr>
			
			<t><t><tr><td style="text-align:left">Skill:</td><td><select name="skill">
			<option value="-1"' . ($skill == -1 ? ' selected="-1"' : '') . '>ALL</option>
			';
for ($i = 0; $i <= 73; $i++) {
	
	$str = $dbskills[$i];
	if (!preg_match('#[0-9]#',$str)) {
		$str = ucwords(strtolower($str));
	} else {
		$stra = explode(' ', $str);
		$strb = ucwords(strtolower($stra[1]));
		$str = $stra[0] . " " . $strb;
	}
	
	$print_buffer .= '<option value="' . $i . '"' . ($skill == $i ? ' selected="1"' : '') . '>' . $str . '</option>';
}
			$print_buffer .= '</select></td></tr>
			
			
			<tr><td>Level:</td><td><select name="level">
			<option value="">-----</option>';

for ($i = 1; $i <= $server_max_level; $i++) {
    $print_buffer .= '<option value="' . $i . '"' . ($level == $i ? ' selected="1"' : '') . '>' . $i . '</option>';
}

$print_buffer .= '</select>
			<label><input type="radio" name="opt" value="1" ' . $check1 . ' />Only</label>
			<label><input type="radio" name="opt" value="2" ' . $check2 . ' />And Higher</label>
			<label><input type="radio" name="opt" value="3" ' . $check3 . ' />And Lower</label></td></tr>
			<tr>
			<td colspan="2">
			<br>
			<a class="button submit">Search</a>
            <a class="button" href="?a=skills">Reset</a>
			</td>
			</td></tr>
			</table>
			</form>';
/* End Display Spell Form */

/* Start Data Pull */

if (($class != 0 OR $skill != -1)) {
	
    $sql = "
		SELECT
		*
		FROM
		" . $skill_table;
	$sv = '';

	if ($class != 0) {
	    $sql .= $sv . " WHERE class = " . $class . "";
		if ($skill != -1) {
			$sql .= $sv . " AND skillID = " . $skill . "";
			if ($level != 0) {
				$sql .= $sv . " AND level " . $ClassOper . " " . $level . "";
			}
		} else {
			if ($level != 0) {
				$sql .= $sv . " AND level " . $ClassOper . " " . $level . "";
			}
		}
	}
	if ($class == 0) {
		if ($skill != -1) {
			$sql .= $sv . " WHERE skillID = " . $skill . "";
			if ($level != 0) {
				$sql .= $sv . " AND level " . $ClassOper . " " . $level . "";
			}
		} else {
			if ($level != 0) {
				$sql .= $sv . " WHERE level " . $ClassOper . " " . $level . "";
			}
		}
	}
	$sql .= " ORDER BY $order";

	#$print_buffer .= $sql . '<br>';

    $result = db_mysql_query($sql);
    if (!$result) {
        die('Invalid query: ' . mysqli_error());
    }
	$url = $_SERVER['QUERY_STRING'];
	$url = str_replace("&v_ajax","",$url);
	
	$print_buffer .= "<table class='display_table container_div datatable' id='item_search_results' style='width:90%'>";
	
	$print_buffer .= "
		<thead>
			<th class='menuh'><a href=?" . $url . "&order=skillID%20asc>Skill</a></th>
			<th class='menuh'><a href=?" . $url . "&order=class%20asc>Class</a></th>
			<th class='menuh'><a href=?" . $url . "&order=level%20asc>Level</a></th>
			<th class='menuh'><a href=?" . $url . "&order=cap%20asc>Cap</a></th>
		</thead>
		";

    while ($row = mysqli_fetch_array($result)) {
		$str = $dbskills[$row['skillID']];
		if (!preg_match('#[0-9]#',$str)) {
			$str = ucwords(strtolower($str));
		} else {
			$stra = explode(' ', $str);
			$strb = ucwords(strtolower($stra[1]));
			$str = $stra[0] . " " . $strb;
		}
        $print_buffer .= '<tr>
					<td align=left>' . $str . '</td>
					<td align=left>' . $dbclasses[$row['class']] . '</td>
					<td align=left>' . $row['level'] . '</td>
					<td align=left>' . $row['cap'] . '</td>
					</tr>
					';
    }
	
	$print_buffer .= "</table>";
}
$print_buffer .= '</table>';


?>