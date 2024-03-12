<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StateViewController extends Controller
{

    public function getBlocks(Request $request)
    {
        try {
            $blocks = DB::table('blocks')
                ->where('district_id', $_GET['district_id'])
                ->select(
                    'block_id',
                    'block_name'
                )
                ->get();
            return response()->json(['status' => 200, 'blocks' => $blocks]);
        } catch (Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Server error please try again !']);
        }
    }
    public function getGps(Request $request)
    {
        try {
            $gps = DB::table('gp')
                ->where('district_id', $_GET['district_id'])
                ->where('block_id', $_GET['block_id'])
                ->select(
                    'gp_id',
                    'gp_name'
                )
                ->get();
            return response()->json(['status' => 200, 'gps' => $gps]);
        } catch (Exception $err) {
            return response()->json(['status' => 400, 'message' => 'Server error please try again !']);
        }
    }

    public function viewAllUploadData(Request $request)
    {
        if ($request->ajax()) {
            $status = 400;
            $message = '';
            if (Auth::user()->level == 2) {
                try {
                    $query = DB::table('beneficary_details_excel_data')
                        ->join('gp_name', 'beneficary_details_excel_data.gp_id', '=', 'gp_name.id')
                        ->join('block_name', 'beneficary_details_excel_data.block_id', '=', 'block_name.id')
                        ->join('districts', 'beneficary_details_excel_data.district_id', '=', 'districts.id');
                    if ($_GET['district_id']) {
                        $query->where('beneficary_details_excel_data.district_id', $request->district_id);
                    }
                    if ($_GET['block_id']) {
                        $query->where('beneficary_details_excel_data.block_id', $request->block_id);
                    }
                    if ($_GET['gp_id']) {
                        $query->where('beneficary_details_excel_data.gp_id', $request->gp_id);
                    }
                    $beneficary = $query->where('beneficary_details_excel_data.status', '1')
                        ->select('beneficary_details_excel_data.id as record_id', 'beneficary_details_excel_data.name as b_name', 'beneficary_details_excel_data.reg_no as b_id', 'beneficary_details_excel_data.lat as lat', 'beneficary_details_excel_data.lon as lon', 'gp_name.name as gp_name', 'districts.name as district_name', 'block_name.name as block_name')
                        ->get();
                    return response()->json(['status' => 200, 'all_details' => $beneficary]);
                } catch (Exception $err) {
                    $message = "Server error please try again !";
                }
            } else {
                $message = "You are not authorized !";
            }
            return response()->json(['status' => $status, 'message' => $message]);
        }
    }

    public function viewOneUploadedData(Request $request)
    {
        if ($request->ajax()) {
            $status = 400;
            $message = '';
            if (Auth::user()->level == 2) {
                try {
                    $beneficiary = DB::table('beneficary_details_excel_data')

                        ->join('gp_name', 'beneficary_details_excel_data.gp_id', '=', 'gp_name.id')
                        ->join('block_name', 'beneficary_details_excel_data.block_id', '=', 'block_name.id')
                        ->join('districts', 'beneficary_details_excel_data.district_id', '=', 'districts.id')
                        ->join('user_images', 'beneficary_details_excel_data.id', '=', 'user_images.reg_rec_id')
                        ->where('beneficary_details_excel_data.id', $request->id)
                        ->select('user_images.image_location_2 as photo2', 'user_images.image_location_1 as photo1', 'beneficary_details_excel_data.id as record_id', 'beneficary_details_excel_data.name as b_name', 'beneficary_details_excel_data.reg_no as b_id', 'beneficary_details_excel_data.lat as lat', 'beneficary_details_excel_data.lon as lon', 'gp_name.name as gp_name', 'districts.name as district_name', 'block_name.name as block_name',)
                        ->first();
                    $data = [];
                    $x = $beneficiary->photo1;
                    $y = $beneficiary->photo2;
                    $a = Storage::url($x);
                    $b = Storage::url($y);
                    $beneficiary->p1 = $a;
                    $beneficiary->p2 = $b;
                    return response()->json(['status' => 400, 'one_details' => $beneficiary]);
                } catch (Exception $err) {
                    $message = "Server error please try again !";
                }
            } else {
                $message = "You are not authrozied !";
            }
            return response()->json(['status' => $status, 'message' => $message]);
        }
    }
    // show all data page according to district or block or GP (DK)
    public function showAllData()
    {

        $dist = DB::table('districts')->get();
        // dd($dist);

        $dist_code = DB::table('districts')->select('id')->get();
        $block_code = DB::table('blocks')->select('id')->get();

        return view('dist_show_data', compact('dist'));
    }
}
