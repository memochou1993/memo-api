<?php

namespace App\Repositories;

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
     * @var string
     */
    protected $q;

    /**
     * @var array
     */
    protected $with;

    /**
     * @var int
     */
    protected $paginate;

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

        $this->q = $this->request->q;

        $this->with = $this->request->with
            ? explode(',', $this->request->with)
            : [];

        $this->paginate = $this->request->paginate;
    }

    /**
     * @return \App\Record
     */
    public function searchRecords()
    {
        return $this->record
            ->search($this->q)
            ->get();
    }

    /**
     * @return \App\Record
     */
    public function getRecords()
    {
        $q = $this->q;

        return $this->record
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%")
                    ->orWhereHas('tags', function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    });
            })
            ->with($this->with)
            ->orderBy('date', 'desc')
            ->paginate($this->paginate);
    }

    /**
     * @param  int  $id
     * @return \App\Record
     */
    public function getRecord(int $id)
    {
        return $this->record
            ->with($this->with)
            ->findOrFail($id);
    }

    /**
     * @param  \App\User  $user
     * @return \App\Record
     */
    public function searchRecordsByUser(User $user)
    {
        return $this->record
            ->search($this->q)
            ->where('user_id', $user->id)
            ->get();
    }

    /**
     * @param  \App\User  $user
     * @return \App\Record
     */
    public function getRecordsByUser(User $user)
    {
        $q = $this->q;

        return $user->records()
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%")
                    ->orWhereHas('tags', function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    });
            })
            ->with($this->with)
            ->orderBy('date', 'desc')
            ->paginate($this->paginate);
    }

    /**
     * @param  \App\User  $user
     * @param  int  $id
     * @return \App\Record
     */
    public function getRecordByUser(User $user, int $id)
    {
        return $user->records()
            ->with($this->with)
            ->findOrFail($id);
    }

    /**
     * @param  \App\User  $user
     * @return \App\Record
     */
    public function searchPublicRecordsByUser(User $user)
    {
        return $this->record
            ->search($this->q)
            ->where('private', 0)
            ->where('user_id', $user->id)
            ->get();
    }

    /**
     * @param  \App\User  $user
     * @return \App\Record
     */
    public function getPublicRecordsByUser(User $user)
    {
        $q = $this->q;

        return $user->records()
            ->where('private', false)
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%")
                    ->orWhereHas('tags', function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%");
                    });
            })
            ->with($this->with)
            ->orderBy('date', 'desc')
            ->paginate($this->paginate);
    }

    /**
     * @param  \App\User  $user
     * @param  int  $id
     * @return \App\Record
     */
    public function getPublicRecordByUser(User $user, int $id)
    {
        return $user->records()
            ->where('private', false)
            ->with($this->with)
            ->findOrFail($id);
    }

    /**
     * @param  \App\User  $user
     * @return \App\Record
     */
    public function storeRecord(User $user)
    {
        $record = new Record($this->request->all());
        $record->associate(compact(['user']));
        $record->save();

        $record->tags()->sync($this->request->tag_ids);

        return $this->getRecord($record->id);
    }

    /**
     * @param  \App\Record  $record
     * @return \App\Record
     */
    public function updateRecord(Record $record)
    {
        $record->update($this->request->all());

        $record->tags()->sync($this->request->tag_ids);

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
