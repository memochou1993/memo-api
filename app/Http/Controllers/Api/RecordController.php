<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\RecordInterface as Repository;
use App\Http\Resources\RecordResource as Resource;

class RecordController extends Controller
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \App\Contracts\RecordInterface
     */
    protected $reposotory;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contracts\RecordInterface  $reposotory
     * @return void
     */
    public function __construct(Request $request, Repository $reposotory)
    {
        $this->request = $request;

        $this->reposotory = $reposotory;
    }

    /**
     * @return \App\Http\Resources\RecordResource
     */
    public function search(User $user)
    {
        $records = $this->reposotory->searchPublicRecordsByUser($user);

        return Resource::collection($records);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\User  $user
     * @return \App\Http\Resources\RecordResource
     */
    public function index(User $user)
    {
        $records = $this->reposotory->getPublicRecordsByUser($user);

        return Resource::collection($records);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\User  $user
     * @return \App\Http\Resources\RecordResource
     */
    public function show(User $user, Record $record)
    {
        $records = $this->reposotory->getPublicRecordByUser($user, $record->id);

        return new Resource($records);
    }
}
