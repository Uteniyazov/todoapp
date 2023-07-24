<?php

require_once '../../vendor/autoload.php';

use App\User;

if (!(new User)->isAdmin()) {
    header('location: http://localhost:8080/');
    exit;
}

if (empty($_POST['name']) or empty($_POST['email']) or empty($_POST['password']) or empty($_POST['role'])) {
    header('location: ../new-user.php?error=all fields must be required!');
    exit;
}

$check = (new User)->whereEmail($_POST['email']);

if ($check) {
    header('location: ../new-user.php?error=email already exist');
    exit;
}

(new User)->create([
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'password' => md5($_POST['password']),
    'is_admin' => intval($_POST['role'] == 'admin'),
]);

header('location: ../users.php');
exit;
