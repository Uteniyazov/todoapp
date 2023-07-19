<?php

$page = "users";

require_once '../vendor/autoload.php';

use App\User;
use App\Task;

if (!(new User)->isAdmin()) {
    header('location: http://localhost:8080/');
    exit;
}

$task = (new Task)->where('id', '=', $_GET['task_id'])->first();

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
        <?php
        if (isset($_GET['error']) and !empty($_GET['error'])) {
        ?>
            <p class="text-danger h3 mb-3 mt-3">
                Error: <?= $_GET['error'] ?>
            </p>
        <?php
        }
        ?>
        <form class="row g-3" action="/admin/logic/edit.php" method="post">
            <div class="col-6 mb-3">
                <label for="task-end" class="form-label">Task</label>
                <input type="text" class="form-control" id="task" value="<?= $task['task'] ?>" name="task">
            </div>
            <div class="col-6 mb-3 ">
                <label class="form-label">Edit task</label>
                <div class="d-grid">
                    <input type="hidden" name="task_id" value="<?= $_GET['task_id'] ?>">
                    <input type="submit" class="btn btn-primary" value="Edit" name="button">
                </div>
            </div>
        </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>