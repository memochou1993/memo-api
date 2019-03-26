<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Contracts\RecordInterface as Repository;
use App\Http\Resources\RecordResource as Resource;

class HomeController extends Controller
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
     * @return void
     */
    public function __construct(Request $request, Repository $reposotory)
    {
        $this->request = $request;

        $this->reposotory = $reposotory;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
        //return Resource::collection($this->reposotory->getRecordsByUser(Auth::user()));
    }
}
