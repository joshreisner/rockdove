<?php
include("../include.php");

if ($posting) {
	db_save("allies");
	url_change_post("allies.php");
} elseif (url_action("delete")) {
	db_delete("allies");
	url_change("allies.php");
}

if (url_id()) {
	$msg = "Edit Ally";
	$a = db_grab("SELECT id, name, url, description FROM allies WHERE id = " . $_GET["id"]);
} else {
	$msg = "Add an Ally";
	$a["url"] = "http://";
}

echo drawTop("<a href='allies.php'>Allies</a>: " . $msg);

$form = new form('allies');
$form->set_field(array("type"=>"text", "name"=>"name", "value"=>@$a["name"], "required"=>true));
$form->set_field(array("type"=>"text", "name"=>"url", "value"=>@$a["url"], "required"=>true));
$form->set_field(array("type"=>"textarea", "name"=>"description", "value"=>@$a["description"], "required"=>true));
if (url_id()) {
	$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>$msg, "additional"=>"<a href='javascript:url_delete();'>delete</a> or <a href='allies.php'>cancel</a>"));
} else {
	$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>$msg, "additional"=>"or <a href='allies.php'>cancel</a>"));
}
echo $form->draw("ally");


echo drawBottom();
?>