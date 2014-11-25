<?php
include("../include.php");

if ($posting) {
	if (url_id()) {
		db_query("UPDATE options_service SET 
			title = '{$_POST["title"]}',
			description = '{$_POST["description"]}',
			wiki = '{$_POST["wiki"]}'
			WHERE id = " . $_GET["id"]);
		db_checkboxes("categories", "categories_to_services", "object_id", "option_id", $_GET["id"]);
	} else {
		$serviceID = db_query("INSERT INTO options_service ( title, description, wiki ) VALUES (
			'{$_POST["title"]}',
			'{$_POST["description"]}',
			'{$_POST["wiki"]}'
		)");
		db_checkboxes("categories", "categories_to_services", "object_id", "option_id", $serviceID);
	}
	url_change_post("services.php");
} elseif (url_action("delete")) {
	db_query("DELETE FROM categories_to_services WHERE object_id = " . $_GET["id"]);
	db_query("DELETE FROM options_service WHERE id = " . $_GET["id"]);
	url_change("services.php");
}

if (url_id()) {
	$msg = "Edit Service";
	$s = db_grab("SELECT title, description, wiki FROM options_service WHERE id = " . $_GET["id"]);
} else {
	$msg = "Add Service";
}

echo drawTop("<a href='services.php'>Services</a>: " . $msg);

$form = new form('options_service');
$form->set_field(array("type"=>"text", "name"=>"title", "label"=>"Service Name", "value"=>@$s["title"], "required"=>true));
$form->set_field(array("type"=>"checkboxes", "options_table"=>"categories", "linking_table"=>"categories_to_services", "label"=>"Categories", "value"=>@$_GET["id"], "additional"=>"<br><a href='javascript:discard(\"categories-edit.php\");'>add new</a>"));
$form->set_field(array("type"=>"textarea", "name"=>"description", "label"=>"Description", "class"=>"textarea", "value"=>@$s["description"]));
$form->set_field(array("type"=>"text", "name"=>"wiki", "label"=>"Wiki Link", "value"=>@$s["wiki"]));
if (url_id()) {
	$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>$msg, "additional"=>"<a href='javascript:url_delete();'>delete</a> or <a href='services.php'>cancel</a>"));
} else {
	$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>$msg, "additional"=>"or <a href='services.php'>cancel</a>"));
}
echo $form->draw("service");


echo drawBottom();
?>