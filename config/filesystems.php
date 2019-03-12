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
            // 'messages' =>
            // [ 
            //     'images' => storage_path() . '/uploads/messages/images/', // filesystems.behealthy.temporary.messages.images
            //     'videos' => storage_path() . '/uploads/messages/videos/', // filesystems.behealthy.temporary.messages.videos
            //     'others' => storage_path() . '/uploads/messages/others/', // filesystems.behealthy.temporary.messages.others
            // ],
            // 'users' =>
            // [ 
            //     'images' => storage_path() . '/uploads/users/images/', // filesystems.temporary.messages.images
            // ],
            // 'applications' =>
            // [
            //     'others' => storage_path() . '/uploads/applications/others/', // filesystems.temporary.messages.others
            // ],

            'images' =>
            [ 
                'general' => storage_path() . '/uploads/images/',         // filesystems.behealthy.temporary.images.general
                'message' => storage_path() . '/uploads/images/messages/',// filesystems.behealthy.temporary.images.message
                'user'    => storage_path() . '/uploads/images/users/',   // filesystems.behealthy.temporary.images.user
            ],
            'videos' =>
            [
                'general' => storage_path() . '/uploads/videos/',         // filesystems.behealthy.temporary.videos.general
                'message' => storage_path() . '/uploads/videos/messages/',// filesystems.behealthy.temporary.videos.message
            ],
            'other-files' =>
            [
                'general' => storage_path() . '/uploads/other-files/',         // filesystems.behealthy.temporary.other-files.general
                'message' => storage_path() . '/uploads/other-files/messages/',// filesystems.behealthy.temporary.other-files.message
            ],
        ],

        // Link to saving files...
        'save' => 
        [
            // 'messages' =>
            // [ 
            //     'images' => storage_path() . 'public/messages/images/', // filesystems.behealthy.save.messages.images
            //     'videos' => storage_path() . 'public/messages/videos/', // filesystems.behealthy.save.messages.videos
            //     'others' => storage_path() . 'public/messages/others/', // filesystems.behealthy.save.messages.others
            // ],
            // 'users' =>
            // [ 
            //     'images' => storage_path() . 'public/users/images/', // filesystems.save.messages.images
            // ],
            // 'applications' =>
            // [
            //     'others' => storage_path() . 'public/applications/others/', // filesystems.save.messages.others
            // ],


            'local-storage' =>
            [
                'images' =>
                [ 
                    'general' => 'public/images/',         // filesystems.behealthy.save.local-storage.images.general
                    'message' => 'public/images/messages/',// filesystems.behealthy.save.local-storage.images.message
                    'user'    => 'public/images/users/',   // filesystems.behealthy.save.local-storage.images.user
                ],
                'videos' =>
                [
                    'general' => 'public/videos/',         // filesystems.behealthy.save.local-storage.videos.general
                    'message' => 'public/videos/messages/',// filesystems.behealthy.save.local-storage.videos.message
                ],
                'other-files' =>
                [
                    'general' => 'public/other-files/',         // filesystems.behealthy.save.local-storage.other-files.general
                    'message' => 'public/other-files/messages/',// filesystems.behealthy.save.local-storage.other-files.message
                ],
            ],
            'external-storage' => [
                'videos' => '',
                'images' => '',
                'other-files' => '',
            ]
        ],

        // Link to serving/rendering files...
        'serve' => 
        [ 
            // 'messages' =>
            // [ 
            //     'images' => storage_path() . 'storage/messages/images/', // filesystems.behealthy.serve.messages.images
            //     'videos' => storage_path() . 'storage/messages/videos/', // filesystems.behealthy.serve.messages.videos
            //     'others' => storage_path() . 'storage/messages/others/', // filesystems.behealthy.serve.messages.others
            // ],
            // 'users' =>
            // [ 
            //     'images' => storage_path() . 'storage/users/images/', // filesystems.save.messages.images
            // ],
            // 'applications' =>
            // [
            //     'others' => storage_path() . 'storage/applications/others/', // filesystems.save.messages.others
            // ],


            'local-storage' =>
            [
                'images' =>
                [ 
                    'general' => 'storage/images/',         // filesystems.behealthy.serve.local-storage.images.general
                    'message' => 'storage/images/messages/',// filesystems.behealthy.serve.local-storage.images.message
                    'user'    => 'storage/images/users/',   // filesystems.behealthy.serve.local-storage.images.user
                ],
                'videos' =>
                [
                    'general' => 'storage/videos/',         // filesystems.behealthy.serve.local-storage.videos.general
                    'message' => 'storage/videos/messages/',// filesystems.behealthy.serve.local-storage.videos.message
                ],
                'other-files' =>
                [
                    'general' => 'storage/other-files/',         // filesystems.behealthy.save.local-storage.other-files.general
                    'message' => 'storage/other-files/messages/',// filesystems.behealthy.save.local-storage.other-files.message
                ],
            ],
            // 'external-storage' => [
            //     'videos' => '',
            //     'images' => '',
            //     'other-files' => '',
            // ]
        ]
    ]

];
