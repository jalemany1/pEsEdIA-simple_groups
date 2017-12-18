<?php
/**
 * Group edit form
 *
 * This view contains everything related to group types.
 * eg: how can people join this group, who can see the group, etc
 *
 * @package ElggGroups
 */

$options = array();

if (elgg_get_plugin_setting('hidden_groups', 'groups') == 'yes')
	$options[elgg_echo('groups:policy:secret')] = 5;

$options[elgg_echo('groups:policy:private')] = 2;
$options[elgg_echo('groups:policy:public')] = 1;

$entity = elgg_extract("entity", $vars, false);

$default_value = 1;
if ($entity) {
	if ($entity->membership == ACCESS_PUBLIC) {
		$default_value = 1;
	} else if ($entity->access_id == ACCESS_LOGGED_IN) {
		$default_value = 2;
	} else {
		$default_value = 5;
	}
}

?>

<div>
	<label for="groups-types"><?php echo elgg_echo("groups:types"); ?></label><br />
	<div id="images"></div>
	<?php echo elgg_view('input/radio', array(
		'name' => 'policy',
		'id' => 'polic',
		'options' => $options,
		'value' => $default_value,
	));

	?>
</div>