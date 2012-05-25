<?php
include("../include.php");

echo drawTop("Allies");
?>
Rock Dove stands in solidarity with these organizations.  If we're forgetting anyone,
please <a href="/contact/">let us know</a>.

<?
$allies = db_query("SELECT id, name, url, description FROM allies WHERE is_active = 1 ORDER BY name");
while ($a = db_fetch($allies)) {?>
	<div class="link">
	<a href="<?=$a["url"]?>"><?=$a["name"]?></a>&nbsp;
	<? if ($_SESSION["user_id"]) { ?><a href="/admin/allies-edit.php?id=<?=$a["id"]?>" class="link_edit">edit</a><? }?>
	<br>
	<?=nl2br($a["description"])?>
	</div>
<? }
echo drawBottom();
?>