<?php
/**
 * Group edit form
 *
 * @package Pesedia
 */

/* @var ElggGroup $entity */

//Loading the css file
elgg_load_css('policies');

$entity = elgg_extract("entity", $vars, false);

// context needed for input/access view
elgg_push_context("group-edit");

// build the group profile fields
echo elgg_view("groups/edit/profile", $vars);

// build the group type options
echo elgg_view("groups/edit/type", $vars);

// display the save button and some additional form data
if ($entity) {
	echo elgg_view("input/hidden", array(
		"name" => "group_guid",
		"value" => $entity->getGUID(),
	));
}

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);

if ($entity) {
	$delete_url = "action/groups/delete?guid=" . $entity->getGUID();
	$footer .= elgg_view("output/url", array(
		"text" => elgg_echo("groups:delete"),
		"href" => $delete_url,
		"confirm" => elgg_echo("groups:deletewarning"),
		"class" => "elgg-button elgg-button-delete float-alt",
	));
}

elgg_set_form_footer($footer);

elgg_pop_context();
