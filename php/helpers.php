<?php

add_action('friends_friendship_post_delete', 'dogium_removed_friend', 10, 2);

// Check if dog has been assigned term "muu"
function dogium_get_dog_terms($id) {
	$terms = wp_get_post_terms($id, 'dogium_breed');
		if ( !empty($terms) ) {
			foreach ($terms as $term) {
				if ($term->name === 'Other') {
					return true;
					break 2;
				}
			}
		}
	}

// Remove shared dogs if friendship ends
function dogium_removed_friend($initiator_userid, $friends_userid) {
	// Posts authored by initiator first
	$allposts = get_posts(array(
		'author' => $initiator_userid,
		'post_type' => 'dogium_dog',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => 'dgm_owners',
				'value' => '"' . strval( $friends_userid ) . '"',
				'compare' => 'LIKE'
			)		
		)
	));

	if ($allposts) {
		foreach ($allposts as $apost) {
			$metadata = get_post_meta($apost->ID, 'dgm_owners', true);
			foreach ($metadata as $key=>$value) {
				if ( $value === strval( $friends_userid ) ) {
					unset( $metadata[$key] );
				}
			}
			update_post_meta($apost->ID, 'dgm_owners', $metadata);
		}
	}
	
	// Then vice versa (posts shared with initiator)
}