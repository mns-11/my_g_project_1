<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectionDashboardController extends Controller
{
    public function __invoke()
    {
        if(auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }elseif(auth()->user()->hasRole('teacher')){
            return redirect()->route('teacher.lectures.index');
        }elseif(auth()->user()->hasRole('coordinator')){
            return redirect()->route('attendances.excuses');
        }elseif(auth()->user()->hasRole('chief')){
            return redirect()->route('attendances.transferred');
        }
        else{
            abort(404);
        }
    }
}
