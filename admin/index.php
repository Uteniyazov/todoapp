<?php

require_once '../vendor/autoload.php';

use App\User;

if (!(new User)->isAdmin()) {
    echo "You aren't admin!";
    exit;
}
echo "Welcom to admin workspace!";
