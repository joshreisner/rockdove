<? include("../include.php");

$allies = db_table("SELECT 
		id, 
		name, 
		IFNULL(updated_date, created_date) updated_date 
	FROM allies 
	WHERE is_active = 1 ORDER BY name DESC");
$count = count($allies);
for ($i = 0; $i < $count; $i++) {
	$allies[$i]["link"]	 = "allies-edit.php?id=" . $allies[$i]["id"];
	$allies[$i]["updated_date"] = format_date($allies[$i]["updated_date"]);
}
echo drawTop("Allies: " . format_q($count, "link"));
echo drawButton(array("+ New Link"=>"allies-edit.php"));
$table = new table();
$table->col("name");
$table->col("updated_date", "r", "Date");
echo $table->draw($allies, "No allies added yet", true);
echo drawBottom();?>