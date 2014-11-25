<?php
include("../include.php");
url_query_require();

db_query("UPDATE email_addresses SET is_valid = 1 WHERE id = " . $_GET["id"]);
if ($providerID = db_grab("SELECT id FROM providers WHERE email_id = " . $_GET["id"])) {
	db_query("UPDATE providers SET status = 'Pending' WHERE id = " . $providerID);
	alertProviderNew($providerID);
}

echo drawTop("You Are So Valid");
?>
<p>Thank you!  We know it's a silly exercise, but it really does help us cut down on spam submissions.  Thanks!  The ball is in our court now; we will follow up with you shortly.</p>
<?php echo drawBottom();?>