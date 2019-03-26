<?php

namespace App\Repositories;

use App\User;
use App\Record;
use App\Contracts\RecordInterface;

class RecordRepository implements RecordInterface
{
    /**
     * @var \App\Record
     */
    protected $record;

    /**
     * Create a new repository instance.
     *
     * @param  \App\Record  $record
     * @return void
     */
    public function __construct(Record $record)
    {
        $this->record = $record;
    }

    /**
     * @return \App\Record
     */
    public function getRecordsByUser(User $user)
    {
        return $user->records()->paginate();
    }
}
