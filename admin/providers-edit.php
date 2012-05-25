<? include("../include.php");

if ($posting) {
	//debug();
	$_POST["phone_landline"] = format_phone($_POST["phone_landline"]);
	$_POST["phone_mobile"] = format_phone($_POST["phone_mobile"]);
	format_post_float("zip");
	format_post_nulls("gender_id");
	format_post_urls("url");
	
	if (empty($_POST["email"])) {
		$email = array("id"=>"NULL");
	} else {
		$email = validateEmail($_POST["email"], true);
		if ($providerID = db_grab("SELECT id FROM providers WHERE email_id = " . $email["id"])) $_GET["id"] = $providerID;
	}
	$status = (isset($_POST["approved"])) ? "Approved" : "Pending";
	
	//geocode
	$latitude = "NULL";
	$longitude = "NULL";
	if (!empty($_POST["address_1"]) && !empty($_POST["zip"])) list($latitude, $longitude) = geocode($_POST["address_1"], $_POST["zip"]);

	if (url_id()) {
		$providerID = $_GET["id"];
		db_query("UPDATE providers SET 
			name = '" . $_POST["name"] . "',
			service = '" . $_POST["service"] . "', 
			tier_id = " . $_POST["tier_id"] . ", 
			description = '" . $_POST["description"] . "',
			availability = '" . $_POST["availability"] . "',
			email = '" . $_POST["email"] . "',
			email_id = " . $email["id"] . ",
			url = " . $_POST["url"] . ",
			address_1 = '" . $_POST["address_1"] . "', 
			address_2 = '" . $_POST["address_2"] . "', 
			zip = " . $_POST["zip"] . ",
			phone_landline = '" . $_POST["phone_landline"] . "', 
			phone_mobile = '" . $_POST["phone_mobile"] . "', 
			gender_id = " . $_POST["gender_id"] . ", 
			status = '$status', 
			latitude = $latitude,
			longitude = $longitude,
			updated_user = " . $_SESSION["user_id"] . ",
			updated_date = NOW()
		WHERE id = " . $_GET["id"]);
	} else {
		$providerID = db_query("INSERT INTO providers ( name, service, tier_id, description, availability, email, email_id, url, address_1, address_2, zip, phone_landline, phone_mobile, gender_id, status, latitude, longitude, created_user, created_date, is_active ) VALUES (
			'" . $_POST["name"] . "',
			'" . $_POST["service"] . "',
			" . $_POST["tier_id"] . ",
			'" . $_POST["description"] . "',
			'" . $_POST["availability"] . "',
			'" . $_POST["email"] . "',
			" . $email["id"] . ",
			" . $_POST["url"] . ",
			'" . $_POST["address_1"] . "',
			'" . $_POST["address_2"] . "',
			" . $_POST["zip"] . ",
			'" . $_POST["phone_landline"] . "',
			'" . $_POST["phone_mobile"] . "',
			" . $_POST["gender_id"] . ",
			'$status',
			$latitude,
			$longitude,
			" . $_SESSION["user_id"] . ",
			NOW(),
			1
		)");
	}
	db_checkboxes("options-language", "providers_to_languages", "object_id", "option_id", $providerID);
	db_checkboxes("options-payment",  "providers_to_payment", "object_id", "option_id", $providerID);
	db_checkboxes("options-service",  "providers_to_services", "object_id", "option_id", $providerID);
	
	url_change_post("providers.php");	
} elseif (url_action("delete")) {
	db_query("DELETE FROM providers_to_languages WHERE object_id = " . $_GET["id"]);
	db_query("DELETE FROM providers_to_payment   WHERE object_id = " . $_GET["id"]);
	db_query("DELETE FROM providers_to_services  WHERE object_id = " . $_GET["id"]);
	db_query("DELETE FROM providers WHERE id = " . $_GET["id"]);
	url_change("providers.php");
}

if (url_id()) {
	$msg = "Edit Provider";
	$p = db_grab("SELECT name, service, tier_id, description, availability, email, url, address_1, address_2, zip, phone_landline, phone_mobile, gender_id, status FROM providers WHERE id = " . $_GET["id"]);
} else {
	$msg = "Add Provider";
	$p["url"] = "http://";
}

echo drawTop("Directory: " . $msg);
?>
<p>Use this form to add providers to the <a href="/directory/">Provider Directory</a>.</p>
<?
echo providerForm($msg, $p, true);
echo drawBottom();?>