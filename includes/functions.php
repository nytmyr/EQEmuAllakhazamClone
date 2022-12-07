<?php

function return_item_icon_from_icon_id($icon_id, $size = 50)
{
    global $icons_dir, $icons_url;

    if (file_exists($icons_dir . "item_" . $icon_id . ".png")) {
        return "<img src='" . $icons_url . "item_" . $icon_id . ".png' style='width:" . $size . "px;height:auto;'>";
    }

    return;
}

function wrap_content_box($content)
{
    $return_buffer = '
        <table class="container_div display_table">
            <tr>
                <td>
                ' . $content . '
                </td>
            </tr>
        </table>
    ';

    return $return_buffer;
}

function display_header($header)
{
    return '
        <tr>
            <td colspan="2">' . $header . '</td>
        </tr>
    ';
}

function display_table($content, $width = 500)
{
    $return_buffer = '
        <table class="container_div display_table" style="width:' . $width . 'px">
            ' . $content . '
        </table>
    ';

    return $return_buffer;
}

function display_row($left, $right = "")
{
    return '
        <tr>
            <td style="vertical-align:top">' . $left . '</td>
            <td style="vertical-align:top">' . $right . '</td>
        </tr>
    ';
}

function search_box($name = "", $value = "", $placeholder)
{
    return '
        <div class="search_box">
            <input name="' . $name . '" type="text" value="' . $value . '" class="search" autocomplete="off" placeholder="' . $placeholder . '">
            <a href="javascript:document.search.submit();"></a>
        </div>
    ';
}

function strip_underscores($string)
{
    $string = str_replace("_", " ", $string);

    return $string;
}

function print_query_results(
    $mysql_reference_data,
    $rows_to_return,
    $anchor_link_callout,
    $query_description, /* Example: NPCs */
    $object_description,
    $href_id_name,
    $href_name_attribute,
    $extra_field = "",
    $extra_field_description = "",
    $extra_skill = ""
) {
    global $dbskills;

    $mysql_rows_returned = mysqli_num_rows($mysql_reference_data);
    if ($mysql_rows_returned > get_max_query_results_count($rows_to_return)) {
        $mysql_rows_returned = get_max_query_results_count($rows_to_return);
        $more_objects_exist  = true;
    } else {
        $more_objects_exist = false;
    }

    if ($mysql_rows_returned == 0) {
        $return_buffer .= "<ul><li><b>No " . $query_description . " found.</b></li></ul>";
    } else {
        $return_buffer .= "<h1>" . $mysql_rows_returned . " " . ($mysql_rows_returned == 1 ? $query_description : $object_description) . " displayed";
        if ($more_objects_exist) {
            $return_buffer .= " More " . $object_description . " exist but you reached the query limit.";
        }
        $return_buffer .= "</h1>";
        $return_buffer .= "<ul>";
        for ($j = 1; $j <= $mysql_rows_returned; $j++) {
            $row = mysqli_fetch_array($mysql_reference_data);

            $return_buffer .= " <li style='text-align:left'><a href='" . $anchor_link_callout . "id=" . $row[$href_id_name] . "'>";
            if ($query_description == "npc") {
                // Clean up the name for NPCs
                $return_buffer .= get_npc_name_human_readable($row[$href_name_attribute]);
            } else {
                $return_buffer .= $row[$href_name_attribute];
            }
            $return_buffer .= " (" . $row[$href_id_name] . ")</a>";

            if ($extra_field && $extra_field_description && $extra_skill) {
                $return_buffer .= " - " . ucfirstwords(
                        str_replace("_", " " . $dbskills[$row[$extra_skill]])
                    ) . " $extra_field_description " . $row[$extra_field];
            }
            $return_buffer .= "</li>";
        }
        $return_buffer .= "</ul></ul>";
    }

    return wrap_content_box($return_buffer);
}

function get_max_query_results_count($MaxObjects)
{
    if ($MaxObjects == 0) {
        $Result = 2147483647;
    } else {
        $Result = $MaxObjects;
    }

    return $Result;
}

function get_npc_name_human_readable($DbName)
{
    $Result = str_replace(
        '-',
        '`',
        str_replace(
            '_',
            ' ',
            str_replace('#', '', str_replace('!', '', str_replace('~', '', $DbName)))
        )
    );
    for ($i = 0; $i < 10; $i++) {
        $Result = str_replace($i, '', $Result);
    }

    return $Result;
}

/** Returns the type of NPC based on the name of an NPC from its database-encoded '$DbName'.
 */
function NpcTypeFromName($DbName)
{
    global $NPCTypeArray;
    foreach ($NPCTypeArray as $key => $type) {
        $KeyCount     = substr_count($DbName, $key);
        $StringLength = strlen($DbName);
        $KeyLength    = strlen($key);
        if ($KeyCount > 0 && substr($DbName, 0, $KeyLength) == $key) {
            return $type;
        }
    }

    return "Normal";
}

// Converts the first letter of each word in $str to upper case and the rest to lower case.
function ucfirstwords($str)
{
    return ucwords(strtolower($str));
}

/** Returns the URL in the Wiki to the image illustrating the NPC with ID '$NpcId'
 *  Returns an empty string if the image does not exist in the Wiki
 */
function NpcImage($WikiServerUrl, $WikiRootName, $NpcId)
{
    $SystemCall = "wget -q \"" . $WikiServerUrl . $WikiRootName . "/index.php/Image:Npc-" . $NpcId . ".jpg\" -O -| grep \"/" . $WikiRootName . "/images\" | head -1 | sed 's;.*\\(/" . $WikiRootName . "/images/[^\"]*\\).*;\\1;'";
    $Result     = `$SystemCall`;
    if ($Result != "") {
        $Result = $WikiServerUrl . $Result;
    }

    return $Result;
}

/** Returns a human-readable translation of '$sec' seconds (for respawn times)
 *  If '$sec' is '0', returns 'time' (prints 'Spawns all the time' as a result)
 */
function translate_time($sec)
{
    if ($sec == 0) {
        $Result = "time";
    } else {
        $h      = floor($sec / 3600);
        $m      = floor(($sec - $h * 3600) / 60);
        $s      = $sec - $h * 3600 - $m * 60;
		if ($h > 25) {
			$d = ($h / 24);
			$h = $h - ($d * 24);
		}
        $Result = ($d > 1 ? "$d days " : "") . ($d == 1 ? "1 day " : "") . ($h > 1 ? "$h hours " : "") . ($h == 1 ? "1 hour " : "") . ($m > 0 ? "$m min " : "") . ($s > 0 ? "$s sec" : "");
    }

    return $Result;
}

/** Returns the rest of the euclidian division of '$d' by '$v'
 *  Returns '0' if '$v' equals '0'
 *  Supposes '$d' and '$v' are positive
 */
function modulo($d, $v)
{
    if ($v == 0) {
        $Result = 0;
    } else {
        $s      = floor($d / $v);
        $Result = $d - $v * $s;
    }
}

/** Returns the list of slot names '$val' corresponds to (as a bit field)
 */
function get_slots_string($val)
{
    global $dbslots;
    reset($dbslots);
    do {
        $key = key($dbslots);
        if ($key <= $val) {
            $val    -= $key;
            $Result .= $v . current($dbslots);
            $v      = ", ";
        }
    } while (next($dbslots));

    return $Result;
}

function get_class_usable_string($val)
{
    global $db_classes_short;
    reset($db_classes_short);
    do {
        $key = key($db_classes_short);
        if ($key <= $val) {
            $val -= $key;
            $res .= $v . current($db_classes_short);
            $v   = " ";
        }
    } while (next($db_classes_short));

    return $res;
}

function get_spell_class_usable_string($val)
{
    global $db_spell_classes;
    reset($db_spell_classes);
    do {
        $key = key($db_spell_classes);
        if ($key <= $val) {
            $val -= $key;
            $res .= $v . current($db_spell_classes);
            $v   = " ";
        }
    } while (next($db_spell_classes));

    return $res;
}

function get_race_usable_string($val)
{
    global $db_races_short;
    reset($db_races_short);
    do {
        $key = key($db_races_short);
        if ($key <= $val) {
            $val -= $key;
            $res .= $v . current($db_races_short);
            $v   = " ";
        }
    } while (next($db_races_short));

    return $res;
}

function get_size_string($val)
{
    switch ($val) {
        case 0:
            return "Tiny";
            break;
        case 1:
            return "Small";
            break;
        case 2:
            return "Medium";
            break;
        case 3:
            return "Large";
            break;
        case 4:
            return "Giant";
            break;
        default:
            return "$val?";
            break;
    }
}

function getspell($id)
{
    global $spells_table, $spell_globals_table, $use_spell_globals;
    if ($use_spell_globals == true) {
        $query = "SELECT " . $spells_table . ".* FROM " . $spells_table . " WHERE " . $spells_table . ".id=" . $id . "
			AND ISNULL((SELECT " . $spell_globals_table . ".spellid FROM " . $spell_globals_table . "
			WHERE " . $spell_globals_table . ".spellid = " . $spells_table . ".id))";
    } else {
        $query = "SELECT * FROM $spells_table WHERE id=$id";
    }
    $result = db_mysql_query($query) or message_die('functions.php', 'getspell', $query, mysqli_error());
    $s = mysqli_fetch_array($result);

    return $s;
}

function get_deity_usable_string($val)
{
    global $dbideities;
    reset($dbideities);
    do {
        $key = key($dbideities);
        if ($key <= $val) {
            $val -= $key;
            $res .= $v . current($dbideities);
            $v   = ", ";
        }
    } while (next($dbideities));

    return $res;
}

function SelectMobRace($name, $selected)
{
    global $dbiracenames;
    $return_buffer = "<SELECT name=\"$name\" style='width:100%'>";
    $return_buffer .= "<option value='0'>-</option>";
    foreach ($dbiracenames as $key => $value) {
        $return_buffer .= "<option value='" . $key . "'";
        if ($key == $selected) {
            $return_buffer .= " selected='1'";
        }
        $return_buffer .= ">" . $value . "</option>";
    }
    $return_buffer .= "</SELECT>";

    return $return_buffer;
}

function SelectMobBodyType($name, $selected)
{
    global $dbbodytypes;
    $return_buffer = "<SELECT name=\"$name\" style='width:100%'>";
    $return_buffer .= "<option value='0'>-</option>";
    foreach ($dbbodytypes as $key => $value) {
        $return_buffer .= "<option value='" . $key . "'";
        if ($key == $selected) {
            $return_buffer .= " selected='1'";
        }
        $return_buffer .= ">" . $value . "</option>";
    }
    $return_buffer .= "</SELECT>";

    return $return_buffer;
}

function SelectLevel($name, $maxlevel, $selevel)
{
    $return_buffer = "<SELECT name=\"$name\">";
    $return_buffer .= "<option value='0'>-</option>";
    for ($i = 1; $i <= $maxlevel; $i++) {
        $return_buffer .= "<option value='" . $i . "'";
        if ($i == $selevel) {
            $return_buffer .= " selected='1'";
        }
        $return_buffer .= ">$i</option>";
    }
    $return_buffer .= "</SELECT>";

    return $return_buffer;
}

function SelectTradeSkills($name, $selected)
{
    $return_buffer = "<SELECT name=\"$name\">";
    $return_buffer .= WriteIt("0", "-", $selected);
    $return_buffer .= WriteIt("59", "Alchemy", $selected);
    $return_buffer .= WriteIt("60", "Baking", $selected);
    $return_buffer .= WriteIt("63", "Blacksmithing", $selected);
    $return_buffer .= WriteIt("65", "Brewing", $selected);
    $return_buffer .= WriteIt("55", "Fishing", $selected);
    $return_buffer .= WriteIt("64", "Fletching", $selected);
    $return_buffer .= WriteIt("68", "Jewelery Making", $selected);
    $return_buffer .= WriteIt("56", "Poison Making", $selected);
    $return_buffer .= WriteIt("69", "Pottery Making", $selected);
    $return_buffer .= WriteIt("58", "Research", $selected);
    $return_buffer .= WriteIt("61", "Tailoring", $selected);
    $return_buffer .= WriteIt("57", "Tinkering", $selected);
    $return_buffer .= "</SELECT>";

    return $return_buffer;
}

function WriteIt($value, $name, $sel)
{
    $return_buffer = "  <option value='" . $value . "'";
    if ($value == $sel) {
        $return_buffer .= " selected='1'";
    }
    $return_buffer .= ">$name</option>";

    return $return_buffer;
}

function get_item_stat_string($name, $stat, $stat2 = 0, $stat2color = "")
{
    $PrintString = "";
    if (is_numeric($stat)) {
        if ($stat != 0 || $stat2 != 0) {
            $PrintString .= "<tr><td><b>" . $name . ": </b></td><td style='text-align:right'>";
            if ($stat < 0) {
                $PrintString .= "<font color='red'>" . sign($stat) . "</font>";
            } else {
                $PrintString .= $stat;
            }
            if ($stat2 < 0) {
                $PrintString .= "<font color='red'> " . sign($stat2) . "</font>";
            } elseif ($stat2 > 0) {
                if ($stat2color) {
                    $PrintString .= "<font color='" . $stat2color . "'> " . sign($stat2) . "</font>";
                } else {
                    $PrintString .= sign($stat2);
                }
            }
            $PrintString .= "</td></tr>";
        }
    } else {
        if (preg_replace("[^0-9]", "", $stat) > 0) {
            $PrintString .= "<tr><td ><b>" . $name . ": </b></td><td style='text-align:right'>" . $stat . "</td></tr>";
        }
    }

    return $PrintString;
}

// spell_effects.cpp int Mob::CalcSpellEffectValue_formula(int formula, int base, int max, int caster_level, int16 spell_id)
function CalcSpellEffectValue($form, $base, $max, $lvl)
{
    // $return_buffer .= " (base=$base form=$form max=$max, lvl=$lvl)";
    $sign   = 1;
    $ubase  = abs($base);
    $result = 0;
    if (($max < $base) AND ($max != 0)) {
        $sign = -1;
    }
    switch ($form) {
        case 0:
        case 100:
            $result = $ubase;
            break;
        case 101:
            $result = $ubase + $sign * ($lvl / 2);
            break;
        case 102:
            $result = $ubase + $sign * $lvl;
            break;
        case 103:
            $result = $ubase + $sign * $lvl * 2;
            break;
        case 104:
            $result = $ubase + $sign * $lvl * 3;
            break;
        case 105:
			$result = $ubase + $sign + $lvl * 4;
            break;
        case 107:
            $result = floor($ubase + $sign + $lvl / 2);
            break;
        case 108:
            $result = floor($ubase + $sign + $lvl / 3);
            break;
        case 109:
            $result = floor($ubase + $sign + $lvl / 4);
            break;
        case 110:
			$result = floor($ubase + $sign + $lvl / 5);
            break;
        case 111:
            $result = $ubase + 5 * ($lvl - 16);
            break;
        case 112:
            $result = $ubase + 8 * ($lvl - 24);
            break;
        case 113:
            $result = $ubase + 12 * ($lvl - 34);
            break;
        case 114:
            $result = $ubase + 15 * ($lvl - 44);
            break;
        case 115:
            $result = $ubase + 15 * ($lvl - 54);
            break;
        case 116:
            $result = floor($ubase + 8 * ($lvl - 24));
            break;
        case 117:
            $result = $ubase + 11 * ($lvl - 34);
            break;
        case 118:
            $result = $ubase + 17 * ($lvl - 44);
            break;
        case 119:
            $result = floor($ubase + $lvl / 8);
            break;
        case 121:
            $result = floor($ubase + $lvl / 3);
            break;
		case 123:
			if ($lvl == 1) {
				$result = $ubase;
			} else {
				$result = $ubase * $ubase;
			}
            break;

        default:
            if ($form < 100) {
                $result = $ubase + ($lvl * $form);
            }
    } // end switch
    if ($max != 0) {
        if ($sign == 1) {
            if ($result > $max) {
                $result = $max;
            }
        } else {
            if ($result < $max) {
                $result = $max;
            }
        }
    }
    if (($base < 0) && ($result > 0)) {
        $result *= -1;
    }

    return $result;
}

function CalcBuffDuration($lvl, $form, $duration)
{ // spells.cpp, carefull, return value in ticks, not in seconds
    //$return_buffer .= " Duration lvl=$lvl, form=$form, duration=$duration ";
    switch ($form) {
        case 0:
            return 0;
            break;
        case 1:
            $i = ceil($lvl / 2);

            return ($i < $duration ? ($i < 1 ? 1 : $i) : $duration);
            break;
        case 2:
            $i = ceil($duration / 5 * 3);

            return ($i < $duration ? ($i < 1 ? 1 : $i) : $duration);
            break;
        case 3:
            $i = $lvl * 30;

            return ($i < $duration ? ($i < 1 ? 1 : $i) : $duration);
            break;
        case 4:
            return $duration;
            break;
        case 5:
            $i = $duration;

            return ($i < 3 ? ($i < 1 ? 1 : $i) : 3);
            break;
        case 6:
            $i = ceil($lvl / 2);

            return ($i < $duration ? ($i < 1 ? 1 : $i) : $duration);
            break;
        case 7:
            $i = $lvl;

            return ($i < $duration ? ($i < 1 ? 1 : $i) : $duration);
            break;
        case 8:
            $i = $lvl + 10;

            return ($i < $duration ? ($i < 1 ? 1 : $i) : $duration);
            break;
        case 9:
            $i = $lvl * 2 + 10;

            return ($i < $duration ? ($i < 1 ? 1 : $i) : $duration);
            break;
        case 10:
            $i = $lvl * 3 + 10;

            return ($i < $duration ? ($i < 1 ? 1 : $i) : $duration);
            break;
        case 11:
        case 12:
            return $duration;
            break;
        case 50:
            return 72000;
        case 3600:
            return ($duration ? $duration : 3600);
    }
}

function MaxDurationLevel($lvl, $form, $duration)
{ // spells.cpp, carefull, return value in ticks, not in seconds
    //$return_buffer .= " Duration lvl=$lvl, form=$form, duration=$duration ";
    switch ($form) {
        case 0:
            return $lvl;
            break;
        case 1:
		case 6:
			if ($lvl / 2 >= $duration) {
				return $lvl;
			} else {
				return $duration * 2;
			}
            break;
        case 2:
            return $lvl;
            break;
        case 3:
			if ($lvl * 30 >= $duration) {
				return $lvl;
			} else {
				return $duration / 30;
			}
            break;
        case 4:
        case 5:
        case 7:
			return $lvl;
            break;
        case 8:
            if ($lvl + 10 >= $duration) {
				return $lvl;
			} else {
				return $duration - 10;
			}
            break;
        case 9:
            if (($lvl * 2) + 10 >= $duration) {
				return $lvl;
			} else {
				return ($duration / 2) - 10;
			}
        case 10:
            if (($lvl * 3) + 10 >= $duration) {
				return $lvl;
			} else {
				return ($duration / 3) - 10;
			}
        case 11:
        case 12:
		case 13:
		case 14:
		case 15:
        case 50:
		case 51:
        case 3600:
            return $lvl;
			break;
    }
}

function SpecialAttacks($att)
{
    $data = '';
    $v    = '';
    // from mobs.h
    for ($i = 0; $i < strlen($att); $i++) {
        switch ($att{$i}) {
            case 'A' :
                $data .= $v . " Immune to melee";
                $v    = ', ';
                break;
            case 'B' :
                $data .= $v . " Immune to magic";
                $v    = ', ';
                break;
            case 'C' :
                $data .= $v . " Uncharmable";
                $v    = ', ';
                break;
            case 'D' :
                $data .= $v . " Unfearable";
                $v    = ', ';
                break;
            case 'E' :
                $data .= $v . " Enrage";
                $v    = ', ';
                break;
            case 'F' :
                $data .= $v . " Flurry";
                $v    = ', ';
                break;
            case 'f' :
                $data .= $v . " Immune to fleeing";
                $v    = ', ';
                break;
            case 'I' :
                $data .= $v . " Unsnarable";
                $v    = ', ';
                break;
            case 'M' :
                $data .= $v . " Unmezzable";
                $v    = ', ';
                break;
            case 'N' :
                $data .= $v . " Unstunable";
                $v    = ', ';
                break;
            case 'O' :
                $data .= $v . " Immune to melee except bane";
                $v    = ', ';
                break;
            case 'Q' :
                $data .= $v . " Quadruple Attack";
                $v    = ', ';
                break;
            case 'R' :
                $data .= $v . " Rampage";
                $v    = ', ';
                break;
            case 'S' :
                $data .= $v . " Summon";
                $v    = ', ';
                break;
            case 'T' :
                $data .= $v . " Triple Attack";
                $v    = ', ';
                break;
            case 'U' :
                $data .= $v . " Unslowable";
                $v    = ', ';
                break;
            case 'W' :
                $data .= $v . " Immune to melee except magical";
                $v    = ', ';
                break;
        }
    }

    return $data;
}

function SpecialAbilities($att)
{
	$SpecialAbilities = $att;
	$SpecialAbilitiesArray = explode ("^", $SpecialAbilities); 
    $data = '';
    $v    = '';
    foreach ($SpecialAbilitiesArray as $sab) {
		if (preg_match('/\b^2,1\b/', $sab)) {
			$data .= $v . " Enrages";
			$v = ', ';
		}
		if (preg_match('/\b^3,1\b/', $sab)) {
			$data .= $v . " Rampages";
			$v = ', ';
		}
		if (preg_match('/\b^4,1\b/', $sab)) {
			$data .= $v . " AE Rampages";
			$v = ', ';
		}
		if (preg_match('/\b^5,1\b/', $sab)) {
			$data .= $v . " Flurries";
			$v = ', ';
		}
		if (preg_match('/\b^6,1\b/', $sab)) {
			$data .= $v . " Triple Attack";
			$v = ', ';
		}
		if (preg_match('/\b^7,1\b/', $sab)) {
			$data .= $v . " Quad Attack";
			$v = ', ';
		}
		if (preg_match('/\b^8,1\b/', $sab)) {
			$data .= $v . " Dual Wield";
			$v = ', ';
		}
		if (preg_match('/\b^9,1\b/', $sab)) {
			$data .= $v . " Bane Attack";
			$v = ', ';
		}
		if (preg_match('/\b^10,1\b/', $sab)) {
			$data .= $v . " Magic Attack";
			$v = ', ';
		}
		if (preg_match('/\b^12,1\b/', $sab)) {
			$data .= $v . " Unslowable";
			$v = ', ';
		}
		if (preg_match('/\b^13,1\b/', $sab)) {
			$data .= $v . " Unmezzable";
			$v = ', ';
		}
		if (preg_match('/\b^14,1\b/', $sab)) {
			$data .= $v . " Uncharmable";
			$v = ', ';
		}
		if (preg_match('/\b^15,1\b/', $sab)) {
			$data .= $v . " Unstunnable";
			$v = ', ';
		}
		if (preg_match('/\b^16,1\b/', $sab)) {
			$data .= $v . " Unsnarable";
			$v = ', ';
		}
		if (preg_match('/\b^17,1\b/', $sab)) {
			$data .= $v . " Unfearable";
			$v = ', ';
		}
		if (preg_match('/\b^18,1\b/', $sab)) {
			$data .= $v . " Immune to Dispel";
			$v = ', ';
		}
		if (preg_match('/\b^19,1\b/', $sab)) {
			$data .= $v . " Immune to Melee";
			$v = ', ';
		}
		if (preg_match('/\b^20,1\b/', $sab)) {
			$data .= $v . " Immune to Magic";
			$v = ', ';
		}
		if (preg_match('/\b^21,1\b/', $sab)) {
			$data .= $v . " Does not flee";
			$v = ', ';
		}
		if (preg_match('/\b^22,1\b/', $sab)) {
			$data .= $v . " Immune to Non-Bane Melee";
			$v = ', ';
		}
		if (preg_match('/\b^23,1\b/', $sab)) {
			$data .= $v . " Immune to Non-Magic Melee";
			$v = ', ';
		}
		if (preg_match('/\b^26,1\b/', $sab)) {
			$data .= $v . " Resists Ranged Spells";
			$v = ', ';
		}
		if (preg_match('/\b^27,1\b/', $sab)) {
			$data .= $v . " Sees through Feign Death";
			$v = ', ';
		}
		if (preg_match('/\b^28,1\b/', $sab)) {
			$data .= $v . " Immune to Taunt";
			$v = ', ';
		}
		if (preg_match('/\b^31,1\b/', $sab)) {
			$data .= $v . " Unpacifiable";
			$v = ', ';
		}
	}

    return $data;
}

function price($price)
{
    $res = "";
    if ($price >= 1000) {
        $p     = floor($price / 1000);
        $price -= $p * 1000;
    }
    if ($price >= 100) {
        $g     = floor($price / 100);
        $price -= $g * 100;
    }
    if ($price >= 10) {
        $s     = floor($price / 10);
        $price -= $s * 10;
    }
    $c = $price;
    if ($p > 0) {
        $res = $p . "p";
        $sep = " ";
    }
    if ($g > 0) {
        $res .= $sep . $g . "g";
        $sep = " ";
    }
    if ($s > 0) {
        $res .= $sep . $s . "s";
        $sep = " ";
    }
    if ($c > 0) {
        $res .= $sep . $c . "c";
    }

    return $res;
}

function sign($val)
{
    if ($val > 0) {
        return "+$val";
    } else {
        return $val;
    }
}

function isinteger($val)
{
    return (intval($val) == $val);
}

function CanThisNPCDoubleAttack($class, $level)
{ // mob.cpp
    if ($level > 26) {
        return true;
    } #NPC over lvl 26 all double attack
    switch ($class) {
        case 0: # monks and warriors
        case 1:
        case 20:
        case 26:
        case 27:
            if ($level < 15) {
                return false;
            }
            break;
        case 9: # rogues
        case 28:
            if ($level < 16) {
                return false;
            }
            break;
        case 4: # rangers
        case 23:
        case 5: # shadowknights
        case 24:
        case 3: # paladins
        case 22:
            if ($level < 20) {
                return false;
            }
            break;
    }

    return false;
}

function Pagination($targetpage, $page, $total_pages, $limit, $adjacents)
{

    /* Setup page vars for display. */
    if ($page == 0) {
        $page = 1;
    }                    //if no page var is given, default to 1.
    $prev     = $page - 1;                            //previous page is page - 1
    $next     = $page + 1;                            //next page is page + 1
    $lastpage = ceil($total_pages / $limit);        //lastpage is = total pages / items per page, rounded up.
    $lpm1     = $lastpage - 1;                        //last page minus 1

    $pagination = "";
    if ($lastpage > 1) {
        $pagination .= "<div class=\"pagination\">";
        //previous button
        if ($page > 1) {
            $pagination .= "<a href=\"$targetpage&page=$prev\">previous</a>";
        } else {
            $pagination .= "<span class=\"disabled\">previous</span>";
        }

        //pages
        if ($lastpage < 7 + ($adjacents * 2))    //not enough pages to bother breaking it up
        {
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page) {
                    $pagination .= "<span class=\"current\">$counter</span>";
                } else {
                    $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                }
            }
        } elseif ($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
        {
            //close to beginning; only hide later pages
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<span class=\"current\">$counter</span>";
                    } else {
                        $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                    }
                }
                $pagination .= "...";
                $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
            } //in middle; hide some front and some back
            elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
                $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
                $pagination .= "...";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<span class=\"current\">$counter</span>";
                    } else {
                        $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                    }
                }
                $pagination .= "...";
                $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
            } //close to end; only hide early pages
            else {
                $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
                $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
                $pagination .= "...";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<span class=\"current\">$counter</span>";
                    } else {
                        $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                    }
                }
            }
        }

        //next button
        if ($page < $counter - 1) {
            $pagination .= "<a href=\"$targetpage&page=$next\">next</a>";
        } else {
            $pagination .= "<span class=\"disabled\">next</span>";
        }
        $pagination .= "</div>";
    }

    return $pagination;
}


// Function to build item stats tables
// Used for item.php as well as for tooltips for items
function return_item_stat_box($item, $show_name_icon)
{

    global $dbitypes, $dam2h, $dbbagtypes, $dbskills, $icons_url, $spells_table, $dbiaugrestrict, $dbiracenames, $item_first_discovered, $item_show_shard_value, $item_gear_score;

    $html_string = "";
    $html_string .= "<table width='100%'><tr><td valign='top'>";
    if ($show_name_icon) {
        $html_string .= "<h4 style='margin-top:0'>" . $item["Name"] . "</h4></td>";
        $html_string .= "<td><img src='" . $icons_url . "item_" . $item["icon"] . ".png' align='right' valign='top'/></td></tr><tr><td>";
    }

    $html_string .= "<table width='100%' cellpadding='0' cellspacing='0'>";

    /* Item Tags */
    $item_tags = "";
	
	if ($item["id"] >= 800000) {
		$html_string .= "<b>This is a Valeen item based off of <a href='?a=item&id=" . ($item["id"]-800000) . "'>" . str_replace("*","",$item["Name"]) . "</a></b><br><br>";
	}
	else if ($item["id"] >= 600000) {
		$html_string .= "<b>This is a Vegas item based off of <a href='?a=item&id=" . ($item["id"]-600000) . "'>" . str_replace("*","",$item["Name"]) . "</a></b><br><br>";
	}
	
    $html_string .= "<tr>";
    $html_string .= "<td colspan='2' nowrap='1'>";
    if ($item["itemtype"] == 54) {
        $item_tags .= " Augment";
    }
    if ($item["magic"] == 1) {
        $item_tags .= " Magic,";
    }
    if ($item["loregroup"] != 0) {
        $item_tags .= " Lore,";
    }
    if ($item["nodrop"] == 0) {
        $item_tags .= " No Trade,";
    }
    if ($item["norent"] == 0) {
        $item_tags .= " No Rent,";
    }
	if ($item["questitemflag"] == 1) {
		$item_tags .= " Quest Item,";
	}
    if ($item_tags) {
        $html_string .= substr($item_tags, 0, -1);
    }

    $html_string .= "</td></tr>";

    /* Classes */
    if ($item["classes"] > 0) {
		if ($item["scrolleffect"] > 0) {
			$v = "";
			$t = 0;
			$spell = getspell($item["scrolleffect"]);
			$html_string .= "<tr><td colspan='2'><b>Class: </b>";
			$i = 1;
			while ($i <= 16) {
				if ($spell["classes$i"] < 254) {
					$html_string .= "$v" . get_spell_class_usable_string($i) . "(" . $spell["classes$i"] . ") ";
					$t++;
				}
				$i++;
			}
			if ($t == 0) {
				$html_string .= "NONE";
			}
			$html_string .= "</td></tr>";
		} else {
			$html_string .= "<tr><td colspan='2'><b>Class: </b>" . get_class_usable_string($item["classes"]) . "</td></tr>";
		}
    }

    /* Races */
    if ($item["races"] > 0) {
        $html_string .= "<tr><td colspan='2'><b>Race: </b>" . get_race_usable_string($item["races"]) . "</td></tr>";
    }

    /* Deity */
    if ($item["deity"] > 0) {
        $html_string .= "<tr><td colspan='2' nowrap='1'><b>Deity: </b>" . get_deity_usable_string(
                $item["deity"]
            ) . "</td></tr>";
    }

    /* Slots */
    if ($item["slots"] > 0) {
        $html_string .= "<tr><td colspan='2'><b>" . get_slots_string($item["slots"]) . "</b></td></tr>";
    }
    if ($item["slots"] == 0) {
        $html_string .= "<tr><td colspan='2' ><b>Slot: </b>NONE</td></tr>";
    }

    $TypeString = "";
    switch ($item["itemtype"]) {
        case 0: // 1HS
        case 2: // 1HP
        case 3: // 1HB
        case 42: // H2H
        case 1: // 2hs
        case 4: // 2hb
        case 35: // 2hp
            $TypeString = "Skill";
            break;
        default:
            $TypeString = "Item Type";
            break;
    }
    // Item type or Skill
    // Bags show as 1HS


    // Bag-specific information
    if ($item["bagslots"] > 0) {
        $html_string .= "<tr><td width='0%' nowrap='1'><b>Item Type: </b>Container</td></tr>";
        $html_string .= "<tr><td width='0%' nowrap='1'><b>Number of Slots: </b>" . $item["bagslots"] . "</td></tr>";
        if ($item["bagtype"] > 0) {
            $html_string .= "<tr><td width='0%' nowrap='1'><b>Trade Skill Container: </b>" . $dbbagtypes[$item["bagtype"]] . "</td></tr>";
        }
		if ($item["bagwr"] && $item["bagtype"] != 2) {
			$html_string .= "<tr><td width='0%'  nowrap='1'><b>Weight Reduction: </b>" . $item["bagwr"] . "%</td></tr>";
		}
		if ($item["bagwr"] && $item["bagtype"] == 2) {
			$html_string .= "<tr><td width='0%'  nowrap='1'><b>Weight Reduction: </b>" . $item["bagwr"] . "%</td></tr>";
			$html_string .= "<tr><td width='0%'  nowrap='1'><b>Haste: ~</b>" . number_format($item["bagwr"] / 3.39) . "%</td></tr>";
		}
        $html_string .= "<tr><td width='0%' nowrap='1' colspan='2'>This can hold " . strtoupper(
                get_size_string($item["bagsize"])
            ) . " and smaller items.</td></tr>";
    }

    $html_string .= "</table>";

    $html_string .= "<br><table>";

    // Weight, Size, Rec/Req Level, skill
    $html_string .= "<tr valign='top'><td>";

    $html_string .= "<table style='width: 125px;'>";
    $html_string .= "<tr><td><b>Size: </b></td><td style='text-align:right'>" . strtoupper(
            get_size_string($item["size"])
        ) . "</td></tr>";
    $html_string .= get_item_stat_string("Weight", ($item["weight"] / 10));

    if (($dbitypes[$item["itemtype"]] != "") && ($item["bagslots"] == 0)) {
        if ($item["slots"] == 0) {
            $html_string .= "<tr><td><b>" . $TypeString . ": </b></td><td>Inventory";
        } else {
            $html_string .= "<tr><td><b>" . $TypeString . ": </b></td><td style='text-align:right'>" . $dbitypes[$item["itemtype"]];
        }
        if ($item["stackable"] > 0) {
            $html_string .= " (stackable)";
        }
        $html_string .= "</td></tr>";
    }

    $html_string .= get_item_stat_string("Rec Level", $item["reclevel"]);
    $html_string .= get_item_stat_string("Req Level", $item["reqlevel"]);
    $html_string .= "</table>";
    $html_string .= "</td><td>";

    // AC, HP, Mana, End, Haste
    $html_string .= "<table style='width: 125px;'>";
    $html_string .= get_item_stat_string("AC", $item["ac"]);
    $html_string .= get_item_stat_string("HP", $item["hp"]);
    $html_string .= get_item_stat_string("Mana", $item["mana"]);
    $html_string .= get_item_stat_string("End", $item["endur"]);
    $html_string .= get_item_stat_string("Haste", $item["haste"] . "%");
    $html_string .= "</table>";

    $html_string .= "</td><td>";

    // Base Damage, Ele/Bane/BodyType Damage, BS Damage, Delay, Range, Damage Bonus, Range
    $html_string .= "<table style='width: 125px;'>";
    $html_string .= get_item_stat_string("Base Damage", $item["damage"]);
    $html_string .= get_item_stat_string(
        ucfirstwords($dbelements[$item["elemdmgtype"]]) . " Damage",
        $item["elemdmgamt"]
    );
    if (($item["banedmgrace"] > 0) && ($item["banedmgamt"] != 0)) {
        $html_string .= "<tr><td><b>Bane Damage (";
        $html_string .= $dbiracenames[$item["banedmgrace"]];
        $html_string .= ") </b></td><td>" . sign($item["banedmgamt"]) . "</td></tr>";
    }
    $html_string .= get_item_stat_string(ucfirstwords($dbbodytypes[$item["banedmgbody"]]), $item["banedmgamt"]);
    $html_string .= get_item_stat_string("Backstab Damage", $item["backstabdmg"]);
    $html_string .= get_item_stat_string("Delay", $item["delay"]);
    if ($item["damage"] > 0) {
        switch ($item["itemtype"]) {
            case 0: // 1HS
            case 2: // 1HP
            case 3: // 1HB
            case 42: // H2H
                $dmgbonus    = 13; // floor((65-25)/3)  main hand
                $html_string .= "<tr><td><b>Damage Bonus: </b></td><td>$dmgbonus</td></tr>";
                break;
            case 1: // 2hs
            case 4: // 2hb
            case 35: // 2hp
                $dmgbonus    = $dam2h[$item["delay"]];
                $html_string .= "<tr><td><b>Damage Bonus: </b></td><td>$dmgbonus</td></tr>";
                break;
        }
    }
    $html_string .= get_item_stat_string("Range", $item["range"]);
    $html_string .= "</table>";
    $html_string .= "</td></tr><tr><td colspan='2'>&nbsp;</td></td>";

    $html_string .= "<tr valign='top'><td>";

    $html_string .= "<table style='width:100%'>";
    $html_string .= get_item_stat_string("Strength", $item["astr"], $item["heroic_str"], "#ffecca");
    $html_string .= get_item_stat_string("Stamina", $item["asta"], $item["heroic_sta"], "#ffecca");
    $html_string .= get_item_stat_string("Intelligence", $item["aint"], $item["heroic_int"], "#ffecca");
    $html_string .= get_item_stat_string("Wisdom", $item["awis"], $item["heroic_wis"], "#ffecca");
    $html_string .= get_item_stat_string("Agility", $item["aagi"], $item["heroic_agi"], "#ffecca");
    $html_string .= get_item_stat_string("Dexterity", $item["adex"], $item["heroic_dex"], "#ffecca");
    $html_string .= get_item_stat_string("Charisma", $item["acha"], $item["heroic_cha"], "#ffecca");
    $html_string .= "</table>";

    $html_string .= "</td><td>";

    $html_string .= "<table style='width:100%'>";
    $html_string .= get_item_stat_string("Magic Resist", $item["mr"], $item["heroic_mr"], "#ffecca");
    $html_string .= get_item_stat_string("Fire Resist", $item["fr"], $item["heroic_fr"], "#ffecca");
    $html_string .= get_item_stat_string("Cold Resist", $item["cr"], $item["heroic_cr"], "#ffecca");
    $html_string .= get_item_stat_string("Disease Resist", $item["dr"], $item["heroic_dr"], "#ffecca");
    $html_string .= get_item_stat_string("Poison Resist", $item["pr"], $item["heroic_pr"], "#ffecca");
    $html_string .= "</table>";

    $html_string .= "</td><td>";

    $html_string .= "<table style='width:100%'>";
    $html_string .= get_item_stat_string("Attack", $item["attack"]);
    $html_string .= get_item_stat_string("HP Regen", $item["regen"]);
    $html_string .= get_item_stat_string("Mana Regen", $item["manaregen"]);
    $html_string .= get_item_stat_string("Endurance Regen", $item["enduranceregen"]);
    $html_string .= get_item_stat_string("Spell Shielding", $item["spellshield"]);
    $html_string .= get_item_stat_string("Combat Effects", $item["combateffects"]);
    $html_string .= get_item_stat_string("Shielding", $item["shielding"]);
    $html_string .= get_item_stat_string("DoT Shielding", $item["dotshielding"]);
    $html_string .= get_item_stat_string("Avoidance", $item["avoidance"]);
    $html_string .= get_item_stat_string("Accuracy", $item["accuracy"]);
    $html_string .= get_item_stat_string("Stun Resist", $item["stunresist"]);
    $html_string .= get_item_stat_string("Strikethrough", $item["strikethrough"]);
    $html_string .= get_item_stat_string("Damage Shield", $item["damageshield"]);
    $html_string .= "</td></tr></table>";

    $html_string .= "</td></tr></table><br>";
    if ($item["extradmgamt"] > 0) {
        $html_string .= "<tr><td><b>" . ucfirstwords($dbskills[$item["extradmgskill"]]) . " Damage: </b>" . sign(
                $item["extradmgamt"]
            ) . "</td></tr>";
    }
    //	$html_string .= "</td></tr>";

    // Skill Mods
    if (($item["skillmodtype"] > 0) && ($item["skillmodvalue"] != 0)) {
        $html_string .= "<tr><td colspan='2' nowrap='1'><b>Skill Mod: " . ucfirstwords(
                $dbskills[$item["skillmodtype"]]
            ) . ": </b>" . sign($item["skillmodvalue"]) . "%</td></tr>";
    }
    // Augmentations
    for ($i = 1; $i <= 5; $i++) {
        if ($item["augslot" . $i . "type"] > 0) {
            $html_string .= "<tr><td width='0%' nowrap='1' colspan='2'><img src='images/icons/blank_slot.gif' style='width:auto;height:10px'> <b>Slot " . $i . ": </b>Type " . $item["augslot" . $i . "type"] . "</td></tr>";
        }
    }
    $html_string .= '<td><td>&nbsp;</td><td></tr>';
    //item proc
    if (($item["proceffect"] > 0) && ($item["proceffect"] < 65535)) {
        $html_string .= "<tr><td colspan='2' nowrap='1'><b>Combat Effect: </b><a href='?a=spell&id=" . $item["proceffect"] . "'>" . get_field_result(
                "name",
                "SELECT name FROM $spells_table WHERE id=" . $item["proceffect"]
            ) . "</a>";
        if ($item["proclevel2"] > 0) {
            $html_string .= "<br><b>Level for effect: </b>" . $item["proclevel2"];
        }
        $html_string .= "<br><b>Effect Chance Modifier: </b>" . (100 + $item["procrate"]) . "%";
        $html_string .= "</td></tr>";
    }
    // worn effect
    if (($item["worneffect"] > 0) && ($item["worneffect"] < 65535)) {
        $html_string .= "<tr><td colspan='2' nowrap='1'><b>Worn Effect: </b><a href='?a=spell&id=" . $item["worneffect"] . "'>" . get_field_result(
                "name",
                "SELECT name FROM $spells_table WHERE id=" . $item["worneffect"]
            ) . "</a>";
        if ($item["wornlevel"] > 0 && $item["worneffect"] != 998) {
            $html_string .= "<br><b>Level for effect: </b>" . $item["wornlevel"];
        }
		if ($item["wornlevel"] > 0 && $item["worneffect"] == 998) {
			$html_string .= " - " . $item["wornlevel"] . "<b>% Haste</b>";
		}
        $html_string .= "</td></tr>";
    }
    // focus effect
    if (($item["focuseffect"] > 0) && ($item["focuseffect"] < 65535)) {
        $html_string .= "<tr><td colspan='2' nowrap='1'><b>Focus Effect: </b><a href='?a=spell&id=" . $item["focuseffect"] . "'>" . get_field_result(
                "name",
                "SELECT name FROM $spells_table WHERE id=" . $item["focuseffect"]
            ) . "</a>";
        if ($item["focuslevel"] > 0) {
            $html_string .= "<br/><b>Level for effect: </b>" . $item["focuslevel"];
        }
        $html_string .= "</td></tr>";
    }
    // clicky effect
    if (($item["clickeffect"] > 0) && ($item["clickeffect"] < 65535)) {
        $html_string .= "<tr><td colspan='2' nowrap='1'><b>Click Effect: </b><a href='?a=spell&id=" . $item["clickeffect"] . "'>" . get_field_result(
                "name",
                "SELECT name FROM $spells_table WHERE id=" . $item["clickeffect"]
            ) . "</a> (";
        if ($item["casttime"] > 0) {
            $html_string .= "<b>Casting time: </b>" . ($item["casttime"] / 1000) . " sec";
        } else {
            $html_string .= "<b>Casting time: </b>Instant";
        }
        $html_string .= ")";
		if ($item["clicktype"] == 1) {
            $html_string .= "<br><b>Click Type:</b> Inventory with Level requirement. ";
        }
		if ($item["clicktype"] == 3) {
            $html_string .= "<br><b>Click Type:</b> Expendable. ";
        }
        if ($item["clicktype"] == 4) {
            $html_string .= "<br><b>Click Type:</b> Must Equip. ";
        }
		if ($item["clicktype"] == 5) {
            $html_string .= "<br><b>Click Type:</b> Inventory with Level/Class/Race requirement. ";
        }
        if ($item["clicklevel"] > 0) {
            $html_string .= "<br/><b>Level for effect: </b>" . $item["clicklevel"];
        }
		$spellname = get_field_result("name",
			"SELECT name
				FROM $spells_table
					WHERE id=" . $item["clickeffect"]
					)
					;
		if ($spellname == "Summon Horse") {
			$query  = "SELECT h.`mountspeed`
						FROM horses h
						INNER JOIN $spells_table s ON s.`teleport_zone` = h.`filename`
						WHERE s.`id` = " . $item["clickeffect"];
			$result = db_mysql_query($query);
			while ($row = mysqli_fetch_array($result)) {
				$html_string .= "<br/><b>Run Speed: </b>" . ($row["mountspeed"]*100) . "%<br/>";
			}
		}
        if ($item["maxcharges"] > 0) {
            $html_string .= "<br/><b>Charges: </b>" . $item["maxcharges"];
        } elseif ($item["maxcharges"] < 0) {
            $html_string .= "<br/><b>Charges: </b>Unlimited";
        } else {
            $html_string .= "<br/><b>Charges: </b>None";
        }
        $html_string .= "</td></tr>";
    }
    // scroll
    if (($item["scrolleffect"] > 0) && ($item["scrolleffect"] < 65535)) {
        $html_string .= "<tr><td colspan='2' nowrap='1'><b>Spell Scroll Effect: </b><a href='?a=spell&id=" . $item["scrolleffect"] . "'>" . get_field_result(
                "name",
                "SELECT name FROM $spells_table WHERE id=" . $item["scrolleffect"]
            ) . "</a>";
        $html_string .= "</td></tr>";
    }
    // bard item ?
    if (($item["bardtype"] > 22) && ($item["bardtype"] < 65535)) {
		if ($item["bardtype"] == 23) {
			$bardinstrument = "Wind Instruments";
		}
		if ($item["bardtype"] == 24) {
			$bardinstrument = "String Instruments";
		}
		if ($item["bardtype"] == 25) {
			$bardinstrument = "Brass Instruments";
		}
		if ($item["bardtype"] == 26) {
			$bardinstrument = "Drum Instruments";
		}
		if ($item["bardtype"] == 50) {
			$bardinstrument = "Singing";
		}
		if ($item["bardtype"] == 51) {
			$bardinstrument = "All Types";
		}
        $html_string .= "<tr><td width='0%' nowrap='1' colspan='2'><b>Bard Skill: </b> " . $bardinstrument;
        if ($bardinstrument == "") {
            $html_string .= "Unknown" . $item["bardtype"];
        }
        $val = ($item["bardvalue"] * 10) - 100;
        if ($val > 0) {
            $html_string .= " (" . $val . "%)</td></tr>";
        }
    }

    // Augmentation type
    if ($item["itemtype"] == 54) {
        if ($item["augtype"] > 0) {
            $Comma    = "";
            $AugSlots = "";
            $AugType  = $item["augtype"];
            $Bit      = 1;
            for ($i = 1; $i < 25; $i++) {
                if ($Bit <= $AugType && $Bit & $AugType) {
                    $AugSlots .= $Comma . $i;
                    $Comma    = ", ";
                }
                $Bit *= 2;
            }
            $html_string .= "<tr><td colspan='2' nowrap='1'><b>Augmentation Slot Type: </b>" . $AugSlots . "</td></tr>";
        } else {
            $html_string .= "<tr><td colspan='2' nowrap='1'><b>Augmentation Slot Type: </b>All Slots</td></tr>";
        }
        if ($item["augrestrict"] > 0) {
            if ($item["augrestrict"] > 12) {
                $html_string .= "<tr><td colspan='2' nowrap='1'><b>Augmentation Restriction: </b>Unknown Type</td></tr>";
            } else {
                $Restriction = $dbiaugrestrict[$item["augrestrict"]];
                $html_string .= "<tr><td colspan='2' nowrap='1'><b>Augmentation Restriction: </b>$Restriction</td></tr>";
            }
        }
    }

    $ItemPrice = $item["price"];
    $ItemValue = "";
    $Platinum  = 0;
    $Gold      = 0;
    $Silver    = 0;
    $Copper    = 0;

    if ($ItemPrice > 1000) {
        $Platinum = ((int)($ItemPrice / 1000));
    }
    if (($ItemPrice - ($Platinum * 1000)) > 100) {
        $Gold = ((int)(($ItemPrice - ($Platinum * 1000)) / 100));
    }
    if (($ItemPrice - ($Platinum * 1000) - ($Gold * 100)) > 10) {
        $Silver = ((int)(($ItemPrice - ($Platinum * 1000) - ($Gold * 100)) / 10));
    }
    if (($ItemPrice - ($Platinum * 1000) - ($Gold * 100) - ($Silver * 10)) > 0) {
        $Copper = ($ItemPrice - ($Platinum * 1000) - ($Gold * 100) - ($Silver * 10));
    }

    $ItemValue   .= "<tr><td><br><b>Value: </b>";
    $ItemValue   .= $Platinum . " <img src='" . $icons_url . "item_644.png' width='14' height='14'/> " .
                    $Gold . " <img src='" . $icons_url . "item_645.png' width='14' height='14'/> " .
                    $Silver . " <img src='" . $icons_url . "item_646.png' width='14' height='14'/> " .
                    $Copper . " <img src='" . $icons_url . "item_647.png' width='14' height='14'/>";
    $ItemValue   .= "</td></tr>";
    $html_string .= $ItemValue;
	
	if ($item_gear_score == true && $item["GearScore"] != 0 && $item["GearScore"] != -99999) {
		$html_string .= "<tr><td>";
		$html_string .= "<br><b>Gear Score: </b>" . number_format($item["GearScore"], 2, '.', ',') . "<br>";
		$html_string .= "</tr></td>";
	}
	
	if ($item_show_shard_value == true) {
		$itemid = 0;
		if ($item["id"] < 600000) {
			$itemid = $item["id"] + 800000;
		}
		if ($item["id"] >= 600000 && $item["id"] < 800000) {
			$itemid = $item["id"] + 200000;
		}
		if ($item["id"] >= 800000) {
			$itemid = $item["id"];
		}
			
		$query  = "SELECT i.`id`, i.`Name`, i.`GearScore`, m.`alt_currency_cost`
		, 
		CAST(CASE
			WHEN i.`GearScore` > 257 THEN i.`GearScore` * 3.25
			WHEN i.`GearScore` > 191 THEN i.`GearScore` * 3
			WHEN i.`GearScore` > 156 THEN i.`GearScore` * 2.75
			WHEN i.`GearScore` > 128 THEN i.`GearScore` * 2.5
			WHEN i.`GearScore` > 106 THEN i.`GearScore` * 2.25
			WHEN i.`GearScore` > 88 THEN i.`GearScore` * 2
			WHEN i.`GearScore` > 72 THEN i.`GearScore` * 1.75
			WHEN i.`GearScore` > 58 THEN i.`GearScore` * 1.5
			WHEN i.`GearScore` > 45 THEN i.`GearScore` * 1.25
			WHEN i.`GearScore` > 0 THEN i.`GearScore`
			ELSE 0
		END AS INT) AS Score,
		n.is_valeen_spawned AS SpawnStatus
					FROM items i
					LEFT JOIN merchantlist m ON m.`item` = $itemid
					LEFT JOIN npc_types n ON n.merchant_id = m.merchantid
					WHERE i.`id` = " . $item["id"] . "
					";
		$result = db_mysql_query($query);
		while ($row = mysqli_fetch_array($result)) {
			if ($row["alt_currency_cost"] && $row["alt_currency_cost"] != 0) {
				$html_string .= "<tr><td>";
				$html_string .= "<br><b>Shard Value: </b>" . number_format($row["alt_currency_cost"]) . "<img src='$icons_url\item_2240.png' width='50px' height='10px'/><br>";
				if ($row["SpawnStatus"] == 1) {
					$html_string .= "<br><b><font color=green>This item is <u>CURRENTLY</u> for sale on Valeen.<font color=black</b><br>";
					$html_string .= "</tr></td>";
				} else {
					$html_string .= "<br><b><font color=green>This item can be found on Valeen but is not currently being sold.<font color=black</b><br>";
					$html_string .= "</tr></td>";
				}
			} else {
				if ($row["alt_currency_cost"] != 0) {
					$html_string .= "<tr><td>";
					$html_string .= "<br><b>Shard Value: </b>" . number_format($row["Score"]) . "<img src='$icons_url\item_2240.png' width='50px' height='10px'/><br>";
					$html_string .= "<br><b><font color=red>This is not sold by Valeen.<font color=black></b><br>";
					$html_string .= "</tr></td>";
				}
			}
		}
	}

	if ($item_first_discovered == TRUE && ($item["discovered_date"] > 0)) {
		$correctedtime = $item["discovered_date"] - 7 * 60 * 60;
		$html_string .= "<td align=left><font color=green>First Acquired By: <a href='/charbrowser/index.php?page=character&char=" . $item["char_name"] . "'>" . $item["char_name"] . "</a> - " . date('m-d-Y H:i:s', $correctedtime) . " <font color=black></td>";
	} else {
		if ($item["id"] <= 800000) {
			$html_string .= "<td align=left><font color=red>Not yet acquired.<font color=black></td>";
		}
	}
    $html_string .= "<br></td></tr></table><br>";
	
    return $html_string;

}

function get_item_icon_from_id($id)
{
    global $icon_cache, $icons_url;

    if ($icon_cache[$id]) {
        return $icon_cache[$id];
    }

    $query  = "SELECT `icon` FROM `items` WHERE `id` = " . $id;
    $result = db_mysql_query($query);
    while ($row = mysqli_fetch_array($result)) {
        $icon_cache[$id] = '<img src="' . $icons_url . 'item_' . $row['icon'] . '.png" style="width:15px;height:auto">';

        return $icon_cache[$id];
    }
}

function return_scroll_id($item_id) {
	global
        $items_table;

    $query = 
		"
		SELECT i.id 
		FROM $items_table i
		WHERE i.scrolleffect = $item_id
		AND i.itemtype = 20
		AND i.scrolltype = 7
		LIMIT 1
		";

    $return_buffer = 0;
	$result = db_mysql_query($query);
    while ($row = mysqli_fetch_array($result)) {
        $return_buffer = $row["id"];
        return $return_buffer;
    }

    return;
}

function return_is_bought($item_id){

    global
        $merchant_list_table;

    $query =
		"
		SELECT $merchant_list_table.merchantid 
		FROM $merchant_list_table 
		WHERE $merchant_list_table.item = $item_id
			AND $merchant_list_table.probability > 0 
		LIMIT 1
		";

    $return_buffer = 0;
	$result = db_mysql_query($query);
    while ($row = mysqli_fetch_array($result)) {
        ++$return_buffer;
        return $return_buffer;
    }

    return;
}

function return_is_crafted($item_id){

    global
        $trade_skill_recipe_entries;

    $query =
		"
		SELECT id 
		FROM $trade_skill_recipe_entries 
		WHERE $trade_skill_recipe_entries.item_id = $item_id
			AND $trade_skill_recipe_entries.successcount > 0
		LIMIT 1
		";

    $return_buffer = 0;
	$result = db_mysql_query($query);
    while ($row = mysqli_fetch_array($result)) {
        ++$return_buffer;
        return $return_buffer;
    }

    return;
}

function return_is_dropped($item_id){

    global
        $npc_types_table,
		$loot_table_entries,
        $loot_drop_entries_table,
        $spawn2_table,
        $zones_table,
        $ignore_zones;

    $query =
		"
		SELECT item_id 
		FROM $loot_drop_entries_table 
			INNER JOIN $loot_table_entries on $loot_table_entries.lootdrop_id = $loot_drop_entries_table.lootdrop_id 
			INNER JOIN $npc_types_table ON $npc_types_table.loottable_id = $loot_table_entries.loottable_id 
		WHERE item_id = $item_id
			AND $loot_drop_entries_table.chance > 0 
			AND $loot_drop_entries_table.lootdrop_id NOT BETWEEN 310000 AND 310700
		LIMIT 1
		";

    $return_buffer = 0;
	$result = db_mysql_query($query);
    while ($row = mysqli_fetch_array($result)) {
        ++$return_buffer;
        return $return_buffer;
    }

    return;
}

function getIPAddress() {  
	$ip = getenv('HTTP_CLIENT_IP')?:
		getenv('HTTP_X_FORWARDED_FOR')?:
		getenv('HTTP_X_FORWARDED')?:
		getenv('HTTP_FORWARDED_FOR')?:
		getenv('HTTP_FORWARDED')?:
		getenv('REMOTE_ADDR');
	return $ip;  
} 