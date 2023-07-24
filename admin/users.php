<?php

$page = "users";

require_once '../vendor/autoload.php';

use App\User;

if (!(new User)->isAdmin()) {
    header('location: http://localhost:8080/');
    exit;
}
$sort = isset($_GET['sort']) ? $_GET['sort'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;

$users = (new User);
$page = 1;
$per_page = 10;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$users = $users
    ->select(
        'users.id',
        'users.name',
        'users.email',
        'users.is_admin'
    );

if ($sort and $type) {
    $users = $users->OrderBy($sort, $type);
}

$users = $users->pagination($per_page, $page);

[$total, $users] = $users;
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
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                for ($i = 1; $i <= ceil($total / $per_page); $i++) {
                ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="users.php?page=<?= $i ?>"><?= $i ?></a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col"><a href="users.php?sort=id&type=<?= $type == 'asc' ? 'desc' : 'asc' ?>">#</a></th>
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
                                    <input onclick="return confirm('Are you sure?')" type="submit" value="Delete" class="btn btn-danger" name="button">
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