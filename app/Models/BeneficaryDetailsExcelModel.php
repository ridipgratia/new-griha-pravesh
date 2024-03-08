<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficaryDetailsExcelModel extends Model
{
    use HasFactory;
    protected $table = 'beneficary_details_excel_data';
    protected $fillable = [
        'district_id',
        'block_id',
        'gp_id',
        'village_id',
        'reg_no',
        'name',
        'lat',
        'lon',
        'status',
    ];
}
