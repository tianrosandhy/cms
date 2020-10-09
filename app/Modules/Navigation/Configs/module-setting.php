<?php
return [
	'navigation' => [
		'hide_filter' => false,
		'hide_back_to_homepage_button' => false,
		'hide_add_button' => false,

		'action_type' => [
			'no action' => [
				'label' => 'No Action',
				'url' => '#',
				'fillable' => false,
			],
			'site' => [
				'label' => 'Website URL',
				'url' => '',
				'fillable' => true,
				'route_prefix' => 'front'
			],
			'url' => [
				'label' => 'Custom URL',
				'url' => '',
				'fillable' => true,
			],

//jika ingin mengaktifkan navigasi url berdasarkan tabel lain seperti post & page, bisa mengaktifkan config dibawah ini
/*
			'post category' => [
				'label' => 'Post Category',
				'url' => 'blog/category/',
				'fillable' => true,
				'model_source' => \App\Modules\Post\Models\PostCategory::class,
				'source_is_active_field' => 'is_active',
				'source_label' => 'title',
			],
			'post detail' => [
				'label' => 'Post Detail',
				'url' => '/',
				'fillable' => true,
				'model_source' => \App\Modules\Post\Models\Post::class,
				'source_is_active_field' => 'is_active',
				'source_label' => 'title',
			],
			'pages' => [
				'label' => 'Static Page',
				'url' => '/',
				'fillable' => true,
				'model_source' => \App\Modules\Page\Models\Page::class,
				'source_is_active_field' => 'is_active',
				'source_label' => 'title',
			],
*/

		]		
	]
];