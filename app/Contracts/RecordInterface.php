<?php

namespace App\Contracts;

use App\User;
use App\Record;

interface RecordInterface
{
    /**
     * @return \App\Record
     */
    public function getRecords();

    /**
     * @param  int  $id
     * @return \App\Record
     */
    public function getRecord(int $id);

    /**
     * @param  \App\User  $user
     * @return \App\Record
     */
    public function getRecordsByUser(User $user);

    /**
     * @param  \App\User  $user
     * @param  int  $id
     * @return \App\Record
     */
    public function getRecordByUser(User $user, int $id);

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
    public function getPublicRecordByUser(User $user, int $id);

    /**
     * @param  \App\User  $user
     * @return \App\Record
     */
    public function storeRecord(User $user);

    /**
     * @param  \App\Record  $record
     * @return \App\Record
     */
    public function updateRecord(Record $record);

    /**
     * @param  \App\Record  $record
     * @return \App\Record
     */
    public function destroyRecord(Record $record);
}
