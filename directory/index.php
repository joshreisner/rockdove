<?php
include("../include.php");

function displayURL($url) {
	$url = str_replace('http://', '', strToLower($url));
	if (format_text_starts("www.", $url)) $url = substr($url, 4);
	if (format_text_ends("/", $url)) $url = substr($url, 0, strlen($url) - 1);
	if (strlen($url) > 25) $url = substr($url, 0, 24) . '&hellip;';
	return $url;
}

if (url_id()) {
	$p = db_grab("SELECT
		p.name,
		p.service,
		p.status,
		p.email,
		t.name tier,
		g.title gender,
		p.description,
		p.availability,
		p.address_1,
		p.address_2,
		p.zip,
		p.url,
		p.phone_mobile,
		p.phone_landline,
		p.created_date,
		p.created_user,
		u1.name created_user_name,
		p.updated_date,
		p.updated_user,
		u2.name updated_user_name,
		p.is_active,
		z.city,
		z.state
		FROM providers p
		JOIN options_tier t ON p.tier_id = t.id
		LEFT JOIN options_gender g ON p.gender_id = g.id
		LEFT JOIN zip_codes z ON p.zip = z.zip
		LEFT JOIN users u1 ON p.created_user = u1.id
		LEFT JOIN users u2 ON p.updated_user = u2.id
		WHERE p.id = " . $_GET["id"]);
	if (($p["status"] != "Approved") || !$p["is_active"] || ($p["tier"] == "Invisible")	) url_drop("id");
	echo drawTop('<a href="/directory/">Directory</a>: ' . $p["name"]);
	?>
	
	<div class="panel">
		Tier: <?=$p["tier"]?><br/>
		<? if ($p["gender"]) {?>Gender: <?=@$p["gender"]?><br/><? }?>
		<span class="list_heading">Services</span><ul>
		<? $services = db_query("SELECT s.id, s.title FROM providers_to_services p2s JOIN options_service s ON p2s.option_id = s.id WHERE p2s.object_id = {$_GET["id"]} ORDER BY s.title");
		while ($s = db_fetch($services)) {?>	
		<li>&#8226; <a href="/directory/?type=<?=$s["id"]?>"><?=$s["title"]?></a></li>
		<? }?>
		</ul>
		<? $languages = db_query("SELECT l.id, l.title FROM providers_to_languages p2l JOIN options_language l ON p2l.option_id = l.id WHERE p2l.object_id = {$_GET["id"]} ORDER BY l.title");
		if (db_found($languages)) {?>
		<span class="list_heading">Languages</span><ul>
		<?  while ($l = db_fetch($languages)) {?>	
		<li>&#8226; <?=$l["title"]?></li>
		<? }?>
		</ul>
		<? }
		if (($p["tier"] == "Public Provider") || ($p["tier"] == "Organization")) {
			echo '<span class="list_heading">Contact Info</span>';?>
			<? if ($p["email"]) {?>Email: <a href="mailto:<?=$p["email"]?>"><?=format_string($p["email"], 27)?></a><br/><? }?>
			<? if ($p["phone_landline"]) {?>Landline: <?=$p["phone_landline"]?><br/><? }?>
			<? if ($p["phone_mobile"]) {?>Mobile: <?=$p["phone_mobile"]?><br/><? }?>
			<? if (strlen($p["url"]) > 7) {?>Web: <a href="<?=$p["url"]?>"><?=displayURL($p["url"])?></a><br/><? }?>
			<? if ($p["tier"] == "Organization") {
				echo '<span class="list_heading">Address</span>';
				echo $p["address_1"] . "<br>";
				if ($p["address_2"]) echo $p["address_2"] . "<br>";
				echo $p["city"] . ", " . $p["state"] . " " . $p["zip"] . "<br>";
				//echo '<a href="http://maps.google.com/?q=999+Blake+Ave,+Brooklyn,+NY+11208&sll=40.724085,-73.994158" target="new">map</a>';
			}
		} 
		
		//awkwarkly suppress for nyu dental clinic due to google craziness
		if ($_GET['id'] != 58) {
		?>
		<span class="list_heading">Let Us Help You!</span>
		Please <a href="/contact/?type=seeker">contact us</a> and we'll work with you to find someone.	
		<?
		}
		
		if ($_SESSION["user_id"]) {?>	
		<div class="admin_panel">
			<b>Admin Info</b></br>
			<? if ($p["tier"] == "Private") {?>
			<? if ($p["email"]) {?>Email: <a href="mailto:<?=$p["email"]?>"><?=format_string($p["email"], 27)?></a><br/><? }?>
			<? if ($p["phone_landline"]) {?>Landline: <?=$p["phone_landline"]?><br/><? }?>
			<? if ($p["phone_mobile"]) {?>Mobile: <?=$p["phone_mobile"]?><br/><? }?>	
			<? if (strlen($p["url"]) > 7) {?>Web: <a href="<?=$p["url"]?>"><?=displayURL($p["url"])?></a><br/><? }?>
			<? }?>
			<? if ($p["created_user_name"]) {?>
			Created <?=format_date($p["created_date"])?> by <?=$p["created_user_name"]?><br/>
			<? }?>
			<? if ($p["updated_user_name"]) {?>
			Updated <?=format_date($p["updated_date"])?> by <?=$p["updated_user_name"]?><br/>
			<? }?>
			<a href="/admin/providers-edit.php?id=<?=$_GET["id"]?>" class="editlink">Edit this Provider</a>
		</div>
		<? }?>
	
	</div>
	
	<h2><?=$p["service"]?></h2>
	<?
	echo nl2br($p["description"]);
	if ($p["availability"]) {
		echo "<br><br>" . draw_img("/images/availability.png") . "<br>" . nl2br($p["availability"]);
	}
	
} else {
	//main page
	if (url_id("type")) {
		//eg acupunture
		$service = db_grab("SELECT 
			s.title, 
			s.description, 
			s.wiki
			FROM options_service s WHERE s.id = " . $_GET["type"]);
		echo drawTop($service['title']);
		$providers = db_table("SELECT 
				p.id, p.name, p.description, p.service, p.latitude, p.longitude, p.tier_id, t.name tier, t.color
			FROM providers_to_services p2s 
			JOIN providers p ON p2s.object_id = p.id
			JOIN options_tier t ON p.tier_id = t.id
			WHERE p.status = 'Approved' AND p2s.option_id = {$_GET["type"]}
			ORDER BY name");
	} else {
		echo drawTop("Rock Dove Provider Directory");
		$providers = db_table("SELECT p.id, p.name, p.description, p.service, p.latitude, p.longitude, p.tier_id, t.name tier, t.color FROM providers p
		JOIN options_tier t ON p.tier_id = t.id WHERE p.status = 'Approved' ORDER BY p.name");
	}

	$providerlist = "";
	$markers = array();
	$count = array("organization"=>0, "provider"=>0);
	$invisible = 0;
	foreach ($providers as $p) {
		$type = ($p["tier_id"] == 1) ? "organization" : "provider";
		$count[$type]++;
		if ($p["tier_id"] == 4) {
			$invisible++;
			continue;
		}
		$marker = "organization";
		$providerlist .= "<li>&#8226; <a href='/directory/?id=" . $p["id"] . "'>" . $p["name"] . "</a> " . $p["service"] . "</li>";
		if ($p["latitude"] && $p["longitude"]) {
			$markers[] = array(
				"latitude"=>$p["latitude"],
				"longitude"=>$p["longitude"],
				"title"=>$p["name"],
				"description"=>"<i>" . format_string($p["service"], 72) . "</i><br><br>" . format_string(str_replace("\r\n", " ", $p["description"]), 110) . "<br><br>(<a href='/directory/?id=" . $p["id"] . "'>More Info</a>)",
				"color"=>$p["color"]
			);
		}
	}
	if (count($markers)) echo draw_google_map($markers, array(40.727727275, -73.9284094625));
	?>
	<div class="panel">
	<? if (url_id("type")) {?>
	<b><?=$service["title"]?></b><br>
	<? } else {?>
	<b>Directory</b><br>
	This is the main page of the directory.  Use the links on the left to narrow your search.
	<? }?>
	<? if (!empty($service["description"])) {?>
	<?=$service["description"]?><br>
	<? if (!empty($service["wiki"])) {?>
	<a href="<?=$service["wiki"]?>">More info here</a><br>
	<? }	
	}?>
	<span class="list_heading">Let Us Help You!</span>
	Please <a href="/contact/?type=seeker">contact us</a> and we'll work with you to find someone.
	</div>
	<p>
	<?
	if (!url_id("type")) echo "There " . (($count["provider"] == 1) ? "is" : "are") . " " . 
		format_q($count["provider"], "provider", false) . " " . draw_img("/images/markers/red.png") . " and " . 
		format_q($count["organization"], "organization", false) . " " . draw_img("/images/markers/purple.png") . 
		" in the directory. ";
	echo "If you're a provider and would like to have your name added, you can <a href='/beaprovider/'>sign up here</a>.
	Know a health practitioner perfect for Rock Dove? <a href='/contact/?type=resource'>Contact us</a> to let us know.
	</p><ul>";
	echo $providerlist;
	echo "</ul>";
	if ($invisible) {
		echo "<p>";
		echo ($invisible == $count) ? "T" : "In addition, t";
		echo "here are <b>" . format_q($invisible, "additional provider", false) . "</b> that have indicated their 
		willingness to accept referrals, but asked us to keep their contact information invisible to the public.  
		Please <a href='/contact/?type=seeker'>contact us</a> and, if we feel you are a match, we will put you in touch with them.</p>";
	}
}

echo drawBottom(); ?>