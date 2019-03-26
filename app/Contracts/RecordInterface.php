<?php

namespace App\Contracts;

use App\User;

interface RecordInterface
{
    public function getRecordsByUser(User $user);
}
