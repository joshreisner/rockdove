<?php include("../include.php");

if ($posting) {
	if (url_id()) {
		db_query("UPDATE events SET 
			name = '" . $_POST["name"] . "',
			start = " . format_post_date("start") . ",
			end = " . format_post_date("end") . ",
			description = '" . $_POST["description"] . "',
			updated_user = " . $_SESSION["user_id"] . ",
			updated_date = NOW()
			WHERE id = {$_GET["id"]}
		");
	} else {
		db_query("INSERT INTO events ( name, start, end, description, created_user, created_date, is_active ) VALUES (
			'" . $_POST["name"] . "',
			" . format_post_date("start") . ",
			" . format_post_date("end") . ",
			'" . $_POST["description"] . "',
			" . $_SESSION["user_id"] . ",
			NOW(),
			1
		)");
	}
	if (!isset($_POST["return_to"]) || empty($_POST["return_to"])) $_POST["return_to"] = "/admin/events.php";
	url_change($_POST["return_to"]);
} elseif (url_action("delete")) {
	db_query("DELETE FROM events WHERE id = " . $_GET["id"]);
	if (!isset($_POST["return_to"]) || empty($_POST["return_to"])) $_POST["return_to"] = "/admin/events.php";
	url_change($_POST["return_to"]);
}

$msg = "Add Event";
if (url_id()) {
	$msg = "Edit Event";
	$e = db_grab("SELECT name, start, end, description FROM events WHERE id = " . $_GET["id"]);
}

echo drawTop("Calendar: " . $msg);
?>
<p>Use this form to add events to the <a href="/calendar/">Event Calendar</a>.</p>
<?php
$form = new form('events');
$form->set_field(array("type"=>"text", "name"=>"name", "label"=>"Event Name", "value"=>@$e["name"], "required"=>true));
$form->set_field(array("type"=>"datetime", "name"=>"start", "label"=>"Starts", "value"=>@$e["start"]));
$form->set_field(array("type"=>"datetime", "name"=>"end", "label"=>"Ends", "value"=>@$e["end"]));
$form->set_field(array("type"=>"textarea", "name"=>"description", "label"=>"Description", "class"=>"textarea", "value"=>@$e["description"]));
if (url_id()) {
	$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>$msg, "additional"=>"<a href='javascript:url_delete();'>delete</a> or <a href='events.php'>cancel</a>"));
} else {
	$form->set_field(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>$msg, "additional"=>"or <a href='events.php'>cancel</a>"));
}
echo $form->draw("event");

echo drawBottom();?>