<? include("include.php");
echo drawTop();?>
<div class="panel">
	<b>Why Rock Dove?</b>
	<p align="center">
	<?//draw_img("/images/pigeon-drawing.png")?></p>
	<p>"Rock Dove" is the original name for the pigeon. You may have seen one or two around town.</p>
	<p>We are Rock Dove because we aim to connect the strength and groundedness of the rock with the peace and flight of the 
	dove in our lives, our relationships, and our work.</p>
	<p>We are Rock Dove because amidst what looks like endless and irreversible hardship, we aim to serve as messengers from
	a live, green world. We see and build that world in the shell of the present. We hatch plans.</p>
	<p>We are Rock Dove because this is New York City, and we are everywhere.</p>
</div>

<? if ($e = db_grab("SELECT start, id, name FROM events WHERE end > NOW() ORDER BY start DESC")) {?>
	<div class="alert" style="width:356;"><b>Upcoming Event!</b> <a href="/calendar/"><?=$e["name"]?></a> on <?=format_date($e["start"])?></div>
<? }?>

<p>The Rock Dove Collective is a radical community health exchange working
to address the need for accessible and anti-oppressive health care in
our communities. We coordinate a <a href="/directory/">network of health practitioners</a> who
provide physical, mental, sexual, emotional, social and spiritual care
from a (radical/progressive) perspective on well-being.</p>

<p>Many of our practitioners accept <a href="/mutual-aid/">mutual aid</a> in exchange for their
services; the Rock Dove Collective strongly encourages this and believes 
that incorporating mutual aid into more instances in our lives 
will help to set the foundation for a freer and more just world.</p>

<p>To learn more about the Rock Dove Project, read our <a href="/mission/">mission statement</a> and our <a href="/ethics/">code of ethics</a>.</p>

<p>Know a health practitioner perfect for Rock Dove? <a href="/contact/?type=resource">Contact us</a> to let us know.</p>

<p>Are you a health practitioner interested in Rock Dove?  Check out <a href="/beaprovider/">Be a Service Provider</a>.</p>
<? echo drawBottom(); ?>