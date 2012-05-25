<?php
include("../../include.php");

if ($posting) {
	$email = format_email($_POST["email_address"]);
	if ($pw = db_grab("SELECT password FROM users WHERE email = '{$email}' AND is_active = 1")) {
		email($email, "your password is <b>" . $pw . "</b>.  have a beautiful day!", "password recovery");
		cookie("last_login", $email);
		url_query_add(array("msg"=>"ok"));
	} else {
		url_query_add(array("msg"=>"notok"));
	}
}

if (url_action("ok", "msg")) {
	echo drawTop("Password Found!");
	echo "<p>Your password was located&mdash;check your email!</p><p><a href='/login/'>Back to login</p>";
} elseif (url_action("notok", "msg")) {
	echo drawTop("Email Not Found");
	echo "<p>Your email isn't listed in the database as belonging to an active user.  Please try again.  If you're positive this is an error of some kind, you can also <a href='/contact/?type=technical'>contact Josh</a>, our webmaster.</p>";
	$form = new form(false, false, false);
	$form->set_field(array("type"=>"text", "label"=>"Email Address", "value"=>@$_COOKIE["last_login"], "required"=>true));
	$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>"recover password"));
	echo $form->draw("password");
	echo draw_form_focus("email_address");
} else {
	echo drawTop("Password Recovery");
	echo "<p>Please enter your email address.  Your password will be emailed to you.</p>";
	$form = new form(false, false, false);
	$form->set_field(array("type"=>"text", "label"=>"Email Address", "value"=>@$_COOKIE["last_login"], "required"=>true));
	$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>"recover password", "additional"=>"or <a href='/login/'>cancel</a>"));
	echo $form->draw("password");
	echo draw_form_focus("email_address");
}

echo drawBottom();
?>