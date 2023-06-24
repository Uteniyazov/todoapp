<?php

require_once './vendor/autoload.php';

use App\Task;

if (!isset($_GET['id'])) {
    echo "ERROR";
    exit;
}

if ($_GET['id'] == 'all') {
    (new Task())->where('user_id', '=', $_COOKIE['user_id'])->delete();
} else {
    (new Task())
        ->where('id', '=', $_GET['id'])
        ->where('user_id', '=', $_COOKIE['user_id'])
        ->delete();
}

header('location: index.php');
