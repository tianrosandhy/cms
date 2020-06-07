<?php
return [
	'admin' => [
		'prefix' => 'p4n3lb04rd',
		'auth_guard_name' => 'admin',
		'assets' => 'admin_assets',
	],
	'max_filesize' => [
		//if PHP max upload size is lower, then these settings are ignored
		'image' => 20,
		'file' => 20
	],
];