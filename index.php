<?php

if (!isset($_COOKIE['is_login'])) {
    header('location: auth.php');
    exit;
}
if (isset($_COOKIE['is_login']) and $_COOKIE['is_login'] != 1) {
    header('location: auth.php');
    exit;
}

require_once './vendor/autoload.php';

use App\Task;

$filter = 'all';

$action = 'new';
$tasks = (new Task())->where('user_id', '=', $_COOKIE['user_id']);
if (isset($_GET['tasks'])) {
    if ($_GET['tasks'] == 'completed') {
        $filter = 'completed';
        $tasks = $tasks->where('finished_at', 'IS NOT', null);
    } elseif ($_GET['tasks'] == 'pending') {
        $filter = 'pending';
        $tasks = $tasks->where('finished_at', 'IS', null);
    }
}
$tasks = $tasks->get();

if (isset($_GET['id']) and isset($_GET['type']) and $_GET['type'] == 'edit') {
    $action = 'edit';
    $task = (new Task())->where('id', '=', $_GET['id'])->where('user_id', '=', $_COOKIE['user_id'])->first();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>My tasks</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/todo.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>

<body>
    <div class="wrapper">
        <form action="logic/task.php" method="post">
            <input type="hidden" name="type" value="<?= $action ?>">
            <input type="hidden" name="id" value="<?= isset($_GET['id']) ? $_GET['id']  : '' ?>">
            <div class="task-input">
                <img src="assets/bars-icon.svg" alt="icon">
                <input type="text" maxlength="255" placeholder="Add a new task" name="task" value="<?= isset($task) ? $task['task'] : '' ?>">
            </div>
        </form>
        <div class="controls">
            <div class="filters">
                <a href="index.php?tasks=all"><span class="<?= $filter == 'all' ? 'active' : '' ?>">All</span></a>
                <a href="index.php?tasks=pending"><span class="<?= $filter == 'pending' ? 'active' : '' ?>">Pending</span></a>
                <a href="index.php?tasks=completed"><span class="<?= $filter == 'completed' ? 'active' : '' ?>">Completed</span></a>
            </div>
            <a href="delete.php?id=all">
                <button class="clear-btn">Clear All</button>
            </a>
        </div>
        <ul class="task-box">
            <?php
            foreach ($tasks as $task) :
            ?>
                <li class="task">
                    <label>
                        <input type="checkbox" <?= $task['finished_at'] != null ? 'checked' : '' ?>>
                        <p class="completed"><?= $task['task'] ?></p>
                    </label>
                    <div class="settings">
                        <i onclick="showMenu(this)" class="uil uil-ellipsis-h"></i>
                        <ul class="task-menu">
                            <li><a href="index.php?id=<?= $task['id'] ?>&type=edit"><i class="uil uil-pen"></i>Edit</a></li>
                            <li><a href="delete.php?id=<?= $task['id'] ?>"><i class=" uil uil-trash"></i>Delete</a></li>
                            <li><a href="finish.php?id=<?= $task['id'] ?>"><i class="uil uil-check"></i>Finish</a></li>
                        </ul>
                    </div>
                </li>
            <?php
            endforeach;
            ?>
        </ul>
    </div>
    <script>
        function showMenu(selectedTask) {
            let menuDiv = selectedTask.parentElement.lastElementChild;
            menuDiv.classList.add("show");
            document.addEventListener("click", e => {
                if (e.target.tagName != "I" || e.target != selectedTask) {
                    menuDiv.classList.remove("show");
                }
            });
        }
    </script>
</body>

</html>