<?php

/**
 * Simple Groups
 *
 * @author Jose Alemany Bordera <jalemany1@dsic.upv.es>
 * @author Agustín Espinosa Minguet <aespinos@upvnet.upv.es>
 * @copyright Copyright (c) 2017, GTI-IA
 */

elgg_register_event_handler('init', 'system', function() {

	/* Repair ClosedMembership-Group access invitation */
	// Add access grant
	elgg_register_event_handler('create', 'relationship', 'add_access_grant_to_invited_group');
	// Revoke access grant
	elgg_register_event_handler('delete', 'relationship', 'del_access_grant_to_invited_group');

	/* Simplify group creation */
	elgg_unregister_action('groups/edit');
	elgg_register_action('groups/edit', __DIR__ . '/actions/groups/edit.php');
	elgg_register_css('policies', elgg_get_simplecache_url('policies.css'));

});

/**
 * When 'groups_invite' plugin is enabled and a user invite another, this function
 * give a temporary access grant to the group.
 *
 * @param string        $event          'create'
 * @param string        $type           'relationship'
 * @param array         $object         ElggRelationship
 * @return boolean
 */
function add_access_grant_to_invited_group($event, $type, $object) {
	if ($object->relationship == 'invited') {
		add_entity_relationship($object->guid_one, 'access_grant', $object->guid_two);
	}
}

/**
 * When 'groups_invite' plugin is enabled and a user decline a group invitation,
 * this function remove the temporary access grant to the group.
 *
 * @param string        $event          'delete'
 * @param string        $type           'relationship'
 * @param array         $object         ElggRelationship
 * @return boolean
 */
function del_access_grant_to_invited_group($event, $type, $object) {
	if ($object->relationship == 'invited') {
		remove_entity_relationship($object->guid_one, 'access_grant', $object->guid_two);
	}
}