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
     * @return \Illuminate\Support\Facades\Auth
     */
    public function auth($guard)
    {
        return Auth::guard($guard);
    }

    /**
     * @return bool
     */
    public function check($guard, $user)
    {
        $auth = $this->auth($guard);

        if (! $auth->check()) {
            return false;
        }

        return $user->id === $auth->user()->id;
    }
}
