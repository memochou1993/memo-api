<?php

namespace App\Repositories;

use App\User;
use App\Type;
use App\Record;
use App\Contracts\RecordInterface;
use App\Http\Requests\RecordRequest as Request;

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
     * @param  \App\User  $user
     * @return \App\Record
     */
    public function getRecordsByUser(User $user)
    {
        return $user->records()
            ->with([
                'type',
                'tags',
            ])
            ->paginate();
    }

    /**
     * @param  \App\User  $user
     * @return \App\Record
     */
    public function getPublicRecordsByUser(User $user)
    {
        return $user->records()
            ->where([
                'private' => false,
            ])
            ->with([
                'type',
                'tags',
            ])
            ->paginate();
    }

    /**
     * @param  \App\User  $user
     * @param  int  $id
     * @return \App\Record
     */
    public function getRecordByUser(User $user, int $id)
    {
        return $user->records()
            ->with([
                'type',
                'tags',
            ])
            ->findOrFail($id);
    }

    /**
     * @param  \App\User  $user
     * @param  int  $id
     * @return \App\Record
     */
    public function getPublicRecordByUser(User $user, int $id)
    {
        return $user->records()
            ->where([
                'private' => false,
            ])
            ->with([
                'type',
                'tags',
            ])
            ->findOrFail($id);
    }

    /**
     * @param  \App\User  $user
     * @param  \App\Http\Requests\RecordRequest  $request
     * @return \App\Record
     */
    public function storeRecord(User $user, Request $request)
    {
        $record = new Record($request->all());

        $type = Type::find($request->type_id);

        $record->associate(compact(['user', 'type']));

        $record->save();

        return $record;
    }
}
