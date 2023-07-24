<?php

$page = "tasks";

require_once '../vendor/autoload.php';

use App\User;
use App\Task;

$sort = isset($_GET['sort']) ? $_GET['sort'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;

$from = isset($_GET['from']) ? $_GET['from'] : null;
$to = isset($_GET['to']) ? $_GET['to'] : null;

if (!(new User)->isAdmin()) {
    header('location: http://localhost:8080/');
    exit;
}

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
$tasks = (new Task)->join('users', 'user_id', 'id');
if (isset($_GET['user_id'])) {
    $tasks = $tasks->where('user_id', '=', $_GET['user_id']);
}
$page = 1;
$per_page = 10;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$tasks = $tasks
    ->select(
        'tasks.id',
        'users.id as user_id',
        'tasks.task',
        'tasks.created_at',
        'tasks.finished_at',
        'users.name',
    );
if ($sort and $type) {
    $tasks = $tasks->OrderBy($sort, $type);
}
if ($from and $to) {
    $tasks = $tasks->where("date(created_at)", '>=', $from)->where("date(created_at)", '<=', $to);
}

$tasks = $tasks->pagination($per_page, $page);

[$total, $tasks] = $tasks;
// print_r($tasks);
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
        <div class="d-flex justify-content-between">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php
                    for ($i = 1; $i <= ceil($total / $per_page); $i++) {
                    ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="tasks.php<?= isset($user_id) ? "?user_id=" . "$user_id&" : '?' ?><?= "page=" . "$i" ?>"><?= $i ?></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
            <form action="tasks.php" method="GET">
                <input type="date" name="from" class="form-control" value="<?= $from ?>">
                <input type="date" name="to" class="form-control" value="<?= $to ?>">
                <input class="btn btn-success form-control" type="submit" value="Submit">
            </form>
            <div>
                <a href=<?= isset($user_id) ? "add-task.php?user_id=$user_id" : "add-task.php" ?> class="btn btn-primary mb-3">
                    Add task
                </a>
            </div>
        </div>

        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col"><a href="tasks.php?sort=id&type=<?= $type == 'asc' ? 'desc' : 'asc' ?>&from=<?= $from ?>&to=<?= $to ?>">#</a></th>
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col"><a href="tasks.php?sort=created_at&type=<?= $type == 'asc' ? 'desc' : 'asc' ?>&from=<?= $from ?>&to=<?= $to ?>">Created at</a></th>
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
                        <td><?= $task['finished_at'] === null ? 'Progress' : $task['finished_at'] ?></td>
                        <td><?= $task['created_at'] ?></td>
                        <td><?= $task['name'] ?></td>
                        <td>
                            <form action="/admin/logic/delete.php" method="post">
                                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                <input type="hidden" name="user_id" value="<?= isset($_GET['user_id']) ? $_GET['user_id'] : null ?>">
                                <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
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