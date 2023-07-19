<?php

require_once '../../vendor/autoload.php';

use App\User;
use App\Task;


if (!(new User)->isAdmin()) {
    header('location: http://localhost:8080/');
    exit;
}

if ($_POST['button'] == 'Delete') {
    (new User)->where('id', '=', $_POST['id'])->delete();
    header('location: ../users.php');
    exit;
} elseif ($_POST['button'] == 'Tasks') {
    $id = $_POST['id'];
    header("location: ../tasks.php?user_id=$id");
    exit;
}

if ($_POST['delete'] == 'Delete') {
    if (isset($_POST['id'])) {
        (new Task())->where('id', '=', $_POST['id'])->delete();
        header('location: ../tasks.php');
        exit;
    } elseif (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        (new Task())->where('user_id', '=', $_POST['user_id'])->delete();
        header("location: ../tasks.php?user_id=$user_id");
        exit;
    }
}

if ($_POST['delete'] == 'Edit') {
    if (isset($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        header("location: ../edit.php?task_id=$task_id");
        exit;
    }
}
