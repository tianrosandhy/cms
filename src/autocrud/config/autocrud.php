<?php
return [
    'route_prefix' => 'autocrud',
    'lang' => [
        'available' => [
            'en' => 'English',
            'id' => 'Indonesian',
        ],
        'default' => 'en',
    ],
    'max_filesize' => [
        'file' => 20,
        'image' => 20,
    ],

    'asset_url' => 'autocrud-assets/',
    'asset_dependency' => [
        'load_bootstrap' => true,
        'load_jquery' => true,
        'load_iconify' => true,
        'load_plugins' => true,
    ],

    'renderer' => [
        'table' => 'autocrud::datatable.table-generator',
        'table_asset' => 'autocrud::datatable.asset-generator',
        'form' => 'autocrud::form.generator',
    ],
];