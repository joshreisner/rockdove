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
  if (($p["status"] != "Approved") || !$p["is_active"] || ($p["tier"] == "Invisible")  ) url_drop("id");
  echo drawTop('<a href="/directory/">Directory</a>: ' . $p["name"]);
  ?>
  
  <div class="panel">
    Tier: <?php echo $p["tier"]?><br/>
    <?php if ($p["gender"]) {?>Gender: <?php echo @$p["gender"]?><br/><?php }?>
    <span class="list_heading">Services</span><ul>
    <?php $services = db_query("SELECT s.id, s.title FROM providers_to_services p2s JOIN options_service s ON p2s.option_id = s.id WHERE p2s.object_id = {$_GET["id"]} ORDER BY s.title");
    while ($s = db_fetch($services)) {?>  
    <li>&#8226; <a href="/directory/?type=<?php echo $s["id"]?>"><?php echo $s["title"]?></a></li>
    <?php }?>
    </ul>
    <?php $languages = db_query("SELECT l.id, l.title FROM providers_to_languages p2l JOIN options_language l ON p2l.option_id = l.id WHERE p2l.object_id = {$_GET["id"]} ORDER BY l.title");
    if (db_found($languages)) {?>
    <span class="list_heading">Languages</span><ul>
    <?php  while ($l = db_fetch($languages)) {?>  
    <li>&#8226; <?php echo $l["title"]?></li>
    <?php }?>
    </ul>
    <?php }
    if (($p["tier"] == "Public Provider") || ($p["tier"] == "Organization")) {
      echo '<span class="list_heading">Contact Info</span>';?>
      <?php if ($p["email"]) {?>Email: <a href="mailto:<?php echo $p["email"]?>"><?php echo format_string($p["email"], 27)?></a><br/><?php }?>
      <?php if ($p["phone_landline"]) {?>Landline: <?php echo $p["phone_landline"]?><br/><?php }?>
      <?php if ($p["phone_mobile"]) {?>Mobile: <?php echo $p["phone_mobile"]?><br/><?php }?>
      <?php if (strlen($p["url"]) > 7) {?>Web: <a href="<?php echo $p["url"]?>"><?php echo displayURL($p["url"])?></a><br/><?php }?>
      <?php if ($p["tier"] == "Organization") {
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
    <?php
    }
    
    if ($_SESSION["user_id"]) {?>  
    <div class="admin_panel">
      <b>Admin Info</b></br>
      <?php if ($p["tier"] == "Private") {?>
      <?php if ($p["email"]) {?>Email: <a href="mailto:<?php echo $p["email"]?>"><?php echo format_string($p["email"], 27)?></a><br/><?php }?>
      <?php if ($p["phone_landline"]) {?>Landline: <?php echo $p["phone_landline"]?><br/><?php }?>
      <?php if ($p["phone_mobile"]) {?>Mobile: <?php echo $p["phone_mobile"]?><br/><?php }?>  
      <?php if (strlen($p["url"]) > 7) {?>Web: <a href="<?php echo $p["url"]?>"><?php echo displayURL($p["url"])?></a><br/><?php }?>
      <?php }?>
      <?php if ($p["created_user_name"]) {?>
      Created <?php echo format_date($p["created_date"])?> by <?php echo $p["created_user_name"]?><br/>
      <?php }?>
      <?php if ($p["updated_user_name"]) {?>
      Updated <?php echo format_date($p["updated_date"])?> by <?php echo $p["updated_user_name"]?><br/>
      <?php }?>
      <a href="/admin/providers-edit.php?id=<?php echo $_GET["id"]?>" class="editlink">Edit this Provider</a>
    </div>
    <?php }?>
  
  </div>
  
  <h2><?php echo $p["service"]?></h2>
  <?php
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
  <?php if (url_id("type")) {?>
  <b><?php echo $service["title"]?></b><br>
  <?php } else {?>
  <b>Directory</b><br>
  <p><strong>PLEASE NOTE: The Rock Dove Collective has closed our doors, and so our provider directory is not up-to-date.</strong> Feel free to browse these listings, but we recommend that you google providers to get current information about providers and services.  Use the links on the left to narrow your search.</p>
  <?php }
	  if (!empty($service["description"])) {
		  echo $service["description"] . '<br>';
		  if (!empty($service["wiki"])) {?>
		  	<a href="<?php echo $service["wiki"]?>">More info here</a><br>
  <?php }  
  }?>
  <span class="list_heading">Let Us Help You!</span>
  Please <a href="/contact/?type=seeker">contact us</a> and we'll work with you to find someone.
  </div>
  <p>
  <?php
  if (!url_id("type")) {
	  echo "There " . (($count["provider"] == 1) ? "is" : "are") . " " . 
	    format_quantitize($count["provider"], "provider", false) . " " . draw_img("/images/markers/red.png") . " and " . 
	    format_quantitize($count["organization"], "organization", false) . " " . draw_img("/images/markers/purple.png") . 
	    " in the directory. ";
}
	echo "<p>The Rock Dove Collective is no longer active and so we are no longer reviewing provider applications.</p>";}