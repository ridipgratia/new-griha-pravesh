<?php

namespace App\Http\Controllers;

use App\Imports\BeneficaryDetailsDataImport;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UploadExcelController extends Controller
{
    public function index(Request $request)
    {
        $all_gps = DB::table('gp')
            ->where('block_id', Auth::user()->block_code)
            ->select(
                'id',
                'gp_id',
                'gp_name'
            )
            ->get();
        $block_name = DB::table('blocks')
            ->where('block_id', Auth::user()->block_code)
            ->select('block_name')
            ->get();
        $district_name = DB::table('districts')
            ->where('id', Auth::user()->district_code)
            ->select('name')
            ->get();
        return view('upload_excel', [
            'all_gps' => $all_gps,
            'block_name' => $block_name[0]->block_name,
            'district_name' => $district_name[0]->name
        ]);
    }
    public function uploadExcel(Request $request)
    {
        if ($request->ajax()) {
            $status = 400;
            $message = [];
            $file = $request->file('excel_file');
            $error_message = [
                'required' => ':attribute is required field',
                'mimes' => 'file type only xlsx',
                'max' => 'file size only 10mb',
                'integer' => ':attribute is number only '
            ];
            $validator = Validator::make(
                $request->all(),
                [
                    'excel_file' => 'required|max:10000|mimes:xlsx',
                    'gp_code' => 'required|integer'
                ],
                $error_message
            );
            if ($validator->fails()) {
                $message = $validator->errors()->all();
            } else {
                $user_data = [
                    'district_code' => Auth::user()->district_code,
                    'block_code' => Auth::user()->block_code,
                    'gp_code' => $request->gp_code
                ];
                DB::beginTransaction();
                try {
                    Excel::import(new BeneficaryDetailsDataImport($user_data), $file);
                    DB::commit();
                    $status = 200;
                    return response()->json(['status' => 200, 'message' => 'Successfully uploaded data']);
                } catch (Exception $err) {
                    DB::rollBack();
                    array_push($message, 'Server error please try again !');
                }
            }
            return response()->json(['status' => $status, 'message' => $message]);
        }
    }
}
