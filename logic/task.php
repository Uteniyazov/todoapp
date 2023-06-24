<?php

require_once '../vendor/autoload.php';

use App\Task;

if (empty($_POST['task']) or !isset($_POST['type'])) {
    echo "FIELD MUST BE FILLED!";
    exit;
}

$user_id = $_COOKIE['user_id'];

if ($_POST['type'] == 'new') {
    (new Task())->create([
        'task' => $_POST['task'],
        'user_id' => $user_id,
        'created_at' => date('Y-m-d H:i:s'),
        'finished_at' => null,
    ]);
} elseif ($_POST['type'] == 'edit') {
    if (!isset($_POST['id'])) {
        echo "FIELD MUST BE FILLED!";
        exit;
    }

    (new Task())->where('id', '=', $_POST['id'])
        ->where('user_id', '=', $user_id)
        ->update([
            'task' => $_POST['task']
        ]);
}
header('location: ../index.php');
