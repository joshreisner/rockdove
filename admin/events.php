<? include("../include.php");

$events = db_table("SELECT id, name, start, end FROM events ORDER BY start DESC");
$count = count($events);
for ($i = 0; $i < $count; $i++) {
	$events[$i]["link"]	 = "events-edit.php?id=" . $events[$i]["id"];
	$events[$i]["start"] = format_date($events[$i]["start"]);
}
echo drawTop("Calendar: " . format_q($count, "event"));
echo drawButton(array("+ New Event"=>"events-edit.php"));
$table = new table();
$table->col("name");
$table->col("start", "r", "Date");
echo $table->draw($events, "No events added yet", true);
echo drawBottom();?>