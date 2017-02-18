<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_586e4553c0474',
	'title' => __('Dogs: Basic info', 'dogium-dogs'),
	'fields' => array (
		array (
			'layout' => 'vertical',
			'choices' => array (
				'female' => __('Female', 'dogium-dogs'),
				'male' => __('Male', 'dogium-dogs'),
			),
			'default_value' => '',
			'other_choice' => 0,
			'save_other_choice' => 0,
			'allow_null' => 0,
			'return_format' => 'label',
			'key' => 'field_585a37e134282',
			'label' => __('Gender', 'dogium-dogs'),
			'name' => 'dgm_gender',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'display_format' => 'd/m/Y',
			'return_format' => 'Ymd',
			'first_day' => 1,
			'key' => 'field_585a377134280',
			'label' => __('Date of Birth', 'dogium-dogs'),
			'name' => 'dgm_date_of_birth',
			'type' => 'date_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'dogium_dog',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'the_content',
		1 => 'excerpt',
		2 => 'custom_fields',
		3 => 'revisions',
		4 => 'slug',
		5 => 'featured_image',
		6 => 'categories',
		7 => 'tags',
		8 => 'send-trackbacks',
	),
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_586e46bd652ce',
	'title' => __('Dogs: Breed', 'dogium-dogs'),
	'fields' => array (
		array (
			'multiple' => 0,
			'allow_null' => 0,
			'choices' => array (
			),
			'default_value' => array (
			),
			'ui' => 1,
			'ajax' => 0,
			'placeholder' => '',
			'return_format' => 'value',
			'key' => 'field_586e46c4cdbc1',
			'label' => __('Breed', 'dogium-dogs'),
			'name' => 'dgm_breeds',
			'type' => 'select',
			'instructions' => 'Please select breed of your dog.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => 'dgm-select-term',
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'dogium_dog',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_5874c79f11bc1',
	'title' => __('Dogs: Breed (other)', 'dogium'),
	'fields' => array (
		array (
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'key' => 'field_5874c7da9f70d',
			'label' => __('Other (what?)', 'dogium'),
			'name' => 'dgm_other_what',
			'type' => 'text',
			'instructions' => __('Type the breed of your dog', 'dogium-dogs'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => 'dgm-other-what',
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_taxonomy',
				'operator' => '==',
				'value' => 'dogium_breed:muu',
			),
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'dogium_dog',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_586e18a2caf2e',
	'title' => __('Dogs: Breeders', 'dogium-dogs'),
	'fields' => array (
		array (
			'multiple' => 1,
			'allow_null' => 0,
			'choices' => array (
			),
			'default_value' => array (
			),
			'ui' => 1,
			'ajax' => 0,
			'placeholder' => '',
			'return_format' => 'value',
			'key' => 'field_585a380b34283',
			'label' => __('Breeders (friends)', 'dogium-dogs'),
			'name' => 'dgm_friends_as_breeders',
			'type' => 'select',
			'instructions' => __('Select breeder(s) for your dog among registered users that are your friends.', 'dogium-dogs'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'multiple' => 1,
			'allow_null' => 0,
			'choices' => array (
			),
			'default_value' => array (
			),
			'ui' => 1,
			'ajax' => 1,
			'placeholder' => '',
			'return_format' => 'value',
			'key' => 'field_586cc21650843',
			'label' => __('Breeders (groups)', 'dogium-dogs'),
			'name' => 'dgm_groups_as_breeders',
			'type' => 'select',
			'instructions' => __('Select breeder(s) for your dog among groups.', 'dogium-dogs'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'default_value' => '',
			'new_lines' => '',
			'maxlength' => '',
			'placeholder' => 'Maija Malli',
			'rows' => '',
			'key' => 'field_586cc3496db71',
			'label' => __('Other breeders', 'dogium-dogs'),
			'name' => 'dgm_other_breeders',
			'type' => 'textarea',
			'instructions' => __('Add other breeders for your dog. Multiple names need to be separated by line break.', 'dogium-dogs'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'dogium_dog',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_58736638f39eb',
	'title' => __('Dogs: Commenting', 'dogium-dogs'),
	'fields' => array (
		array (
			'layout' => 'vertical',
			'choices' => array (
				'open' => __('Open', 'dogium-dogs'),
				'closed' => __('Closed', 'dogium-dogs'),
			),
			'default_value' => 'open',
			'other_choice' => 0,
			'save_other_choice' => 0,
			'allow_null' => 0,
			'return_format' => 'value',
			'key' => 'field_587366523c31c',
			'label' => __('Commenting', 'dogium-dogs'),
			'name' => 'dgm_allow_commenting',
			'type' => 'radio',
			'instructions' => __('Allow / disallow other users post comments on your dog. Comments are open by default.', 'dogium-dogs'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'dogium_dog',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_586e45d2e8da0',
	'title' => __('Dogs: Description', 'dogium-dogs'),
	'fields' => array (
		array (
			'default_value' => '',
			'new_lines' => 'wpautop',
			'maxlength' => 500,
			'placeholder' => '',
			'rows' => '',
			'key' => 'field_586e45e1d264b',
			'label' => __('Description', 'dogium-dogs'),
			'name' => 'dgm_description',
			'type' => 'textarea',
			'instructions' => __('Write a short description of your dog.', 'dogium-dogs'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'dogium_dog',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_586e462e3c0e4',
	'title' => __('Dogs: Images', 'dogium-dogs'),
	'fields' => array (
		array (
			'return_format' => 'id',
			'preview_size' => 'featured-xmall',
			'library' => 'uploadedTo',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => 5,
			'mime_types' => 'jpeg,jpg,png',
			'key' => 'field_5875ffaec48c3',
			'label' => __('Featured image', 'dogium-dogs'),
			'name' => 'dgm_featured_image',
			'type' => 'image',
			'instructions' => __('This is the main image of your dog. It will also show on your dogs listing page (and on other, site wide listing pages.)', 'dogium-dogs'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'library' => 'uploadedTo',
			'min' => '',
			'max' => 10,
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => 5,
			'mime_types' => 'jpg,jpeg,png',
			'insert' => 'prepend',
			'key' => 'field_586e2de0bc445',
			'label' => __('Image gallery', 'dogium-dogs'),
			'name' => 'dgm_image_gallery',
			'type' => 'gallery',
			'instructions' => __('Add additional photos of your dog. You can upload up to 10 images.', 'dogium-dogs'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'dogium_dog',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_586e4536b0de8',
	'title' => __('Dogs: Name', 'dogium-dogs'),
	'fields' => array (
		array (
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'key' => 'field_586977caa39f4',
			'label' => __('Official Name', 'dogium-dogs'),
			'name' => 'dgm_official_name',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'formatting' => 'html',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'dogium_dog',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'permalink',
		1 => 'the_content',
		2 => 'excerpt',
		3 => 'author',
		4 => 'categories',
	),
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_586e45a60e790',
	'title' => __('Dogs: Owners', 'dogium-dogs'),
	'fields' => array (
		array (
			'multiple' => 1,
			'allow_null' => 0,
			'choices' => array (
			),
			'default_value' => array (
			),
			'ui' => 1,
			'ajax' => 0,
			'placeholder' => '',
			'return_format' => 'value',
			'key' => 'field_585a37a534281',
			'label' => __('Owners', 'dogium-dogs'),
			'name' => 'dgm_owners',
			'type' => 'select',
			'instructions' => __('Select additional owners for your dog. Additional owners need to be registered users and your friends.', 'dogium-dogs'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
		array (
			'default_value' => '',
			'new_lines' => '',
			'maxlength' => '',
			'placeholder' => 'Etunimi Sukunimi',
			'rows' => '',
			'key' => 'field_586bf7a7a2282',
			'label' => __('Other owners', 'dogium-dogs'),
			'name' => 'dgm_other_owners',
			'type' => 'textarea',
			'instructions' => __('Additional owners that are not registered users / your friends. You can add multiple names separated by line break.', 'dogium-dogs'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'dogium_dog',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;