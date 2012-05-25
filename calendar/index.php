<? include("../include.php");
echo drawTop("Event Calendar");

$events = db_query("SELECT id, name, description, start, end FROM events ORDER BY start DESC");
while ($e = db_fetch($events)) {?>
	<div class="calendar_block">
	<div class="calendar_date">
		<div class="calendar_date_day"><?=format_date($e["start"], "???", "d", false, false)?></div>
		<div class="calendar_date_month"><?=format_date($e["start"], "???", "M", false, false)?></div>
		<div class="calendar_date_year"><?=format_date($e["start"], "???", "Y", false, false)?></div>
		<?php if ($_SESSION["user_id"]) {?>
		<a href="/admin/events-edit.php?id=<?=$e["id"]?>" class="calendar_edit">edit</a>
		<? }?>
	</div>
	<div class="calendar_title"><?=$e["name"]?></div>
	<div class="calendar_text">
	<?=nl2br($e["description"])?>
	</div>
	</div>
	<?
}

echo drawBottom(); ?>