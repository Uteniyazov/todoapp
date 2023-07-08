<?php

$page = "users";

require_once '../vendor/autoload.php';

use App\User;

if (!(new User)->isAdmin()) {
    header('location: http://localhost:8080/');
    exit;
}

$users = (new User)->get();
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
            <a href="new-user.php" class="btn btn-primary mb-3">
                New User as admin
            </a>
        </div>
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
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <input type="submit" value="Tasks" class="btn btn-success" name="button">
                                <?php
                                if ($user['id'] != $_COOKIE['user_id']) {
                                ?>
                                    <input type="submit" value="Delete" class="btn btn-danger" name="button">
                                <?php
                                }
                                ?>
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