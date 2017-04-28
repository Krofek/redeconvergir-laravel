<?php

namespace App\Http\Controllers;

use App\Models\Initiative;
use App\Models\Location;
use Illuminate\Http\Request;

use App\Http\Requests;
use JavaScript;
use Mapper;

class IndexController extends Controller
{
    public function index(Request $request){
        
        return view('index');
    }
}
