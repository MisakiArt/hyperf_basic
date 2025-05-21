<?php
use function Hyperf\Support\env;
return [
    // 是否开启定时任务
    'enable' => env("CRONTAB_JOB_ENABLE", false),
];