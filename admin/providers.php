<? include("../include.php");

$providers = db_table("SELECT 
	p.id, 
	p.name, 
	t.name tier, 
	p.status, 
	IFNULL(p.updated_date, p.created_date) updated_date 
	FROM providers p
	JOIN options_tier t ON p.tier_id = t.id 
	ORDER BY p.status DESC, p.name");
$count = count($providers);
for ($i = 0; $i < $count; $i++) {
	$providers[$i]["group"]	 = $providers[$i]["status"] . " Providers";
	$providers[$i]["link"]	 = "providers-edit.php?id=" . $providers[$i]["id"];
	$providers[$i]["updated_date"]	 = format_date($providers[$i]["updated_date"]);
}
echo drawTop("Directory: " . format_q($count, "provider"));
echo drawButton(array("+ New Provider"=>"providers-edit.php"));
$table = new table();
$table->col("name");
$table->col("tier");
//$table->col("status");
$table->col("updated_date", "r", "Updated");

echo $table->draw($providers, "No providers added yet", true);
echo drawBottom();?>