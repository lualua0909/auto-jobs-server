<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAA4kTiXkE:APA91bGPZ77BtpVzwxD2bn7m-4nZ0mOQv-9Lqcd6gmwDrRgncMgqFEQBTpL8FaSsiiVbj_X9UXYeWLmKLOqAz3rOp4oAZbuH9E9J1nM99Nkn27Rvyg7xAo0RAkmDYyCslBzZPfFU0CVP'),
        'sender_id' => env('FCM_SENDER_ID', '971818294849'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
