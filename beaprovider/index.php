<?php include("../include.php");

if ($posting) {
	format_post_nulls("gender_id, tier_id");
	if ($_POST["tier_id"] == "NULL") {
		//i think it's spam
		url_query_add(array($msg=>"tier_required"));
	}
	format_post_float("zip");
	format_post_urls("url");
	$_POST["phone_landline"] = format_phone($_POST["phone_landline"]);
	$_POST["phone_mobile"] = format_phone($_POST["phone_mobile"]);

	//geocode
	$latitude = "NULL";
	$longitude = "NULL";
	if (!empty($_POST["address_1"]) && !empty($_POST["zip"])) list($latitude, $longitude) = geocode($_POST["address_1"], $_POST["zip"]);
	
	$email = validateEmail($_POST["email"]);
	$status = ($email["is_valid"]) ? "Pending" : "Validating";
	
	if ($providerID = db_grab("SELECT id FROM providers WHERE email_id = " . $email["id"])) {
		//provider updating his own record
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
			status = '" . $status . "',
			latitude = $latitude,
			longitude = $longitude,
			created_user = " . format_null($_SESSION["user_id"]) . ",
			created_date = NOW(),
			is_active = 1
			WHERE id = " . $providerID);
	} else {
		//provider adding new record
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
			'" . $status . "',
			$latitude,
			$longitude,
			" . format_null($_SESSION["user_id"]) . ",
			NOW(),
			1
		)");	
	}
	//db_checkboxes("options-service", "providers_to_services", "object_id", "option_id", $providerID);
	db_checkboxes("options-payment", "providers_to_payment", "object_id", "option_id", $providerID);
	db_checkboxes("options-language", "providers_to_languages", "object_id", "option_id", $providerID);
	
	if ($status == "Pending") {
		email($_POST["email"], "Thank you for your submission!  We'll be getting back to you shortly.", "Thank You");
		alertProviderNew($providerID);
	} else {
		email($_POST["email"], "Thank you for your submission!  We're always so excited to work with new providers.  Please <a href='" . url_base() . "/login/validate.php?&id=" . $email["id"] . "'>click here to validate</a> your email address so we can move forward together.", "Validate Your Email");
	}
	
	url_change("/contact/thankyou/");
}

echo drawTop("Information for Service Providers");

if (isset($_GET["msg"]) && ($_GET["msg"] == "tier_required")) {
	echo "<b>Please select a tier below";
}
?>

<div class="message"><strong>Please Note:</strong> Provider application reviews are currently on hold.</div>

<p>Thank you for your interest in becoming a Rock Dove provider! In order to devote time towards strengthening the relationship with our current providers, we are not reviewing any new applications until 
April 2012. Feel free to submit your application, but please be mindful of the fact that we won't be able to review it until the spring. Again, thank you for your interest and we look forward to hearing 
from you in April!</p>

<hr/>

<p>Welcome. We're so glad you stopped by.  Service providers are an essential element to the Rock Dove Project. With them, we are working to create a network where
good health and well being can be achieved in life-affirming ways.
They provide all types of important services to our communities,
ranging anywhere from massage therapy to non-violence training to
dentistry.</p>

<p>When you become a Rock Dove Provider, you have access to like-minded health care practitioners, opportunities to accept mutual aid in compensation for your work, and ways to reach individuals who might not otherwise have access to the care they need. You also have access to our Provider Workshop Series&mdash;workshops we organize to help health care practitioners improve their practice, on issues ranging from working with trans clients to how to offer an appropriate sliding scale.</p>

<p>We ask all potential service providers to first read and agree with our <a href="/mission/">mission statement</a> prior to continuing.
Agreed? Great! To get started as a Service Provider, please fill out this form.  Thank you for participating!</p>

<p>Also, please write about yourself in the third person!</p>


<?php
$p["url"] = "http://";
echo providerForm("Be A Provider", $p);
echo drawBottom()?>