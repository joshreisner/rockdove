<? include("../include.php");
echo drawTop("Meet the Doves");?>
<img src="/images/meet-the-doves.gif" width="224" height="208" border="0" align="right" style="margin:0px 0px 10px 10px">
Rock Dove is a collective of anarchist and radical individuals who seek to address
the need for helpful, accessible, non-hierarchical health assistance in
our communities. We support de-centralized and non-oppressive forms and
sources of physical, mental, emotional, sexual and spiritual well-being. We see
this as both a daily necessity and a revolutionary strategy.<br><br>

<?
//you can edit doves info by logging in and going to the admins page
$users = db_query("SELECT name, bio FROM users ORDER BY name");
while ($u = db_fetch($users)) {
	echo "<b>" . $u["name"] . "</b><br>" . nl2br($u["bio"]) . "<br><br>";
}?>

<img src="/images/brad.jpg" width="130" height="160" border="0" align="left" style="margin:0px 10px 0px 0px">
<b>Brad Will</b><br>
We honor and celebrate the life and work of our friend Brad Will and we stand in solidarity with the people of Oaxaca and their
continued struggle for autonomy.

<?=drawBottom()?>