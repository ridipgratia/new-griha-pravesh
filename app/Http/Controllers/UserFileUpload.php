<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserFileUpload extends Controller
{
    public function ShowFileUpload($user_id)
    {
        return view('user_file_upload', ["user_id" => $user_id, 'location' => 'public/images/26/bBVWg4VUnlZH3bVZ4zyjXYJHGCDzsgojyw7TuBew.jpg']);
    }


    public function FileUpload(Request $request, $user_id)
    {
        $file1 = $request->file('file_1');
        $file2 = $request->file('file_2');
        if ($request->hasFile('file_1') && $request->hasFile('file_2')) {
            $temp_1 = $file1->store('public/images/' . $user_id);
            $temp_2 = $file2->store('public/images/' . $user_id);
            DB::table('user_images')->insert([
                'reg_rec_id' => $user_id,
                'image_location_1' => $temp_1,
                'image_location_2' => $temp_2,
            ]);
            DB::table('beneficary_details_excel_data')->where('id', $user_id)->update(['status' => '1']);
            return response()->json(['status' => 200, 'message' => 'Files Are Uploaded', "user_id" => $user_id]);
        } else {
            return response()->json(['status' => 400, 'message' => 'Select All Files', "user_id" => $user_id]);
        }
    }
}
