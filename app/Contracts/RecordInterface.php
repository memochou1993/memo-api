<?php

namespace App\Contracts;

use App\User;

interface RecordInterface
{
    public function getRecordsByUser(User $user);
    public function getPublicRecordsByUser(User $user);
    public function getRecordByUser(User $user, int $id);
    public function getPublicRecordByUser(User $user, int $id);
}
