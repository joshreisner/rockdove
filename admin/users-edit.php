<?php include("../include.php");

if ($posting) {
	if (url_id()) {
		format_post_bits("is_active");
		db_query("UPDATE users SET 
			name = '" . $_POST["name"] . "',
			email = '" . $_POST["email"] . "',
			password = '" . $_POST["password"] . "',
			bio = '" . $_POST["bio"] . "',
			is_active = " . $_POST["is_active"] . ",
			updated_user = " . $_SESSION["user_id"] . ",
			updated_date = NOW()
			WHERE id = " . $_GET["id"]);
	} else {
		db_query("INSERT INTO users ( name, email, password, bio, is_active, created_user, created_date ) VALUES (
			'" . $_POST["name"] . "',
			'" . $_POST["email"] . "',
			'" . $_POST["password"] . "',
			'" . $_POST["bio"] . "',
			1,
			" . $_SESSION["user_id"] . ",
			NOW()
		)");
	}
	url_change("users.php");
}

if (url_id()) {
	$msg = "Edit User";
	$u = db_grab("SELECT name, email, password, bio, is_active FROM users WHERE id = " . $_GET["id"]);
} else {
	$msg = "Add User";
	$u["is_active"] = true;
}

echo drawTop("Users: " . $msg);
?>
<p>Use this form to add administrators to the site.  The bio will eventually show up on the <a href="/doves/">Meet the Doves</a> page.</p>
<?php
$form = new form('users');
$form->set_field(array("type"=>"text", "name"=>"name", "label"=>"Name", "value"=>@$u["name"]));
$form->set_field(array("type"=>"text", "name"=>"email", "label"=>"Email", "value"=>@$u["email"]));
$form->set_field(array("type"=>"password", "name"=>"password", "label"=>"Password", "value"=>@$u["password"]));
$form->set_field(array("type"=>"textarea", "name"=>"bio", "label"=>"Bio", "class"=>"textarea", "value"=>@$u["bio"]));
$form->unset_fields('last_login');
if (url_id()) $form->set_field(array("type"=>"checkbox", "name"=>"is_active", "label"=>"Is Active?", "value"=>@$u["is_active"]));
$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>$msg, "additional"=>"or <a href='users.php'>cancel</a>"));
echo $form->draw();

echo drawBottom();?>