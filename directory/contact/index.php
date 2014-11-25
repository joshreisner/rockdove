<?php
include("../../include.php");
if ($posting) {
	url_change("thankyou/");
}
url_query_require("../");
$p = db_grab("SELECT p.name, g.pronoun, g.pronoun_possessive FROM providers p JOIN options_gender g ON p.gender_id = g.id WHERE p.id = " . $_GET["id"]);
echo drawTop('<a href="/directory/">Directory</a>: Contact ' . $p["name"]);
?>
<p>Please fill out the following form to contact <?php echo $p["name"]?>.  This information will be shared with <?php echo $p["pronoun"]?> 
and <!--<?php echo $p["pronoun_possessive"]?> information sent to you--> the Rock Doves, no one else.</p>
<?php
$form = new form;
$form->addField(array("type"=>"text", "name"=>"name", "label"=>"Name/Alias", "required"=>true));
$form->addField(array("type"=>"text", "name"=>"email", "label"=>"Email", "required"=>true));
//$form->addField(array("type"=>"checkboxes", "options_table"=>"options_service", "linking_table"=>"providers_to_services", "label"=>"Service(s)"));
$form->addField(array("type"=>"select", "name"=>"gender_id", "label"=>"Gender", "sql"=>"SELECT id, name FROM options_gender"));
$form->addField(array("type"=>"textarea", "name"=>"description", "label"=>"Description", "class"=>"textarea"));
$form->addField(array("type"=>"checkboxes", "options_table"=>"options_payment", "linking_table"=>"providers_to_payment", "label"=>"Payment Type(s)"));
$form->addField(array("type"=>"textarea", "name"=>"availability", "label"=>"Availability", "class"=>"textarea"));
$form->addField(array("type"=>"text", "name"=>"phone_landline", "label"=>"Landline Phone", "class"=>"phone", "maxlength"=>14));
$form->addField(array("type"=>"text", "name"=>"phone_mobile", "label"=>"Mobile Phone", "class"=>"phone", "maxlength"=>14));
$form->addField(array("type"=>"submit", "name"=>"", "label"=>"", "value"=>"Email " . $p["name"], "additional"=>"or <a href='../?id=" . $_GET["id"] . "'>cancel</a>"));

echo $form->draw("provider_contact");

echo drawBottom();
?>