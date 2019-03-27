<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @return \App\User
     */
    public function user($guard)
    {
        return Auth::guard($guard)->user();
    }

    /**
     * @return bool
     */
    public function check($guard, $user)
    {
        $auth = Auth::guard($guard);

        if (! $auth->check()) {
            return false;
        }

        return $user->id === $auth->user()->id;
    }
}
