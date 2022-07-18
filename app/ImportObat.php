<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportObat extends Model
{
    protected $table = 'obat';
    protected $fillable = ['nama_obat','sediaan','dosis','satuan','stok','harga'];
}
