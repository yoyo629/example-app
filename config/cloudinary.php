<?php

// herokuに設定した環境変数から値を設定
return [
    'cloud_name' => env('CLOUDINARY_CLOUD_NAME', null),
    'api_key' => env('CLOUDINARY_API_KEY', null),
    'api_secret' => env('CLOUDINARY_API_SECRET', null),
];
