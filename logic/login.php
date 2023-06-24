<?php

require_once '../vendor/autoload.php';

use App\User;

if (empty($_POST['email']) or empty($_POST['password'])) {
    header('location: ../auth.php');
    exit;
}
$user = (new User())->whereEmail($_POST['email'], md5($_POST['password']));

if (is_null($user)) {
    echo "Wrong email or password";
    exit;
}
setcookie('user_id', $user['id'], time() + 604800, "/");
setcookie('is_login', true, time() + 604800, "/");
header('location: ../auth.php');
