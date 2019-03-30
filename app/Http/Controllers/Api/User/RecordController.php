<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use App\Record;
use Laravel\Passport\Passport;
use App\Http\Controllers\Controller;
use App\Http\Requests\RecordRequest as Request;
use App\Contracts\RecordInterface as Repository;
use App\Http\Resources\RecordResource as Resource;

class RecordController extends Controller
{
    /**
     * @var \App\User
     */
    protected $user;

    /**
     * @var \App\Http\Requests\RecordRequest
     */
    protected $request;

    /**
     * @var \App\Contracts\RecordInterface
     */
    protected $reposotory;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Http\Requests\RecordRequest  $request
     * @param  \App\Contracts\RecordInterface  $reposotory
     * @return void
     */
    public function __construct(Request $request, Repository $reposotory)
    {
        $this->user = config('api.debug.enabled')
            ? Passport::actingAs(User::find(config('api.debug.user.id')))
            : $this->auth('api')->user(); 

        $this->request = $request;

        $this->reposotory = $reposotory;
    }

    /**
     * @return \App\Http\Resources\RecordResource
     */
    public function search()
    {
        $records = $this->reposotory->searchRecordsByUser($this->user);

        return Resource::collection($records);
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
        $record = $this->reposotory->storeRecord($this->user);

        return new Resource($record);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Record  $record
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
     */
    public function update(Record $record)
    {
        $this->authorize('update', $record);

        $record = $this->reposotory->updateRecord($record);

        return new Resource($record);
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

        $record = $this->reposotory->destroyRecord($record);

        return response(null, 204);
    }
}
