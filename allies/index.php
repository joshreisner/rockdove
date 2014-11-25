<?php
include("../include.php");

echo drawTop("Allies");
?>
Rock Dove stands in solidarity with these organizations.  If we're forgetting anyone,
please <a href="/contact/">let us know</a>.

<?php
$allies = db_query("SELECT id, name, url, description FROM allies WHERE is_active = 1 ORDER BY name");
while ($a = db_fetch($allies)) {?>
	<div class="link">
	<a href="<?php echo $a["url"]?>"><?php echo $a["name"]?></a>&nbsp;
	<?php if ($_SESSION["user_id"]) { ?><a href="/admin/allies-edit.php?id=<?php echo $a["id"]?>" class="link_edit">edit</a><?php }?>
	<br>
	<?php echo nl2br($a["description"])?>
	</div>
<?php }
echo drawBottom();
?>