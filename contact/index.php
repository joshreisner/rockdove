<?php

	include("../include.php");
/*

if ($posting) {
	if ($_POST["topic"] == "technical") {
		email_post("josh@rockdovecollective.org", "Web: Contact Us Form", $email);
	} else {
		email_post("lauren@rockdovecollective.org", "Web: Contact Us Form", $email);
	}
	email($email, "thank you for your submission. we'll be following up with you shortly", "thank you");
	url_change("/contact/thankyou/");
}
*/
echo drawTop("Contact Us");

/*
echo "<p>You can use this form to send us an email.  Please pay special attention to the Topic field; it determines who will receive your message.</p>";

if ($action == "email_provider") {
	josh_sys_email_postdata($email, "rockdovecollective@riseup.net, laurengiambrone@gmail.com", "Web: Service Provider Feedback Form");
	josh_sys_email("rock dove collective <rockdovecollective@riseup.net>", $email, "thank you for your submission. we'll be contacting you shortly for an interview so we can get to know each other better!", "thank you");
	$redirect = "/thankyou/";
} elseif ($action == "contact") {
	josh_sys_email_postdata($email, "rockdovecollective@riseup.net, laurengiambrone@gmail.com", "Web: Contact Us Form");
	josh_sys_email("rock dove collective <rockdovecollective@riseup.net>", $email, "thank you for contacting us. we'll be in touch shortly.", "thank you");
	$redirect = "/thankyou/";
}


if (url_action("seeker")) {?>
	<p>The easiest way to request services is to find a provider you like in our <a href="/directory/">Provider Directory</a>
	and use the form on their page to make contact.  If you can't find what you're looking
	for there, we invite you to use the form below.  A member of
	the Rock Dove Collective will then follow up with you to help you find
	a provider that's right for you.</p>
	
	<p>Please be sure to indicate what you are looking for and what you have to offer in the way of money, insurance, or <a href="/mutual-aid/">mutual aid</a>.</p>
<?php } 

$form = new form(false, false, false);
$form->set_field(array("type"=>"text", "name"=>"name", "label"=>"Name/Alias", "required"=>true));
$form->set_field(array("type"=>"text", "name"=>"email", "label"=>"Email", "required"=>true));
$form->set_field(array("type"=>"select", "name"=>"topic", "label"=>"Topic", "value"=>@$_GET["type"], "required"=>true, "options"=>array(
	"general"=>"I have a general question",
	"seeker"=>"Seeker help request",
	"resource"=>"Recommend a free/low cost health resource",
	"technical"=>"Technical issue with the website",
	"volunteer"=>"Volunteer to join or help out the RDC"
)));
$form->set_field(array("type"=>"textarea", "name"=>"message", "label"=>"Message", "class"=>"textarea"));
$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>"send message"));
echo $form->draw("contact");
*/
?>

<?php
echo drawBottom(); 

?>