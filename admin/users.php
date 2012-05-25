<? include("../include.php");

$users = db_table("SELECT id, name, last_login FROM users ORDER BY name");
$count = count($users);
for ($i = 0; $i < count($users); $i++) {
	$users[$i]["link"]		 = "users-edit.php?id=" . $users[$i]["id"];
	$users[$i]["last_login"] = format_date($users[$i]["last_login"]);
}
echo drawTop(format_q($count, "user"));
echo drawButton(array("+ New User"=>"users-edit.php"));
$table = new table();
$table->col("name");
$table->col("last_login", "r");
echo $table->draw($users, "No users added yet", true);
echo drawBottom();?>