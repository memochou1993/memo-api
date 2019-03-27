<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Contracts\RecordInterface as Repository;
use App\Http\Resources\RecordResource as Resource;

class RecordController extends Controller
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \App\Contracts\ProjectInterface
     */
    protected $reposotory;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contracts\ProjectInterface  $reposotory
     * @return void
     */
    public function __construct(Request $request, Repository $reposotory)
    {
        $this->request = $request;

        $this->reposotory = $reposotory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Resource::collection($this->reposotory->getRecordsByUser(Auth::user()));
    }
}
