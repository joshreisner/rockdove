<?php
include("../include.php");

if (url_action("logout")) {
	$_SESSION["user_id"] = false;
	if (isset($_josh["referrer"]["path_query"])) {
		url_change($_josh["referrer"]["path_query"]);
	} else {
		url_drop("action");
	}
} elseif ($posting) {
	if ($u = db_grab("SELECT id, name, email FROM users WHERE email = '" . format_email($_POST["email_address"]) . "' AND password = '" . $_POST["password"] . "' AND is_active = 1")) {
		//good login
		cookie("last_login", $u["email"]);
		$_SESSION["user_id"]	= $u["id"];
		$_SESSION["name"]		= $u["name"];
		$_SESSION["email"]		= $u["email"];
		db_query("UPDATE users SET last_login = NOW() WHERE id = " . $u["id"]);
		url_change_post("/admin/users.php");
	} else {
		//bad login
		url_query_add(array("msg"=>"notok"));
	}
}

echo drawTop("Member Login");

if ($_SESSION["user_id"]) {
	echo "<p>Welcome!  You are now logged in.  You should see some options at the very top of the page, you can use these to do administrative-type things.  This page might eventually have an update screen with news about the database, although that's not ready yet.</p>";
} else {
	if (url_action("notok", "msg")) {
		echo "<p>That email/password combo wasn't found!  You can click the link below to recover your password if you've forgotten it (or were never given one).</p>";
	} else {
		echo "<p>Members of the Collective can use this form to log in to the database.  If you'd like to join, please <a href='/contact/?type=volunteer'>contact us</a>.</p>";
	}
	$form = new form('login', false, false);
	$form->set_field(array("type"=>"text", "label"=>"Email Address", "value"=>@$_COOKIE["last_login"], "required"=>true));
	$form->set_field(array("type"=>"password", "label"=>"Password", "additional"=>"<a href='/login/password/'>Don't know it?</a>", "required"=>true));
	//$form->set_field(array("type"=>"checkbox", "label"=>"Remember Me"));
	$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>"login"));
	echo $form->draw("login");
	echo draw_form_focus((@$_COOKIE["last_login"]) ? "password" : "email_address");

}
echo drawBottom();
?>