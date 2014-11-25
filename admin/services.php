<?php
include("../include.php");

echo drawTop("Services");

$services = db_table("SELECT 
	s.id, 
	c.id category_id,
	c.name category_name,
	s.title,
	s.description,
	(SELECT COUNT(*) FROM providers_to_services p2s WHERE p2s.option_id = s.id) providers
	FROM categories c
	JOIN categories_to_services c2s ON c.id = c2s.option_id
	JOIN options_service s ON c2s.object_id = s.id
	ORDER BY c.name, s.title");
$count1 = count($services);
for ($i = 0; $i < $count1; $i++) {
	$services[$i]["group"] = '<a href="categories-edit.php?id=' . $services[$i]["category_id"] . '">' . $services[$i]["category_name"] . '</a>';
	$services[$i]["has_description"]	= format_boolean(strlen(trim($services[$i]["description"])));
	$services[$i]["link"]	 = "services-edit.php?id=" . $services[$i]["id"];
}

$uncategorized = db_table("SELECT 
	s.id, 
	s.title,
	s.description,
	(SELECT COUNT(*) FROM providers_to_services p2s WHERE p2s.option_id = s.id) providers
	FROM options_service s WHERE (SELECT COUNT(*) FROM categories_to_services c2s WHERE c2s.object_id = s.id) = 0
	ORDER BY s.title");
$count2 = count($uncategorized);
for ($i = 0; $i < $count2; $i++) {
	$services[$i + $count1]["group"]	= "Uncategorized";
	$services[$i + $count1]["has_description"]	= format_boolean(strlen(trim($uncategorized[$i]["description"])));
	$services[$i + $count1]["providers"]	= $uncategorized[$i]["providers"];
	$services[$i + $count1]["title"]	= $uncategorized[$i]["title"];
	$services[$i + $count1]["link"]	= "services-edit.php?id=" . $uncategorized[$i]["id"];
}

echo drawButton(array("+ New Category"=>"categories-edit.php", "+ New Service"=>"services-edit.php"));
$table = new table();
$table->col("title");
$table->col("has_description", "c");
$table->col("providers", "r", "Number of Providers");
echo $table->draw($services, "No categories added yet", true);
echo drawBottom();?>