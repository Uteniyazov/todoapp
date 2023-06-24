<?php
$db = new mysqli('localhost', 'root', '', 'todo_app', 3306);

if (!$db) {
    echo "Wrong mysql connect";
    exit;
}
