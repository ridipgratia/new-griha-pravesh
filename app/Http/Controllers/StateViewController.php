<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StateViewController extends Controller
{

     // show all data page according to district or block or GP (DK)
     public function showAllData(){

        $dist = DB::table('districts')->get();
        // dd($dist);

        $dist_code = DB::table('districts')->select('id')->get();

        return view('dist_show_data',compact('dist'));
    }
}
