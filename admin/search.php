<?php

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
    ->OrderBy('id', 'desc')
    ->where('name', 'LIKE', "%" . $_GET['search'] . "%")
    ->orWhere('email', 'LIKE', "%" . $_GET['search'] . "%")
    ->select(
        'id',
        'name',
        'email',
        'is_admin',
    )->pagination($per_page, $users_page);

[$users_total, $users] = $users;

$tasks = (new Task)
    ->join('users', 'user_id', 'id')
    ->OrderBy('created_at', 'desc')
    ->where('task', 'LIKE', "%" . $_GET['search'] . "%")
    ->select(
        'tasks.id',
        'users.id as user_id',
        'tasks.task',
        'tasks.created_at',
        'tasks.finished_at',
        'users.name',
    )->pagination($per_page, $tasks_page);
[$tasks_total, $tasks] = $tasks;
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
        <p>Users</p>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                for ($i = 1; $i <= ceil($users_total / $per_page); $i++) {
                ?>
                    <li class="page-item <?= $i == $users_page ? 'active' : '' ?>"><a class="page-link" href="search.php?<?= 'users_page=' . $i . '&tasks_page=' . $tasks_page ?>"><?= $i ?></a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($users as $user) {
                ?>
                    <tr>
                        <th scope="row"><?= $user['id'] ?></th>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['is_admin'] == 1 ? 'Admin' : 'User' ?></td>
                        <td>
                            <form action="/admin/logic/delete.php" method="post">
                                <input type="hidden" name="id" value="#">
                                <input type="hidden" name="user_id" value="#">
                                <input type="hidden" name="task_id" value="#">
                                <input type="submit" value="Edit" class="btn btn-success" name="delete">
                                <input type="submit" value="Delete" class="btn btn-danger" name="delete">
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <p>Tasks</p>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                for ($i = 1; $i <= ceil($tasks_total / $per_page); $i++) {
                ?>
                    <li class="page-item <?= $i == $tasks_page ? 'active' : '' ?>"><a class="page-link" href="search.php?<?= 'users_page=' . $users_page . '&tasks_page=' . $i ?>"><?= $i ?></a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created at</th>
                    <th scope="col">User name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($tasks as $task) {
                ?>
                    <tr>
                        <th scope="row"><?= $task['id'] ?></th>
                        <td><?= $task['task'] ?></td>
                        <td><?= $task['finished_at'] == null ? 'Progress' : $task['finished_at'] ?></td>
                        <td><?= $task['created_at'] ?></td>
                        <td><?= $task['name'] ?></td>
                        <td>
                            <form action="/admin/logic/delete.php" method="post">
                                <input type="hidden" name="id" value="#">
                                <input type="hidden" name="user_id" value="#">
                                <input type="hidden" name="task_id" value="#">
                                <input type="submit" value="Edit" class="btn btn-success" name="delete">
                                <input type="submit" value="Delete" class="btn btn-danger" name="delete">
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>