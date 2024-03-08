<?php

namespace App\Imports;

use App\Models\BeneficaryDetailsExcelModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BeneficaryDetailsDataImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public $user_data;
    public function __construct($user_data)
    {
        $this->user_data = $user_data;
    }
    public function collection(Collection $collection)
    {
        $data = [];
        foreach ($collection as $coll) {
            if (isset($coll['pmay_id']) && isset($coll['beneficiary_name'])) {
                $excel_data = BeneficaryDetailsExcelModel::create([
                    'district_id' => $this->user_data['district_code'],
                    'block_id' => $this->user_data['block_code'],
                    'gp_id' => $this->user_data['gp_code'],
                    'reg_no' => $coll['pmay_id'],
                    'name' => $coll['beneficiary_name']
                ]);
            }
        }
    }
}
