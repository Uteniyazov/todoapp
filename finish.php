<?php

require_once 'vendor/autoload.php';

use App\Task;

date_default_timezone_set('Asia/Tashkent');

(new Task())
    ->where('user_id', '=', $_COOKIE['user_id'])
    ->where('id', '=', $_GET['id'])
    ->update([
        'finished_at' => date('Y-m-d H:i:s'),
    ]);
header('location: index.php');
