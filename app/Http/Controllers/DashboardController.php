<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function index(Request $resquest)
    {
        $level = auth()->user()->level;
        switch ($level) {
            case '0':
                return view('blockdashboard');
            case '1':
                return view('districtdashboard');
            case '2':
                $total = DB::table('beneficary_mapping')->count();
                $pending = DB::table('beneficary_mapping')->where('status', '0')->count();
                $completed = DB::table('beneficary_mapping')->where('status', '1')->count();
                $query = "SELECT districts.name,count(case when beneficary_mapping.status = 1 then 1 end) as 'completed',count(case when beneficary_mapping.status = 0 then 1 end) as 'pending' FROM `beneficary_mapping` join districts on beneficary_mapping.district_id = districts.id group by 1 order by completed DESC;";
                $district = DB::select($query);
                return view('statedashboard', compact('total', 'pending', 'completed', 'district'));
            default:
                return view('dashboard');
        }
    }
    function prepearstatedashboard()
    {
    }

    function prepeardistrictdashboard()
    {
        //dd(auth()->user());
        return view('statedashboard');
    }
}
