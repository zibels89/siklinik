<?php

namespace App\Imports;

use App\ImportObat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ObatImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ImportObat([
            'nama_obat' => $row['nama_obat'],
            'sediaan' => $row['sediaan'],
            'dosis' => $row['dosis'],
            'satuan' => $row['satuan'],
            'stok' => $row['stok'],
            'harga' => $row['harga'],
            'created_time' => date('Y-m-d H:i:s'),
            'updated_time' => date('Y-m-d H:i:s'),
            'deleted' => 0,
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
