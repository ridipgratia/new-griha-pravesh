<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserDataController extends Controller
{

    public function findUserdataOne(Request $request)
    {
        $beneficiary = DB::table('beneficary_details_excel_data')
            ->join('vill_name', 'beneficary_details_excel_data.village_id', '=', 'vill_name.id')
            ->join('gp_name', 'beneficary_details_excel_data.gp_id', '=', 'gp_name.id')
            ->join('block_name', 'beneficary_details_excel_data.block_id', '=', 'block_name.id')
            ->join('districts', 'beneficary_details_excel_data.district_id', '=', 'districts.id')
            ->where('beneficary_details_excel_data.id', $request->id)
            ->select('beneficary_details_excel_data.id as record_id', 'beneficary_details_excel_data.name as b_name', 'beneficary_details_excel_data.reg_no as b_id', 'beneficary_details_excel_data.lat as lat', 'beneficary_details_excel_data.lon as lon', 'gp_name.name as gp_name', 'districts.name as district_name', 'block_name.name as block_name', 'vill_name.name as village')
            ->first();
        return json_encode($beneficiary);
    }

    public function findUserdataOneview(Request $request)
    {
        $beneficiary = DB::table('beneficary_details_excel_data')
            ->join('vill_name', 'beneficary_details_excel_data.village_id', '=', 'vill_name.id')
            ->join('gp_name', 'beneficary_details_excel_data.gp_id', '=', 'gp_name.id')
            ->join('block_name', 'beneficary_details_excel_data.block_id', '=', 'block_name.id')
            ->join('districts', 'beneficary_details_excel_data.district_id', '=', 'districts.id')
            ->join('user_images', 'beneficary_details_excel_data.id', '=', 'user_images.reg_rec_id')
            ->where('beneficary_details_excel_data.id', $request->id)
            ->select('user_images.image_location_2 as photo2', 'user_images.image_location_1 as photo1', 'beneficary_details_excel_data.id as record_id', 'beneficary_details_excel_data.name as b_name', 'beneficary_details_excel_data.reg_no as b_id', 'beneficary_details_excel_data.lat as lat', 'beneficary_details_excel_data.lon as lon', 'gp_name.name as gp_name', 'districts.name as district_name', 'block_name.name as block_name', 'vill_name.name as village')
            ->first();
        $data = [];
        $x = $beneficiary->photo1;
        $y = $beneficiary->photo2;
        $a = Storage::url($x);
        $b = Storage::url($y);
        $beneficiary->p1 = $a;
        $beneficiary->p2 = $b;
        return json_encode($beneficiary);
    }



    public function showUserData(Request $request)
    {
        $page_id = $request->page;
        $ses_gp_code = $request->session()->get('gp_code');
        $gp_code = $ses_gp_code;
        $x = Auth::user();
        $district_code = $x->district_code;
        $district = DB::table('districts')->where('id', $district_code)->first();

        $district_name = $district->name;
        $block_code = $x->block_code;

        // dd($block_code);

        $block = DB::table('blocks')
            ->where('block_id', $block_code)
            ->first();

        // dd($block);
        $gps = DB::table('gp')
            ->where('block_id', $block_code)
            ->where('district_id', $district_code)
            ->get();

        if (!isset($ses_gp_code)) {
            $ses_gp_code = $gps[0]->gp_id;
        }
        $select_gp_name = '';

        $query = DB::table('beneficary_details_excel_data')
            ->join('gp_name', 'beneficary_details_excel_data.gp_id', '=', 'gp_name.id')
            ->join('block_name', 'beneficary_details_excel_data.block_id', '=', 'block_name.id')
            ->join('districts', 'beneficary_details_excel_data.district_id', '=', 'districts.id')
            ->where('beneficary_details_excel_data.block_id', $block_code);
        if (isset($request->GP_name)) {
            $query->where('beneficary_details_excel_data.gp_id', $request->GP_name);
        }
        $beneficiaries = $query->where('beneficary_details_excel_data.status', '0')
            ->select('beneficary_details_excel_data.id as record_id', 'beneficary_details_excel_data.name as b_name', 'beneficary_details_excel_data.reg_no as b_id', 'beneficary_details_excel_data.lat as lat', 'beneficary_details_excel_data.lon as lon', 'gp_name.name as gp_name', 'districts.name as district_name', 'block_name.name as block_name')
            // ->simplePaginate(15);
            ->get();

        // dd($beneficiaries);

        return view('user_data', compact('district', 'block', 'gps', 'beneficiaries', 'gp_code', 'page_id'));
    }


    public function filterUserdata(Request $request)
    {
        if ($request->has('pmay_btn')) {
            $pmay_id = $request->pmay_id;
            if (empty($pmay_id)) {
                $request->session()->forget('gp_name');
                $bajali_district = DB::table('bajali_completed')->select('GP')->distinct()->get();
                return view('user_data', ['error' => 'Enter PMAY ID', 'bajali_district' => $bajali_district]);
            }
        } else {
            $page_id = $request->page;
            $gp_code = $request->GP_name; // requested by user
            // $request->session()->put('gp_code', $gp_code);
            $x = Auth::user();
            $district_code = $x->district_code;
            $district = DB::table('districts')->where('id', $district_code)->first();

            $district_name = $district->name;
            $block_code = $x->block_code;

            // dd($block_code);

            $block = DB::table('blocks')
                ->where('block_id', $block_code)
                ->first();

            // dd($block);
            $gps = DB::table('gp')
                ->where('block_id', $block_code)
                ->where('district_id', $district_code)
                ->get();

            $query = DB::table('beneficary_details_excel_data')
                ->join('gp_name', 'beneficary_details_excel_data.gp_id', '=', 'gp_name.id')
                ->join('block_name', 'beneficary_details_excel_data.block_id', '=', 'block_name.id')
                ->join('districts', 'beneficary_details_excel_data.district_id', '=', 'districts.id')
                ->where('beneficary_details_excel_data.block_id', $block_code);
            if (isset($request->GP_name)) {
                $query->where('beneficary_details_excel_data.gp_id', $request->GP_name);
            }
            $beneficiaries = $query->where('beneficary_details_excel_data.status', '0')
                ->select('beneficary_details_excel_data.id as record_id', 'beneficary_details_excel_data.name as b_name', 'beneficary_details_excel_data.reg_no as b_id', 'beneficary_details_excel_data.lat as lat', 'beneficary_details_excel_data.lon as lon', 'gp_name.name as gp_name', 'districts.name as district_name', 'block_name.name as block_name')
                // ->simplePaginate(15);
                ->get();

            // dd($beneficiaries);

            return view('user_data', compact('district', 'block', 'gps', 'beneficiaries', 'gp_code', 'page_id'));
        }
    }

    public function viewdata(Request $request)
    {
        $page_id = $request->page;

        $x = Auth::user();
        $district_code = $x->district_code;
        $district = DB::table('districts')->where('id', $district_code)->first();
        $gp_code = $request->GP_name; // requested by user

        $district_name = $district->name;
        $block_code = $x->block_code;

        // dd($block_code);

        $block = DB::table('blocks')
            ->where('block_id', $block_code)
            ->first();

        // dd($block);
        $gps = DB::table('gp')
            ->where('block_id', $block_code)
            ->where('district_id', $district_code)
            ->get();

        if (!isset($ses_gp_code)) {
            $ses_gp_code = $gps[0]->gp_id;
        }
        $query = DB::table('beneficary_details_excel_data')
            ->join('gp_name', 'beneficary_details_excel_data.gp_id', '=', 'gp_name.id')
            ->join('block_name', 'beneficary_details_excel_data.block_id', '=', 'block_name.id')
            ->join('districts', 'beneficary_details_excel_data.district_id', '=', 'districts.id')
            ->where('beneficary_details_excel_data.block_id', $block_code);
        if (isset($request->GP_name)) {
            $query->where('beneficary_details_excel_data.gp_id', $request->GP_name);
        }
        $beneficiaries = $query->where('beneficary_details_excel_data.status', '1')
            ->select('beneficary_details_excel_data.id as record_id', 'beneficary_details_excel_data.name as b_name', 'beneficary_details_excel_data.reg_no as b_id', 'beneficary_details_excel_data.lat as lat', 'beneficary_details_excel_data.lon as lon', 'gp_name.name as gp_name', 'districts.name as district_name', 'block_name.name as block_name')
            // ->simplePaginate(15);
            ->get();
        return view('view_data', compact('district', 'block', 'gps', 'beneficiaries', 'gp_code', 'page_id'));
    }

    public function viewfilterUserdata(Request $request)
    {
        if ($request->has('pmay_btn')) {
            $pmay_id = $request->pmay_id;
            if (empty($pmay_id)) {
                $request->session()->forget('gp_name');
                $bajali_district = DB::table('bajali_completed')->select('GP')->distinct()->get();
                return view('user_data', ['error' => 'Enter PMAY ID', 'bajali_district' => $bajali_district]);
            }
        } else {
            $page_id = $request->page;
            $gp_code = $request->GP_name; // requested by user

            $x = Auth::user();
            $district_code = $x->district_code;
            $district = DB::table('districts')->where('id', $district_code)->first();

            $district_name = $district->name;
            $block_code = $x->block_code;

            // dd($block_code);

            $block = DB::table('blocks')
                ->where('block_id', $block_code)
                ->first();

            // dd($block);
            $gps = DB::table('gp')
                ->where('block_id', $block_code)
                ->where('district_id', $district_code)
                ->get();

            $query = DB::table('beneficary_details_excel_data')
                ->join('gp_name', 'beneficary_details_excel_data.gp_id', '=', 'gp_name.id')
                ->join('block_name', 'beneficary_details_excel_data.block_id', '=', 'block_name.id')
                ->join('districts', 'beneficary_details_excel_data.district_id', '=', 'districts.id')
                ->where('beneficary_details_excel_data.block_id', $block_code);
            if (isset($request->GP_name)) {
                $query->where('beneficary_details_excel_data.gp_id', $request->GP_name);
            }
            $beneficiaries = $query->where('beneficary_details_excel_data.status', '1')
                ->select('beneficary_details_excel_data.id as record_id', 'beneficary_details_excel_data.name as b_name', 'beneficary_details_excel_data.reg_no as b_id', 'beneficary_details_excel_data.lat as lat', 'beneficary_details_excel_data.lon as lon', 'gp_name.name as gp_name', 'districts.name as district_name', 'block_name.name as block_name')
                // ->simplePaginate(15);
                ->get();

            // dd($beneficiaries);

            return view('view_data', compact('district', 'block', 'gps', 'beneficiaries', 'gp_code', 'page_id'));
        }
    }


    public function showUserDatadistrict(Request $request)
    {
        $x = Auth::user();
        $district_code = $x->district_code;
        $district = DB::table('districts')->where('id', $district_code)->first();

        $district_name = $district->name;

        $blocks = DB::table('blocks')
            ->where('district_id', $district_code)
            ->get();

        // dd($blocks);



        $beneficiaries = DB::table('beneficary_mapping')
            ->join('vill_name', 'beneficary_mapping.village_id', '=', 'vill_name.id')
            ->join('gp_name', 'beneficary_mapping.gp_id', '=', 'gp_name.id')
            ->join('block_name', 'beneficary_mapping.block_id', '=', 'block_name.id')
            ->join('districts', 'beneficary_mapping.district_id', '=', 'districts.id')
            ->where('beneficary_mapping.district_id', $district_code)
            ->where('beneficary_mapping.status', '1')
            ->select('beneficary_mapping.id as record_id', 'beneficary_mapping.name as b_name', 'beneficary_mapping.reg_no as b_id', 'beneficary_mapping.lat as lat', 'beneficary_mapping.lon as lon', 'gp_name.name as gp_name', 'districts.name as district_name', 'block_name.name as block_name', 'vill_name.name as village')
            ->get();

        // dd($beneficiaries);

        return view('view_user_data_for_district', compact('district_name', 'blocks', 'beneficiaries'));
    }

    function viewfilterUserdatabyBlock(Request $request)
    {
        $block_code = $request->block_code;
        $x = Auth::user();
        $district_code = $x->district_code;
        $district = DB::table('districts')->where('id', $district_code)->first();

        $district_name = $district->name;

        $blocks = DB::table('blocks')
            ->where('district_id', $district_code)
            ->get();

        // dd($blocks);

        $beneficiaries = DB::table('beneficary_mapping')
            ->join('vill_name', 'beneficary_mapping.village_id', '=', 'vill_name.id')
            ->join('gp_name', 'beneficary_mapping.gp_id', '=', 'gp_name.id')
            ->join('block_name', 'beneficary_mapping.block_id', '=', 'block_name.id')
            ->join('districts', 'beneficary_mapping.district_id', '=', 'districts.id')
            ->join('user_images', 'beneficary_mapping.id', '=', 'user_images.reg_rec_id')
            ->where('beneficary_mapping.block_id', $block_code)
            ->where('beneficary_mapping.status', '1')
            ->select('user_images.image_location_2 as photo2', 'user_images.image_location_1 as photo1', 'beneficary_mapping.id as record_id', 'beneficary_mapping.name as b_name', 'beneficary_mapping.reg_no as b_id', 'beneficary_mapping.lat as lat', 'beneficary_mapping.lon as lon', 'gp_name.name as gp_name', 'districts.name as district_name', 'block_name.name as block_name', 'vill_name.name as village')
            ->get();

        // dd($beneficiaries);

        return view('view_user_data_for_district', compact('district_name', 'blocks', 'beneficiaries', 'block_code'));
    }
}
