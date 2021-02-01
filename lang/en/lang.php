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
        'name'                      => 'Name',
        'slug'                      => 'Slug',
        'image'                     => 'Image',
        'domain'                    => 'Domain',
        'is_active'                 => 'Is active?',
        'settings_title'            => 'Title',
        'settings_lead'             => 'Lead',
        'settings_description'      => 'Description',
        'settings_ios_app_url'      => 'iOS app url',
        'settings_android_app_url'  => 'Android app url',
        'is_landlord'               => 'Is landlord',
        'groups'                    => 'Groups',
        'label'                     => 'Label',
        'code'                      => 'Code',
        'group'                     => 'Group',
        'resolvers'                 => 'Resolvers',
        'resolver'                  => 'Resolver',
    ],

    'tab' => [
        'users' => 'Users',
        'settings' => 'Settings',
        'app' => 'Mobile app',
    ],
];