<?php

namespace App\Contracts;

use App\User;
use App\Http\Requests\RecordRequest as Request;

interface RecordInterface
{
    /**
     * @param  \App\User  $user
     * @return \App\Record
     */
    public function getRecordsByUser(User $user);

    /**
     * @param  \App\User  $user
     * @return \App\Record
     */
    public function getPublicRecordsByUser(User $user);

    /**
     * @param  \App\User  $user
     * @param  int  $id
     * @return \App\Record
     */
    public function getRecordByUser(User $user, int $id);

    /**
     * @param  \App\User  $user
     * @param  int  $id
     * @return \App\Record
     */
    public function getPublicRecordByUser(User $user, int $id);

    /**
     * @param  \App\User  $user
     * @param  \App\Http\Requests\RecordRequest  $request
     * @return \App\Record
     */
    public function storeRecord(User $user, Request $request);
}
