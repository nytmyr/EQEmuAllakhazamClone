<?php

$itemtype = (isset($_GET['itemtype']) ? $_GET['itemtype'] : "null");

$page_title = "Top 10 Class Leaderboard Rankings";
$print_buffer .= "<table class=''><tr valign=top><td>";
$print_buffer .= "<h1>Choose a Class</h1><ul style='text-align:left'>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=topwarrior id='leaderboard_byclass'>Top Warrior</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=topcleric id='leaderboard_byclass'>Top Cleric</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=toppaladin id='leaderboard_byclass'>Top Paladin</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=topranger id='leaderboard_byclass'>Top Ranger</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=topshadowknight id='leaderboard_byclass'>Top Shadowknight</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=topdruid id='leaderboard_byclass'>Top Druid</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=topmonk id='leaderboard_byclass'>Top Monk</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=topbard id='leaderboard_byclass'>Top Bard</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=toprogue id='leaderboard_byclass'>Top Rogue</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=topshaman id='leaderboard_byclass'>Top Shaman</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=topnecromancer id='leaderboard_byclass'>Top Necromancer</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=topwizard id='leaderboard_byclass'>Top Wizard</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=topmagician id='leaderboard_byclass'>Top Magician</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=topenchanter id='leaderboard_byclass'>Top Enchanter</a>";
$print_buffer .= "<li><a href=?a=leaderboard_byclass&itemtype=topbeastlord id='leaderboard_byclass'>Top Beastlord</a>";
$print_buffer .= "</ul>";

if (isset($itemtype) && $itemtype != "null") {
	
	if ($itemtype == "topwarrior") {
		$print_buffer .= "<h1>Choose a Stat for Warriors</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarrioraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "topwarriorhp") {
		$print_buffer .= "<h1>Choose a Stat for Warriors</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarrioraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Warriors" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'Warrior'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topwarriorac") {
		$print_buffer .= "<h1>Choose a Stat for Warriors</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarrioraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Warriors" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'Warrior'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topwarrioraa") {
		$print_buffer .= "<h1>Choose a Stat for Warriors</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarrioraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Warriors" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'Warrior'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topwarriorresists") {
		$print_buffer .= "<h1>Choose a Stat for Warriors</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarrioraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwarriorresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Warriors" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'Warrior'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topcleric") {
		$print_buffer .= "<h1>Choose a Stat for Clerics</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclerichp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericmana id='leaderboard'>Top Mana</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "topclerichp") {
		$print_buffer .= "<h1>Choose a Stat for Clerics</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclerichp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Clerics" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'Cleric'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topclericmana") {
		$print_buffer .= "<h1>Choose a Stat for Clerics</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclerichp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Mana for Clerics" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`mana` AS Mana
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`mana` > 0
			AND c.`class` = 'Cleric'
			ORDER BY c.`mana` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Mana</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Mana"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topclericac") {
		$print_buffer .= "<h1>Choose a Stat for Clerics</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclerichp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Clerics" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'Cleric'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topclericaa") {
		$print_buffer .= "<h1>Choose a Stat for Clerics</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclerichp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Clerics" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'Cleric'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topclericresists") {
		$print_buffer .= "<h1>Choose a Stat for Clerics</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclerichp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topclericresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Clerics" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'Cleric'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "toppaladin") {
		$print_buffer .= "<h1>Choose a Stat for Paladins</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinmana id='leaderboard'>Top Mana</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "toppaladinhp") {
		$print_buffer .= "<h1>Choose a Stat for Paladins</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Paladins" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'paladin'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "toppaladinmana") {
		$print_buffer .= "<h1>Choose a Stat for Paladins</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Mana for Paladins" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`mana` AS Mana
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`mana` > 0
			AND c.`class` = 'paladin'
			ORDER BY c.`mana` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Mana</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Mana"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "toppaladinac") {
		$print_buffer .= "<h1>Choose a Stat for Paladins</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Paladins" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'paladin'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "toppaladinaa") {
		$print_buffer .= "<h1>Choose a Stat for Paladins</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Paladins" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'paladin'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "toppaladinresists") {
		$print_buffer .= "<h1>Choose a Stat for Paladins</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toppaladinresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Paladins" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'paladin'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topranger") {
		$print_buffer .= "<h1>Choose a Stat for Rangers</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangermana id='leaderboard'>Top Mana</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangeraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "toprangerhp") {
		$print_buffer .= "<h1>Choose a Stat for Rangers</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangeraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Rangers" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'ranger'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "toprangermana") {
		$print_buffer .= "<h1>Choose a Stat for Rangers</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangeraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Mana for Rangers" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`mana` AS Mana
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`mana` > 0
			AND c.`class` = 'ranger'
			ORDER BY c.`mana` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Mana</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Mana"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "toprangerac") {
		$print_buffer .= "<h1>Choose a Stat for Rangers</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangeraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Rangers" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'ranger'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "toprangeraa") {
		$print_buffer .= "<h1>Choose a Stat for Rangers</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangeraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Rangers" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'ranger'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "toprangerresists") {
		$print_buffer .= "<h1>Choose a Stat for Rangers</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangeraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprangerresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Rangers" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'ranger'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topshadowknight") {
		$print_buffer .= "<h1>Choose a Stat for Shadowknights</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknighthp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightmana id='leaderboard'>Top Mana</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "topshadowknighthp") {
		$print_buffer .= "<h1>Choose a Stat for Shadowknights</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknighthp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Shadowknights" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'shadowknight'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topshadowknightmana") {
		$print_buffer .= "<h1>Choose a Stat for Shadowknights</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknighthp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Mana for Shadowknights" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`mana` AS Mana
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`mana` > 0
			AND c.`class` = 'shadowknight'
			ORDER BY c.`mana` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Mana</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Mana"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topshadowknightac") {
		$print_buffer .= "<h1>Choose a Stat for Shadowknights</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknighthp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Shadowknights" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'shadowknight'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topshadowknightaa") {
		$print_buffer .= "<h1>Choose a Stat for Shadowknights</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknighthp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Shadowknights" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'shadowknight'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topshadowknightresists") {
		$print_buffer .= "<h1>Choose a Stat for Shadowknights</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknighthp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshadowknightresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Shadowknights" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'shadowknight'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topdruid") {
		$print_buffer .= "<h1>Choose a Stat for Druids</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidmana id='leaderboard'>Top Mana</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "topdruidhp") {
		$print_buffer .= "<h1>Choose a Stat for Druids</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Druids" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'druid'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topdruidmana") {
		$print_buffer .= "<h1>Choose a Stat for Druids</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Mana for Druids" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`mana` AS Mana
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`mana` > 0
			AND c.`class` = 'druid'
			ORDER BY c.`mana` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Mana</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Mana"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topdruidac") {
		$print_buffer .= "<h1>Choose a Stat for Druids</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Druids" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'druid'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topdruidaa") {
		$print_buffer .= "<h1>Choose a Stat for Druids</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Druids" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'druid'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topdruidresists") {
		$print_buffer .= "<h1>Choose a Stat for Druids</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topdruidresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Druids" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'druid'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topmonk") {
		$print_buffer .= "<h1>Choose a Stat for Monks</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "topmonkhp") {
		$print_buffer .= "<h1>Choose a Stat for Monks</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Monks" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'monk'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topmonkac") {
		$print_buffer .= "<h1>Choose a Stat for Monks</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Monks" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'monk'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topmonkaa") {
		$print_buffer .= "<h1>Choose a Stat for Monks</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Monks" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'monk'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topmonkresists") {
		$print_buffer .= "<h1>Choose a Stat for Monks</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmonkresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Monks" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'monk'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topbard") {
		$print_buffer .= "<h1>Choose a Stat for Bards</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardmana id='leaderboard'>Top Mana</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "topbardhp") {
		$print_buffer .= "<h1>Choose a Stat for Bards</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Bards" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'bard'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topbardmana") {
		$print_buffer .= "<h1>Choose a Stat for Bards</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Mana for Bards" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`mana` AS Mana
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`mana` > 0
			AND c.`class` = 'bard'
			ORDER BY c.`mana` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Mana</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Mana"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topbardac") {
		$print_buffer .= "<h1>Choose a Stat for Bards</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Bards" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'bard'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topbardaa") {
		$print_buffer .= "<h1>Choose a Stat for Bards</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Bards" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'bard'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topbardresists") {
		$print_buffer .= "<h1>Choose a Stat for Bards</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbardresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Bards" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'bard'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "toprogue") {
		$print_buffer .= "<h1>Choose a Stat for Rogues</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toproguehp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "toproguehp") {
		$print_buffer .= "<h1>Choose a Stat for Rogues</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toproguehp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Rogues" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'rogue'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "toprogueac") {
		$print_buffer .= "<h1>Choose a Stat for Rogues</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toproguehp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Rogues" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'rogue'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "toprogueaa") {
		$print_buffer .= "<h1>Choose a Stat for Rogues</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toproguehp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Rogues" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'rogue'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "toprogueresists") {
		$print_buffer .= "<h1>Choose a Stat for Rogues</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toproguehp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=toprogueresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Rogues" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'rogue'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topshaman") {
		$print_buffer .= "<h1>Choose a Stat for Shamans</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanmana id='leaderboard'>Top Mana</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "topshamanhp") {
		$print_buffer .= "<h1>Choose a Stat for Shamans</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Shamans" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'shaman'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topshamanmana") {
		$print_buffer .= "<h1>Choose a Stat for Shamans</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Mana for Shamans" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`mana` AS Mana
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`mana` > 0
			AND c.`class` = 'shaman'
			ORDER BY c.`mana` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Mana</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Mana"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topshamanac") {
		$print_buffer .= "<h1>Choose a Stat for Shamans</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Shamans" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'shaman'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topshamanaa") {
		$print_buffer .= "<h1>Choose a Stat for Shamans</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Shamans" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'shaman'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topshamanresists") {
		$print_buffer .= "<h1>Choose a Stat for Shamans</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topshamanresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Shamans" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'shaman'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topnecromancer") {
		$print_buffer .= "<h1>Choose a Stat for Necromancers</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancermana id='leaderboard'>Top Mana</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromanceraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "topnecromancerhp") {
		$print_buffer .= "<h1>Choose a Stat for Necromancers</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromanceraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Necromancers" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'necromancer'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topnecromancermana") {
		$print_buffer .= "<h1>Choose a Stat for Necromancers</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromanceraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Mana for Necromancers" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`mana` AS Mana
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`mana` > 0
			AND c.`class` = 'necromancer'
			ORDER BY c.`mana` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Mana</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Mana"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topnecromancerac") {
		$print_buffer .= "<h1>Choose a Stat for Necromancers</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromanceraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Necromancers" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'necromancer'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topnecromanceraa") {
		$print_buffer .= "<h1>Choose a Stat for Necromancers</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromanceraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Necromancers" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'necromancer'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topnecromancerresists") {
		$print_buffer .= "<h1>Choose a Stat for Necromancers</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromanceraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topnecromancerresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Necromancers" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'necromancer'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topwizard") {
		$print_buffer .= "<h1>Choose a Stat for Wizards</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardmana id='leaderboard'>Top Mana</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "topwizardhp") {
		$print_buffer .= "<h1>Choose a Stat for Wizards</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Wizards" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'wizard'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topwizardmana") {
		$print_buffer .= "<h1>Choose a Stat for Wizards</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Mana for Wizards" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`mana` AS Mana
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`mana` > 0
			AND c.`class` = 'wizard'
			ORDER BY c.`mana` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Mana</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Mana"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topwizardac") {
		$print_buffer .= "<h1>Choose a Stat for Wizards</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Wizards" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'wizard'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topwizardaa") {
		$print_buffer .= "<h1>Choose a Stat for Wizards</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Wizards" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'wizard'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topwizardresists") {
		$print_buffer .= "<h1>Choose a Stat for Wizards</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topwizardresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Wizards" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'wizard'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topmagician") {
		$print_buffer .= "<h1>Choose a Stat for Magicians</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianmana id='leaderboard'>Top Mana</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "topmagicianhp") {
		$print_buffer .= "<h1>Choose a Stat for Magicians</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Magicians" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'magician'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topmagicianmana") {
		$print_buffer .= "<h1>Choose a Stat for Magicians</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Mana for Magicians" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`mana` AS Mana
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`mana` > 0
			AND c.`class` = 'magician'
			ORDER BY c.`mana` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Mana</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Mana"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topmagicianac") {
		$print_buffer .= "<h1>Choose a Stat for Magicians</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Magicians" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'magician'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topmagicianaa") {
		$print_buffer .= "<h1>Choose a Stat for Magicians</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Magicians" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'magician'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topmagicianresists") {
		$print_buffer .= "<h1>Choose a Stat for Magicians</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topmagicianresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Magicians" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'magician'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topenchanter") {
		$print_buffer .= "<h1>Choose a Stat for Enchanters</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchantermana id='leaderboard'>Top Mana</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanteraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "topenchanterhp") {
		$print_buffer .= "<h1>Choose a Stat for Enchanters</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchantermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanteraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Enchanters" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'enchanter'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topenchantermana") {
		$print_buffer .= "<h1>Choose a Stat for Enchanters</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchantermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanteraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Mana for Enchanters" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`mana` AS Mana
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`mana` > 0
			AND c.`class` = 'enchanter'
			ORDER BY c.`mana` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Mana</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Mana"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topenchanterac") {
		$print_buffer .= "<h1>Choose a Stat for Enchanters</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchantermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanteraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Enchanters" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'enchanter'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topenchanteraa") {
		$print_buffer .= "<h1>Choose a Stat for Enchanters</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchantermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanteraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Enchanters" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'enchanter'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topenchanterresists") {
		$print_buffer .= "<h1>Choose a Stat for Enchanters</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchantermana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanteraa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topenchanterresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Enchanters" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'enchanter'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topbeastlord") {
		$print_buffer .= "<h1>Choose a Stat for Beastlords</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordmana id='leaderboard'>Top Mana</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
	}
	
	if ($itemtype == "topbeastlordhp") {
		$print_buffer .= "<h1>Choose a Stat for Beastlords</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top HP for Beastlords" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`hp` AS HP
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`hp` > 0
			AND c.`class` = 'beastlord'
			ORDER BY c.`hp` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>HP</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["HP"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topbeastlordmana") {
		$print_buffer .= "<h1>Choose a Stat for Beastlords</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Mana for Beastlords" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`mana` AS Mana
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`mana` > 0
			AND c.`class` = 'beastlord'
			ORDER BY c.`mana` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Mana</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Mana"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topbeastlordac") {
		$print_buffer .= "<h1>Choose a Stat for Beastlords</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AC for Beastlords" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`ac` AS AC
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`ac` > 0
			AND c.`class` = 'beastlord'
			ORDER BY c.`ac` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AC</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AC"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topbeastlordaa") {
		$print_buffer .= "<h1>Choose a Stat for Beastlords</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top AA for Beastlords" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`aa` AS AA
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`aa` > 0
			AND c.`class` = 'beastlord'
			ORDER BY c.`aa` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>AA</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["AA"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
	
	if ($itemtype == "topbeastlordresists") {
		$print_buffer .= "<h1>Choose a Stat for Beastlords</h1><ul style='text-align:left'>";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordhp id='leaderboard'>Top HP</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordmana id='leaderboard'>Top Mana</a> -- "; #deletethis
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordac id='leaderboard'>Top AC</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordaa id='leaderboard'>Top AA</a> -- ";
		$print_buffer .= "<a href=?a=leaderboard_byclass&itemtype=topbeastlordresists id='leaderboard'>Top Resists</a>";
		$print_buffer .= "</ul>";
		
		$print_buffer .= '<h1>' . "Top Resists for Beastlords" . '</h1>';
		$query = "
			SELECT 
				c.`id` AS CharID,
				c.`name` AS CharName,
				c.`level` AS CharLevel,
				c.`race` AS CharRace,
				c.`class` AS CharClass,
				c.`resists` AS Resists
			FROM $leaderboard_table c
			INNER JOIN $character_table cd ON cd.`id` = c.`id`
			WHERE c.`status` < 100
			AND c.`resists` > 0
			AND c.`class` = 'beastlord'
			ORDER BY c.`resists` DESC
			LIMIT 10
		";
		$result = db_mysql_query($query) or message_die('achiev_items.php', 'MYSQL_QUERY', $query, mysqli_error());
		$columns = mysqli_num_fields($result);
		
		$print_buffer .= 
		"
			<table class='display_table datatable container_div'><tr>
			<td style='font-weight:bold' align=left>Character</td>
			<td style='font-weight:bold' align=center>Level</td>
			<td style='font-weight:bold' align=center>Race</td>
			<td style='font-weight:bold' align=center>Class</td>
			<td style='font-weight:bold' align=right>Resists</td>
		";
		while ($row = mysqli_fetch_array($result)) {
			$print_buffer .=
			"
				<tr>
					<td align=left><a href='/charbrowser/index.php?page=character&char=" . $row["CharID"] . "'>" . $row["CharName"] . "</a></td>
					<td align=center>" . $row["CharLevel"] . "</td>
					<td align=center>" . $row["CharRace"] . "</td>
					<td align=center>" . $row["CharClass"] . "</td>
					<td align=right>" . $row["Resists"] . "</td>
				</tr>
			";
		}
		$print_buffer .= "</table>";
		$print_buffer .= "</td><td width=0% nowrap>";
		$print_buffer .= "</td></tr></table>";
	}
}
?>
