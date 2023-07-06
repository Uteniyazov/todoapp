<?php

$page = "users";

require_once '../vendor/autoload.php';

use App\User;

if (!(new User)->isAdmin()) {
    echo "You aren't admin!";
    exit;
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
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Izzet Uteniyazov</td>
                    <td>izzet@mail.ru</td>
                    <td>
                        <form action="delete.php" method="post">
                            <input type="hidden" name="id" value="1">
                            <input type="submit" value="Tasks" class="btn btn-success">
                            <input type="submit" value="Delete" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Pikachu</td>
                    <td>pika@mail.com</td>
                    <td>
                        <form action="delete.php" method="post">
                            <input type="hidden" name="id" value="1">
                            <input type="submit" value="Tasks" class="btn btn-success">
                            <input type="submit" value="Delete" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>