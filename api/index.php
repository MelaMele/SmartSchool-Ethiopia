<?php

// 1. በ Vercel ጊዜያዊ ፎልደር (/tmp) ውስጥ አስፈላጊ የሆኑትን የ Storage ፎልደሮች መፍጠር
$dirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// 2. Laravel ሎግ እና ካሼን በ /tmp እንዲጠቀም ማዘዝ
putenv('APP_STORAGE=/tmp/storage');
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
putenv('LOG_CHANNEL=stderr');
putenv('CACHE_DRIVER=array');
putenv('SESSION_DRIVER=cookie');

// 3. መተግበሪያውን ማስነሳት
require __DIR__ . '/../public/index.php';
