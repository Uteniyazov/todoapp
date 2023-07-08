<?php

$page = "tasks";

require_once '../vendor/autoload.php';

use App\User;
use App\Task;

if (!(new User)->isAdmin()) {
    header('location: http://localhost:8080/');
    exit;
}

$user_id = $_GET['user_id'];

if (isset($_GET['user_id'])) {
    $tasks = (new Task)->where('user_id', '=', $_GET['user_id'])->get();
} else {
    $tasks = (new Task())->get();
}

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
        <div class="float-end">
            <a href=<?= isset($user_id) ? "add-task.php?user_id=$user_id" : "add-task.php" ?> class="btn btn-primary mb-3">
                Add task
            </a>
        </div>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created at</th>
                    <th scope="col">User ID</th>
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
                        <td><?= $task['user_id'] ?></td>
                        <td>
                            <form action="/admin/logic/delete.php" method="post">
                                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                <input type="hidden" name="user_id" value="<?= isset($_GET['user_id']) ? $_GET['user_id'] : null ?>">
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