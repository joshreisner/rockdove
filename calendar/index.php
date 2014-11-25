<?php include("../include.php");
echo drawTop("Event Calendar");

$events = db_query("SELECT id, name, description, start, end FROM events ORDER BY start DESC");
while ($e = db_fetch($events)) {?>
	<div class="calendar_block">
	<div class="calendar_date">
		<div class="calendar_date_day"><?php echo format_date($e["start"], "???", "d", false, false)?></div>
		<div class="calendar_date_month"><?php echo format_date($e["start"], "???", "M", false, false)?></div>
		<div class="calendar_date_year"><?php echo format_date($e["start"], "???", "Y", false, false)?></div>
		<?php if ($_SESSION["user_id"]) {?>
		<a href="/admin/events-edit.php?id=<?php echo $e["id"]?>" class="calendar_edit">edit</a>
		<?php }?>
	</div>
	<div class="calendar_title"><?php echo $e["name"]?></div>
	<div class="calendar_text">
	<?php echo nl2br($e["description"])?>
	</div>
	</div>
	<?php
}

echo drawBottom(); ?>