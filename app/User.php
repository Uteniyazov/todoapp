<?php

namespace App;

use App\Abstract\Model;


class User extends Model
{
    protected string $table = 'users';

    public function whereEmail($email): bool|array|null
    {
        return $this->where('email', '=', $email)->first();
    }

    public function find($id)
    {
        return $this->where('id', '=', $_COOKIE['user_id']);
    }

    public function isAdmin()
    {
        $user = $this->find($_COOKIE['user_id'])->first();
        return $user['is_admin'] == 1;
    }

    public function tasks()
    {
        $tasks = (new Task)->where('user_id', '=', $_COOKIE['user_id'])->get();
        return $tasks;
    }
}
