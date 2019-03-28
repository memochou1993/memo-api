<?php

namespace App\Repositories;

use App\Type;
use App\User;
use App\Record;
use App\Contracts\RecordInterface;
use App\Http\Requests\RecordRequest as Request;

class RecordRepository implements RecordInterface
{
    /**
     * @var \App\Http\Requests\RecordRequest
     */
    protected $request;

    /**
     * @var \App\Record
     */
    protected $record;

    /**
     * @var array
     */
    protected $relationships;

    /**
     * Create a new repository instance.
     *
     * @param  \App\Http\Requests\RecordRequest  $request
     * @param  \App\Record  $record
     * @return void
     */
    public function __construct(Request $request, Record $record)
    {
        $this->request = $request;

        $this->record = $record;

        $this->relationships = ['type', 'tags'];
    }

    /**
     * @return \App\Record
     */
    public function getRecords()
    {
        return $this->record
            ->with($this->relationships)
            ->get();
    }

    /**
     * @param  int  $id
     * @return \App\Record
     */
    public function getRecord(int $id)
    {
        return $this->record
            ->with($this->relationships)
            ->findOrFail($id);
    }

    /**
     * @param  \App\User  $user
     * @return \App\Record
     */
    public function getRecordsByUser(User $user)
    {
        return $user->records()
            ->with($this->relationships)
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
            ->with($this->relationships)
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
            ->with($this->relationships)
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
            ->with($this->relationships)
            ->findOrFail($id);
    }

    /**
     * @param  \App\User  $user
     * @return \App\Record
     */
    public function storeRecord(User $user)
    {
        $type = Type::find($this->request->type_id);

        $record = new Record($this->request->all());
        $record->associate(compact(['user', 'type']));
        $record->save();

        $record->tags()->sync(explode(',', $this->request->tags));

        return $this->getRecord($record->id);
    }

    /**
     * @param  \App\Record  $record
     * @return \App\Record
     */
    public function updateRecord(Record $record)
    {
        $record->update($this->request->all());

        $record->tags()->sync(explode(',', $this->request->tags));

        return $this->getRecord($record->id);
    }

    /**
     * @param  \App\Record  $record
     * @return void
     */
    public function destroyRecord(Record $record)
    {
        $record->delete();
    }
}
