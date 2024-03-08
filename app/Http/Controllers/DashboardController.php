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
                $total = DB::table('beneficary_details_excel_data')->count();
                $pending = DB::table('beneficary_details_excel_data')->where('status', '0')->count();
                $completed = DB::table('beneficary_details_excel_data')->where('status', '1')->count();
                $query = "SELECT districts.name,count(case when beneficary_details_excel_data.status = 1 then 1 end) as 'completed',count(case when beneficary_details_excel_data.status = 0 then 1 end) as 'pending' FROM `beneficary_details_excel_data` join districts on beneficary_details_excel_data.district_id = districts.id group by 1 order by completed DESC;";
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
