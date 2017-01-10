<?php

// Check if dog has been assigned term "muu"
function dogium_get_dog_terms($id) {
	$terms = wp_get_post_terms($id, 'dogium_breed');
		if ( !empty($terms) ) {
			foreach ($terms as $term) {
				if ($term->name === 'Muu') {
					return true;
					break 2;
				}
			}
		}
	}	