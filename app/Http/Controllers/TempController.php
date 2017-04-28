<?php

namespace App\Http\Controllers;

use App\Models\Initiative;
use Illuminate\Http\Request;

use App\Http\Requests;

class TempController extends Controller
{
    public function index()
    {
        $i = Initiative::with('audience')->get();

        $audience = collect();
        $i->each(function(Initiative $i) use (&$audience){
           $audience->push($i->audience);
        });

        return view('auth.login', compact('audience', 'i'));
    }
}
