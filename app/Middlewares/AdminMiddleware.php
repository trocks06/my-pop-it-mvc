<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AdminMiddleware
{
    public function handle(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id != 1) {
            app()->route->redirect('/subscribers');
        }
    }
}