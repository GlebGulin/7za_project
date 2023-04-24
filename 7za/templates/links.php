<?php
$hoster_id = "7za";
$label = "наши сайты";

	$query = sprintf("
SELECT #___links.linked_site_id, #___links.link_text, #___links.link_url, #___links_hosters.hidden, #___links.priority
FROM #___links, #___links_hosters
WHERE
    #___links_hosters.hoster_id=\"%s\"
AND #___links_hosters.active=1
AND #___links_hosters.linked_site_id = #___links.linked_site_id 
AND #___links.active=1
AND ((#___links.publish_down IS NULL) OR (#___links.publish_down='0000-00-00 00:00:00') OR (NOW() < #___links.publish_down))
ORDER BY #___links.linked_site_id
", $hoster_id);
$query = str_replace("#_", "jos", $query);
//print($query);
global $core;
if ($result = mysql_query($query, $core->conn)) {
	$links_linked_sites = array();
	while ($link = mysql_fetch_array($result)) {
		for ($i = 0; $i < $link["priority"]; $i++) {
			$links_linked_sites[$link["linked_site_id"]][] = array("text"=>$link["link_text"], "url"=>$link["link_url"], "hidden"=>$link["hidden"]);
		}
	}
	mysql_free_result($result);
	$links = array();

function make_seed() {
	list($usec, $sec) = explode(' ', microtime());
	return (float) $sec + ((float) $usec * 100000);
}
mt_srand(make_seed());

	foreach ($links_linked_sites as $linked_site) {
		$links[] = $linked_site[mt_rand(0, count($linked_site) - 1)];
	}

	shuffle($links);

	$text = "";
	$all_hidden = 1;
	foreach ($links as $link) {
		if (!$link["hidden"]) $all_hidden = 0;
		$text .= sprintf(" <nobr><a href=\"%s\"%s>%s</a></nobr> ", $link["url"], ($link["hidden"] ? " style=\"display: none;\"" : ""), $link["text"]);
	}
	print(((!$all_hidden and $label) ? $label.": " : "").$text);
}
?>
