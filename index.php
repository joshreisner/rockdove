<?php
include('include.php');
echo drawTop();
?>
<div class="panel">
	<b>Why Rock Dove?</b>
	<p>"Rock Dove" is the original name for the pigeon. You may have seen one or two around town.</p>
	<p>We are Rock Dove because we aim to connect the strength and groundedness of the rock with the peace and flight of the 
	dove in our lives, our relationships, and our work.</p>
	<p>We are Rock Dove because amidst what looks like endless and irreversible hardship, we aim to serve as messengers from
	a live, green world. We see and build that world in the shell of the present. We hatch plans.</p>
	<p>We are Rock Dove because this is New York City, and we are everywhere.</p>
</div>

<?php
	if ($e = db_grab("SELECT start, id, name FROM events WHERE end > NOW() ORDER BY start DESC")) {?>
	<div class="alert" style="width:356;"><b>Upcoming Event!</b> <a href="/calendar/"><?php echo $e["name"]?></a> on <?php echo format_date($e["start"])?></div>
<?php }?>

<div class="message" style="margin-top:10px; width:354;"><strong>Please Note:</strong> The Rock Dove Collective was a radical community health exchange, active in New York City from 2006 until 2012. Below you&#39;ll find some more about our history, our accomplishments, our challenges, and ultimately, our decision to close the collective. Before we go there, <strong>a couple words about the site: it&#39;s not being updated anymore!</strong> We intend to keep our provider directory and tipsheets live on the site. However, please bear in mind that the information listed for providers may not be current, so it&#39;s probably wise to google a provider&#39;s name for more up-to-date info before attempting to contact them.</div>


<strong><p>How We Became Doves</p></strong>
<p>Rock Dove emerged out of the first meeting of the New York Metro Alliance of Anarchists (NYMAA) in 2005. What started as a small cluster of people possibly interested in joining an &#34;Alternative Therapies&#34; working group began to take shape as an autonomous, mutual aid-based health project. The Doves envisioned a network of radical or progressive health and wellness providers who would offer services for free, low-cost, sliding scale or on a barter/mutual aid basis. We would connect service seekers to this provider network through our website, and offer monthly skillshares to empower community members to facilitate their own healing.<p>
<p>Shortly before the official launch of the Rock Dove Collective, one of our collective members, Brad Will, was murdered while documenting the teacher&#39;s strike in Oaxaca in October of 2006. This devastating event bonded our collective members as we supported each other through grief, and we honored his life and his work as we introduced ourselves to the greater New York City community. His memory lived on in our work as Rock Doves, and endures as each of us continue to build healing justice as shaped by our time in the collective.</p>
<strong><p>What We Doves Did</p></strong>
<p>One of the most vital and integral parts of Rock Dove, and one of the things that made us relatively unique, was our absolute commitment to sustainable practice in our organizing together. For us, the work of being well is resilience and resistance, and should not be sacrificed in the interest of more explicitly political work. So, we paced ourselves. We worked slowly, and made efforts to ensure that what we took on was both within our capacities and ideally, that it brought us joy. Sometimes this meant that the growth didn&#39;t happen as quickly as we might have liked, or that we passed on opportunities that would have required an unsustainable pace or intensity. But it also created space for us not only to build up our infrastructure, but also to connect with one another and explore and confront our own histories, areas for growth, wants, needs and dreams. In doing the work with intention and reflection, we both built a project with integrity and also built a community with profound connections and strength.</p> 
<p>In the early days of Rock Dove, we saw ourselves as primarily supporting those who were radical activists, predominantly anarchists, to practice self-care and prevent burnout. We built up our provider network and offered skillshares on topics like herbal medicine, conflict resolution, massage, and navigating mental health crises. We saw, quickly, that some people were not fully mindful of their privilege (i.e. they had access to insurance, were eligible for Medicaid, etc.), and were drawn to our resources more as a way of avoiding bureaucracy than as a way of meeting their basic needs. So, we sought to focus our efforts on connecting people to care who came from historically marginalized communities, including immigrants, people of color, low-income folks, and LGBTQ+ people. In part, we believed that supporting marginalized communities&#39; health would create more space for resistance from within, because when our basic needs are met, we can take time to transform the conditions that make us unwell in the first place. It was this work that lead us to partner with the Center for Family Life in Sunset Park, and the workers&#39; cooperative Si Se Puede, to provide low fee community acupuncture to undocumented domestic workers. This led to the development of a short-lived acupuncturists&#39; collective Open Channels, and the model informed the development of Third Space, a healing initiative at the Audre Lorde Project.</p>
<p>As we found our legs, Rock Doves participated in local and national dialogues around health and healing justice, offering workshops and skillshares at various anarchist bookfairs and at conferences like the Allied Media Conference and the U.S. Social Forum. We also participated in dialogues, interviews, and resource sharing (including these tip sheets) to support similar efforts across the city and the continent. We&#39;re proud of the emphasis on sustainable processes, intentional project planning, commitment to racial justice, and laughter that we brought to these conversations.</p>
<strong><p>Challenges and Knowledge Gained</p></strong>
<p>While so much about our work together was joyful and libratory, we confronted many challenges along the way, some with more transformative outcomes than others. An issue that was consistently at play was walking the line between supporting each other&#39;s emotional needs and the need to get the work done. Over the years, the members of our closed collective became family to each other - with all of the benefits and hard parts that come along with it. We found that sometimes our enthusiasm for hearing about each other&#39;s love lives left us with only forty-five minutes to get down to business, so we built in an optional long check-in time before our meetings. Our alliances to each other and different emotional processing styles sometimes resulted in challenges in holding each other accountable to the work and each other. It is important to stay mindful of and attuned to supporting each other&#39;s emotional health, and also to recognize that part of that support is holding each other accountable to our commitments.</p>
<p>Among the more challenging and fruitful dialogues within our work together was what it looked like to center racial justice in our work. Our collective, comprised for much of the duration of two women of color and three white women, had a broad range of views around what healing justice projects look like through an anti-racist lens, and where our responsibilities lay. Through identity mapping, readings, retreats, and some powerful moments of tension, dialogue, and transformation, we identified approaches that strove to center racial justice in our work without empty rhetoric or tokenization.</p>
<p>Our deeply interconnected collective was also was difficult to penetrate. Early attempts at integrating new members often were not successful, and though we claimed we would be open to new members, we only ever took on one new member after 2007, and that was in 2012. Looking back, we believe that some of our reluctance to take on new members might be due to the collective trauma of losing Brad; we were afraid of loss and fiercely protective of our bonds with each other. This insularity kept us from integrating new members successfully even when their energy and skillsets could have increased our capacity to do the work well and with integrity. We now recognize the need for concrete strategies that build relationships with and integrate new members into both projects and communities.</p>
<p>Rock Dove was founded by women in our early-to-mid twenties. Unsurprisingly, each of us found the next six years full of change and shifts in capacity and interests. Two of us moved out of the city, three of us went to school full time to pursue healing practices, one of us founded and directed an innovative non-profit, one of us started the work with no children and wrapped it up with three. Our support for each other was invaluable during these busy times, and each of us believes that our involvement with Rock Dove shaped the course of our work, our relationships, and our loves. However, this also meant that there was less stability, and that there were times when none of us had the time or space to do even our most core work. It was only in our fifth year that we successfully incorporated a new member, a transperson in their forties who brought invaluable gifts to our work. We believe that if our collective were more firmly comprised of people at different stages of their lives - people in middle age and elders, especially - there would have been more consistency in our efforts and ability to hold shifting capacities among some of us. We also denied ourselves the opportunity to learn and grow from dialogue with more seasoned organizers. Intergenerational membership is critical for the health, sustainability, and longevity of collective work and relationships.</p>
<strong><p>Legacy and Where Dove Love Lives Now</p></strong>
<p>Starting in late 2011 or early 2012, our work, family, and personal commitments made it difficult for us to follow through on our responsibilities and keep Rock Dove afloat. By the middle of 2013, we were forced to articulate to each other what we had each known in our hearts for some time: it was time to let the sun set on Rock Dove. It has taken so very long for us to articulate this to the broader community, in part because it makes it very real, and that makes us very sad.</p>
<p>We are so proud of the work that each of us has done and continues to do to advance a more healthy and just world, both individually and in community. Two of us have relationships with the Third Root Education Exchange, which provides space and resources for diverse community to share knowledge and access learning about their health and healing in Brooklyn. We count two social workers, one acupuncturist, one participatory justice worker, and one herbalist among our ranks. Two of us are directors of innovative social justice projects. We are each skilled facilitators and consistently find ourselves drawing upon the creativity, intuition, and innovation that we developed in community with each other through Rock Dove. We have and will continue to nurture healing justice projects at convergences like the Allied Media Conference, and the US Social Forum. We are proud of our participation in efforts to build a North American network of healing justice providers and projects, and have aspirations that the unique infrastructure of our website may one day be adapted to be continental in scope.
<p>We remain forever grateful to each other for the ways we enacted healing in our work together. Each of us feels that being a Rock Dove was among the most profoundly important experiences of our lives, and we count each other as among our closest friends and comrades. We are so very thankful. Thank you, as well, to our communities here in New York City and across the continent, for your support, your dialogue, your inspiration, and your love. We know that Rock Dove also lives on in you, and we are eager to see what comes next.
<p>Be Well, and One Love,</p>
<p>Rock Dove</p>
<?php
echo drawBottom();