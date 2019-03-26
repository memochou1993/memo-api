<?php

namespace App\Contracts;

use App\User;

interface RecordInterface
{
    public function getRecordsByUser(User $user);
    public function getPublicRecordsByUser(User $user);
}
