<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

    ],

    // For Storage Directory
    'storage' => [
        'images'    => '/uploads/images/',
        'videos'    => '/uploads/videos/',
        'documents' => '/uploads/documents/',
    ],



    // Storage Directory (Saving and Rendering Links)
    'behealthy' => 
    [
        // Temporary saving before processing and moving files to final storage by jobs...
        'temporary' => 
        [
            'messages'     => storage_path() . '/uploads/messages/',     // filesystems.behealthy.temporary.messages
            'users'        => storage_path() . '/uploads/users/',        // filesystems.behealthy.temporary.users
            'applications' => storage_path() . '/uploads/applications/', // filesystems.behealthy.temporary.applications
        ],

        // Link to saving files...
        'save' => 
        [
            'messages'     => 'public/messages/',     // filesystems.behealthy.save.messages
            'users'        => 'public/users/',        // filesystems.behealthy.save.users
            'applications' => 'public/applications/', // filesystems.behealthy.save.applications
        ],

        // Link to serving/rendering files...
        'serve' => 
        [ 
            'messages'     => 'storage/messages/',     // filesystems.behealthy.serve.messages
            'users'        => 'storage/users/',        // filesystems.behealthy.serve.users
            'applications' => 'storage/applications/', // filesystems.behealthy.serve.applications
        ]
    ]

];
