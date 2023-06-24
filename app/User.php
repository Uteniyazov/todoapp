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
}
