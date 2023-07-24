<?php

$page = "index";

require_once '../vendor/autoload.php';

use App\User;
use App\Task;

if (!(new User)->isAdmin()) {
    header('location: http://localhost:8080/');
    exit;
}
$users_page = 1;
$tasks_page = 1;
$per_page = 2;
if (isset($_GET['users_page'])) {
    $users_page = $_GET['users_page'];
}
if (isset($_GET['tasks_page'])) {
    $tasks_page = $_GET['tasks_page'];
}
$users = (new User)
    ->select(
        'id',
        'name',
        'email',
        'is_admin',
    )->pagination($per_page, $users_page);

[$users_total, $users] = $users;

$tasks = (new Task)
    ->join('users', 'user_id', 'id')
    // ->where('finished_at', '=', null)
    ->select(
        'tasks.id',
        'users.id as user_id',
        'tasks.task',
        'tasks.created_at',
        'tasks.finished_at',
        'users.name',
    )->pagination($per_page, $tasks_page);

[$tasks_total, $tasks] = $tasks;
// print_r($tasks_total);
// exit;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <?php
        include_once('./components/nav.php');
        ?>
        <div class="row">
            <div class="col-6">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="/admin/images/images.png" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Users count</h5>
                                <p class="card-text"><?= $users_total ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="/admin/images/images.png" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Tasks count</h5>
                                <p class="card-text"><?= $tasks_total ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="/admin/images/images.png" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Finished tasks count</h5>
                                <p class="card-text">90</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="/admin/images/images.png" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Progress tasks count</h5>
                                <p class="card-text">0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>