<?php

require_once '../../vendor/autoload.php';

use App\User;
use App\Task;

date_default_timezone_set('Asia/Tashkent');

if (!(new User)->isAdmin()) {
    header('location: http://localhost:8080/');
    exit;
}

$task = (new Task)->where('id', '=', $_POST['task_id'])->first();
$user_id = $task['user_id'];

$task_id = $_POST['task_id'];
if (empty($_POST['task'])) {
    header("location: ../edit.php?task_id=$task_id&error=field must be required!");
    exit;
}

if ($_POST['button'] == 'Edit') {
    if (isset($_POST['task'])) {
        (new Task())->where('id', '=', $_POST['task_id'])
            ->update([
                'task' => $_POST['task'],
            ]);
        header("location: ../tasks.php?user_id=$user_id");
        exit;
    }
}
