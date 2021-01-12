<?php return [
    'plugin' => [
        'name'          => 'SaaS',
        'description'   => 'SaaS plugin for October CMS',
        'author'        => 'Sebastiaan Kloos',
    ],

    'menu' => [
        'own_tenant'    => 'My subscription',
    ],

    'scoreboard' => [
        'backend_users' => 'Backend users',
    ],

    'toolbar' => [
        'migrate_db' => 'Migrate DB',
        'refresh_db' => 'Refresh DB',

        'confirm' => [
            'migrate_db' => 'Are you sure you want to migrate the database?',
            'refresh_db' => 'Are you sure you want to refresh the database?',
        ],

        'loading' => [
            'migrate_db' => 'Migrating database...',
            'refresh_db' => 'Refreshing database...',
        ],
    ],

    'fields' => [
        'name' => 'Name',
        'slug' => 'Slug',
        'image' => 'Image',
        'is_active' => 'Is active?',
        'settings_title' => 'Title',
        'settings_lead' => 'Lead',
        'settings_description' => 'Description',
    ],

    'tab' => [
        'users' => 'Users',
        'settings' => 'Settings',
    ],
];