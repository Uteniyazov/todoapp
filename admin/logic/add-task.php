<?php

require_once '../../vendor/autoload.php';

use App\User;
use App\Task;

date_default_timezone_set('Asia/Tashkent');

if (!(new User)->isAdmin()) {
    header('location: http://localhost:8080/');
    exit;
}

if (empty($_POST['title'])) {
    header('location: ../add-task.php?error=field must be required!');
    exit;
}

if (empty($_POST['user_id'])) {
    header('location: ../add-task.php?error=field must be required!');
    exit;
}

$user_id = $_POST['user_id'];
(new Task())->create([
    'task' => $_POST['title'],
    'created_at' => date('Y-m-d H:i:s'),
    'user_id' => $user_id,
    'finished_at' => null,
]);

header('location: ../tasks.php');
exit;
