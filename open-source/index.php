<?php
include("../include.php");
echo drawTop("About this Site");
?>
<p>The lovely pigeon image in the upper left was taken by Turkish photographer and designer <a href="http://www.tolgaerbay.com/">Tolga Erbay</a> and is reused here with the permission of the artist.</p>

<p align="center">~</p>

<p>Want to have a Rock Dove Collective website of your own?  You can, by using our source code.</p>
<ul>
	<li>&#8226; <a href="https://joshr.svn.beanstalkapp.com/rockdove/">Rockdove Web Database</a><br>This is the high-level code that powers this website.  This is licensed to the public under the terms of the <a href="http://www.gnu.org/licenses/gpl.html">GPL</a>, meaning that you are free to use it for noncommercial, open-source purposes.</li><br>
	<li>&#8226; <a href="http://code.google.com/p/joshlib/">Joshlib</a><br>The lower-level code library, licensed under the <a href="http://www.gnu.org/copyleft/lesser.html">LGPL</a>, meaning that you are free to use it for whatever you wish.</li>
</ul>
<p>Site requirements are PHP and MySQL. Here is a <a href="schema.sql">blank database schema</a> you can use, current as of <?=format_date(filemtime("schema.sql"))?>.</p>

<p>We provide this to the public to help build community technical capacity
and promote wellness.  Please abide by the terms of the licenses.  
This code is provided without any kind of warranty or guarantee.</p>

<p>Please <a href="/contact/?type=technical">contact Josh</a> if you spot a vulnerability in the code or would just
like to help us push this project forward.</p>

<?=drawBottom();?>