<?php
include("../include.php");

if ($posting) {
	db_save("categories");
	url_change_post("services.php");
} elseif (url_action("delete")) {
	db_query("DELETE FROM categories_to_services WHERE option_id = " . $_GET["id"]);
	db_query("DELETE FROM categories WHERE id = " . $_GET["id"]);
	//db_delete("categories"); i would do this except form->checkboxes doesn't support is_active
	url_change("services.php");
}

if (url_id()) {
	$msg = "Edit Category";
	$c = db_grab("SELECT id, name, admin_id FROM categories WHERE id = " . $_GET["id"]);
} else {
	$msg = "Add Category";
}

echo drawTop("<a href='services.php'>Services</a>: " . $msg);

$form = new form('categories');
$form->set_field(array("type"=>"text", "name"=>"name", "label"=>"Category", "value"=>@$c["name"], "required"=>true));
$form->set_field(array("type"=>"select", "name"=>"admin_id", "label"=>"Admin", "value"=>@$c["admin_id"], "sql"=>"SELECT id, name FROM users WHERE is_active = 1 ORDER BY name", "required"=>false));
if (url_id()) {
	$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>$msg, "additional"=>"<a href='javascript:url_delete();'>delete</a> or <a href='services.php'>cancel</a>"));
} else {
	$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>$msg, "additional"=>"or <a href='services.php'>cancel</a>"));
}
echo $form->draw("category");

echo drawBottom();
?>