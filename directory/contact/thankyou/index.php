<?php
include("../../../include.php");
if ($posting) {
}
url_query_require("../");
$p = db_grab("SELECT p.name, g.pronoun, g.pronoun_possessive FROM providers p JOIN options_gender g ON p.gender_id = g.id WHERE p.id = " . $_GET["id"]);
echo drawTop('<a href="/directory/">Directory</a>: Thank You');
?>
<p>This page hasn't been written yet.  Here is the process:
<ul>
<li>&#8226; An email will be sent to the address you provided to verify</li>
<li>&#8226; Once you've verified, your request will become official in the database, and an alert will be sent to the category admins</li>
<li>&#8226; Once one of them approves the request, an email will be sent to the provider with seeker's info, and an email will be sent to seeker with provider's info</li>
</ul>


<?php echo drawBottom();?>