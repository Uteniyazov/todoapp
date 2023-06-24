<?php
require_once '../vendor/autoload.php';

use App\User;


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "ONLY POST";
    exit;
}

if (
    empty($_POST['name']) or
    empty($_POST['email']) or
    empty($_POST['password'])
) {
    echo "all filed is required!";
    exit;
}
$user = (new User())->whereEmail($_POST['email']);
if (!is_null($user)) {
    echo "Email bar basqa email jaz";
    exit;
}

try {
    (new User())->create([
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => md5($_POST['password']),
    ]);
    $user = (new User())->whereEmail($_POST['email']);
    setcookie('is_login', true, time() + 604800, "/");
    setcookie('user_id', $user['id'], time() + 604800, "/");
    echo "Your are successful register!";
} catch (\Exception $e) {
    echo  $e->getMessage();
    exit;
}
