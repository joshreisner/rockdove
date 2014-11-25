<?php
extract(joshlib());
//debug();

//security
session_start();
if (!isset($_SESSION["user_id"])) $_SESSION["user_id"] = false;
if (($_josh["request"]["folder"] == "admin") && !$_SESSION["user_id"]) url_change("/login/");


//custom functions
function alertProviderNew($providerID) {
	global $_josh;
	$to = ($_josh["request"]["host"] == "www.rockdovecollective.site") ? "josh@rockdovecollective.org" : "lauren@rockdovecollective.org, josh@rockdovecollective.org";
	email($to, "A <a href='" . url_base() . "/admin/providers-edit.php?id=" . $providerID . "'>new provider</a> has registered to be in the Directory!", "New Provider");
}

function drawBottom() {
	global $_josh;
	?>
				</div>
			</div>
		</div>
	<?php if ($_josh["request"]["folder"] != "admin") {?>
		<div id="footer"><div class="center">Have a question?  <a href="/contact/">Contact us</a>!</div></div>
	<?php }?>
		<?php echo draw_google_analytics("UA-80350-5")?>
	</body>
</html>
<?php
}

function drawButton($options) {
	$return = '<div class="control">';
	foreach ($options as $name=>$url) {
		$return .= draw_form_button($name, $url, "button");
	}
	$return .= '</div>';
	return $return;
}

function drawTop($title="Rock Dove Collective") {
	global $_josh, $_SESSION;
?><html>
	<head>
		<?php echo draw_meta_utf8()?>
		<title><?php echo strip_tags($title)?></title>
		<script language="javascript" src="/javascript.js"></script>
		<link rel="icon" type="image/png" href="/images/favicon.png">
		<link rel="stylesheet" href="/styles/screen.css">
		<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="/styles/ie.css"></style>
		<![endif]-->
		<?php echo draw_javascript()?>
	</head>
	<body>
		<a name="top"></a>
		<div id="container">
			<div id="strawpatch">
				<?php echo draw_img("/images/tolga.jpg", "/")?>
				<div id="content">
	
				<b>About Us</b>
				<?php echo draw_nav(array(
					"/mission/"=>"Mission Statement", 
					"/ethics/"=>"Code of Ethics",
					"/open-source/"=>"About this site"
					), true, "text", "strawpatch_list")?>
				
				<b>Get Involved!</b>
				<?php echo draw_nav(array(
					"/beaprovider/"=>"Be a Service Provider", 
					"/calendar/"=>"Event Calendar", 
					"/waysyoucanhelp/"=>"Ways You Can Help"
					), true, "text", "strawpatch_list")?>
				
				<b><a href="/directory/" style="margin-left:-2px;" class="<?php if ($_josh["request"]["path_query"] == "/directory/") {?>selected<?php }?>">Provider Directory</a></b>
				<ul id="treeview" class="treeview">
				<?php
				$categories = db_query("SELECT 
						c.id, 
						c.name 
					FROM categories c 
					WHERE (
						SELECT 
							COUNT(*) 
						FROM providers_to_services p2s
						JOIN categories_to_services c2s ON p2s.option_id = c2s.object_id
						JOIN providers p ON p2s.object_id = p.id
						WHERE c2s.option_id = c.id AND p.status = 'Approved'
					) > 0
					ORDER BY c.name");
				while ($c = db_fetch($categories)) {
					echo "<li> + "  . $c["name"];
						$options = array();
						$services = db_query("SELECT
								s.id,
								s.title,
								(SELECT COUNT(*) FROM providers_to_services p2s JOIN providers p ON p2s.object_id = p.id WHERE s.id = p2s.option_id AND p.status = 'Approved') num_providers
							FROM options_service s
							JOIN categories_to_services c2s ON s.id = c2s.object_id
							WHERE 
								c2s.option_id = {$c["id"]} AND
								(SELECT COUNT(*) FROM providers_to_services p2s JOIN providers p ON p2s.object_id = p.id WHERE s.id = p2s.option_id AND p.status = 'Approved') > 0
							ORDER BY s.title");
						while ($s = db_fetch($services)) $options["/directory/?type=" . $s["id"]] = $s["title"] . " (" . $s["num_providers"] . ")";
						echo draw_nav($options, true, "text", "strawpatch_list");
						
					echo "</li>";
				}
				?>
				</ul>
				<script type="text/javascript">
				ddtreemenu.createTree("treeview", true)
				</script>
				</div>
			</div>
	
			<div id="main">
				<div id="banner">
					<?php if ($_SESSION["user_id"]) {?>
					<div id="member">
					<?php
					$options = array(
						"/admin/users.php"=>"Admins", 
						"/admin/allies.php"=>"Allies", 
						"/admin/events.php"=>"Events", 
						"/admin/providers.php"=>"Providers", 
						"/admin/services.php"=>"Services", 
						"/login/?action=logout"=>"Logout"
						);
					echo draw_nav($options, true, "text", "admin");
						//move last option off to the left
						//this might be better as a separate thing not in the <ul> above
					?>
						<style type="text/css">#member a.option<?php echo count($options)?> { position:absolute; top:1px; right:6px; }</style>
					</div>
					<?php } elseif ($_josh["request"]["folder"] != "login") {
						//echo '<a href="/login/" id="login">Member Login</a>';
					}
					echo draw_img("/images/banner-olicana.png");
					echo draw_nav(array(
						"/"=>"Home", 
						"/directory/"=>"Provider Directory", 
						"/fyi/"=>"For Your Information", 
						"/mutual-aid/"=>"Mutual Aid",
						"/doves/"=>"Meet the Doves",
						"/contact/"=>"Contact"
						), 'text', 'tabs', "/" . $_josh["request"]["folder"] . "/")?>
		
				</div>
				<div id="page">
					<h1><?php echo $title?></h1>
					<?php
}

function error_email($msg="Undefined error message") {
	global $_SESSION, $_josh;
	if (isset($_josh["email_default"]) && isset($_josh["email_admin"])) {
		if (isset($_SESSION["user_id"])) {
			if ($_josh["email_admin"] == $_SESSION["email"]) return;
			$msg = str_replace("<!--user-->", "<a href='" . url_base() . "/admin/user-edit.php?id=" . $_SESSION["user_id"] . "'>" . $_SESSION["name"] . "</a>", $msg);
		} else {
			$msg = str_replace("<!--user-->", "<i>User ID not set yet</i>", $msg);
		}
		email($_josh["email_admin"], $msg, "Error: " . $_josh["request"]["host"], $_josh["email_default"]);
	}
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}

function providerForm($msg, $p, $showApproved=false) {
	$form = new form(false, false, false);
	$form->set_field(array("type"=>"text", "name"=>"name", "label"=>"Name/Alias", "value"=>@$p["name"], "required"=>true));
	$form->set_field(array("type"=>"radio", "name"=>"tier_id", "label"=>"Tier", "value"=>@$p["tier_id"], "options"=>array(
	"1"=>"<div class='radio_title'>Organization</div>If you represent an organization with more than one wellness provider, please select this option.",
	"2"=>"<div class='radio_title'>Public</div>You choose to be listed on the website.  Contact information will be listed publicly.",
	"3"=>"<div class='radio_title'>Private</div>Provider is listed on website, although contact information is not listed publicly.  In order for seekers to contact the provider, they must first request contact and have their identity verified by the Collective.",
	"4"=>"<div class='radio_title'>Invisible</div>Provider is not listed on website, but will accept specific referrals from the Collective."
	), "required"=>true));
	$form->set_field(array("type"=>"text", "name"=>"service", "label"=>"Title", "value"=>@$p["service"], "required"=>true, "additional"=>"eg Acupuncturist"));
	if ($showApproved) $form->set_field(array("type"=>"checkboxes", "options_table"=>"options_service", "linking_table"=>"providers_to_services", "value"=>@$_GET["id"], "label"=>"Service(s)"));
	$form->set_field(array("type"=>"select", "name"=>"gender_id", "label"=>"Gender", "value"=>@$p["gender_id"], "sql"=>"SELECT id, title FROM options_gender"));
	$form->set_field(array("type"=>"textarea", "name"=>"description", "label"=>"Description", "class"=>"textarea", "value"=>@$p["description"]));
	$form->set_field(array("type"=>"checkboxes", "options_table"=>"options_payment", "linking_table"=>"providers_to_payment", "label"=>"Payment Type(s)", "value"=>@$_GET["id"]));
	$form->set_field(array("type"=>"textarea", "name"=>"availability", "label"=>"Availability", "class"=>"textarea", "value"=>@$p["availability"]));
	$form->set_field(array("type"=>"checkboxes", "options_table"=>"options_language", "linking_table"=>"providers_to_languages", "label"=>"Language(s)", "value"=>@$_GET["id"]));
	$form->set_field(array("type"=>"text", "name"=>"email", "label"=>"Email", "value"=>@$p["email"]));
	$form->set_field(array("type"=>"text", "name"=>"url", "label"=>"URL", "value"=>@$p["url"]));
	if (!$showApproved) $form->set_field(array("type"=>"note", "additional"=>"Address is required for organizations, but not for providers.  If you're a provider, it won't 
	be displayed on the site, although a marker on your location will be added to the map.  Because visitors see the map first,
	having a marker there is a way to increase your visibility."));
	$form->set_field(array("type"=>"text", "name"=>"address_1", "label"=>"Address 1", "value"=>@$p["address_1"], "additional"=>"eg 123 Main Street"));
	$form->set_field(array("type"=>"text", "name"=>"address_2", "label"=>"Address 2", "value"=>@$p["address_2"], "additional"=>"eg Apt 7C"));
	$form->set_field(array("type"=>"text", "name"=>"zip", "label"=>"ZIP", "value"=>@$p["zip"], "class"=>"zip", "maxlength"=>5));
	if (!$showApproved) $form->set_field(array("type"=>"note"));
	$form->set_field(array("type"=>"text", "name"=>"phone_landline", "label"=>"Landline Phone", "value"=>@$p["phone_landline"], "class"=>"phone", "maxlength"=>14));
	$form->set_field(array("type"=>"text", "name"=>"phone_mobile", "label"=>"Mobile Phone", "value"=>@$p["phone_mobile"], "class"=>"phone", "maxlength"=>14));
	if ($showApproved) {
		$form->set_field(array("type"=>"checkbox", "name"=>"approved", "label"=>"Approved?", "value"=>@($p["status"] == "Approved")));
		if (url_id()) {
			$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>$msg, "additional"=>"<a href='javascript:url_delete();'>delete</a> or <a href='providers.php'>cancel</a>"));
		} else {
			$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>$msg, "additional"=>"or <a href='providers.php'>cancel</a>"));
		}
	} else {
		$form->set_field(array("type"=>"submit", "name"=>"submit", "label"=>"", "value"=>$msg));
	}
	return $form->draw("provider", false, false);
}

function validateEmail($address, $force=false) {
	$address = format_email($address);
	if ($e = db_grab("SELECT id, is_valid FROM email_addresses WHERE email = '" . $address . "'")) {
		if (!$e["is_valid"] && $force) {
			db_query("UPDATE email_addresses SET is_valid = 1 WHERE id = " . $e["id"]);
			return array("id"=>$e["id"], "is_valid"=>true);
		} else {
			return $e;
		}
	} else {
		$emailID = db_query("INSERT INTO email_addresses ( email, is_valid ) VALUES ( '" . $address . "', " . format_boolean($force, "1|0") . " )");
		return array("id"=>$emailID, "is_valid"=>$force);
	}
}