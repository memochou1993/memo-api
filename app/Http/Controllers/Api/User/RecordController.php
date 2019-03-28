<?php

namespace App\Http\Controllers\Api\User;

use App\Record;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\RecordInterface as Repository;
use App\Http\Resources\RecordResource as Resource;

class RecordController extends Controller
{
    /**
     * @var \App\User
     */
    protected $user;

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
        $this->user = $this->auth('api')->user();

        $this->request = $request;

        $this->reposotory = $reposotory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\RecordResource
     */
    public function index()
    {
        $records = $this->reposotory->getRecordsByUser($this->user);

        return Resource::collection($records);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \App\Http\Resources\RecordResource
     */
    public function store()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\RecordResource
     */
    public function show(Record $record)
    {
        $records = $this->reposotory->getRecordByUser($this->user, $record->id);

        return new Resource($records);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Record  $record
     * @return \App\Http\Resources\RecordResource
     */
    public function update(Record $record)
    {
        $this->authorize('update', $record);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        $this->authorize('delete', $record);
    }
}
