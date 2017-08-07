<?php 
return [
	// Post
	'post'	=> 'post/index',
	'post/view/<id:\d+>' => 'post/view',
	'post/approve/<id:\d+>' => 'post/approve',
	'post/disapprove/<id:\d+>' => 'post/disapprove',
	'post/warning/<id:\d+>' => 'post/warning',

	// User
	'user'	=> 'user/index',
	'user/view/<id:\d+>' => 'user/view',

	// Image
	'image' => 'image/index',
	'image/ajax-delete/<id:\d+>' => 'image/ajax-delete',

	// Category
	'category' => 'category/index',
	'category/edit/<id:\d+>' => 'category/edit',
	'category/change-visible/<id:\d+>' => 'category/change-visible',

	// Location
	'location' => 'location/index',
	'location/province/change/<id:\d+>' => 'location/change-visible-province',



	'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
];
?>