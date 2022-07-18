<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Imports\ObatImport;
use Maatwebsite\Excel\Facades\Excel;

class ObatController extends Controller
{
    public function index () 
    {    
        $metadatas = ambil_satudata('metadata',4);
        $obats =DB::table('obat')->where('deleted',0)->get();
        return view('obat',['obats'=> $obats],['metadatas'=>$metadatas]);   
    }
    
        public function tambah_obat () 
    {    
        $metadatas = ambil_satudata('metadata',5);
        return view('tambah-obat',['metadatas'=>$metadatas]); 
    }
    
       public function simpan_obat(Request $request)
    { 
        $this->validate($request, [
            'n_obat' => 'required|min:4|max:25',
            'sediaan' => 'required',
            'dosis' => 'required|numeric|digits_between:1,7',
            'satuan' => 'required',
            'harga' => 'required|numeric|digits_between:1,7',
            'stok' => 'required|numeric|digits_between:1,5'
        ]);
        DB::table('obat')->insert([
            'nama_obat' => $request->n_obat,
            'sediaan' => $request->sediaan,
            'dosis' => $request->dosis,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'created_time' => Carbon::now(),
            'updated_time' => Carbon::now(),
        ]);
           $ids= DB::table('obat')->orderby('id','desc')->first();         
            switch($request->simpan) {
                case 'simpan': 
                    $buka=route('obat.edit',$ids->id);
                    $pesan='Data obat berhasil disimpan!';
                break;             
                case 'simpan_baru': 
                    $buka=route('obat.tambah');
                    $pesan='Data obat berhasil disimpan!';
                break;
            }
        return redirect($buka)->with('pesan',$pesan);
    }
     //Proses Update Pasien
        public function update_obat(Request $request)
    {
            $this->validate($request, [
                'n_obat' => 'required|min:4|max:25',
                'sediaan' => 'required',
                'dosis' => 'required|numeric|digits_between:1,7',
                'satuan' => 'required',
                'harga' => 'required|numeric|digits_between:1,7',
                'stok' => 'required|numeric|digits_between:1,5'
            ]);
            
            DB::table('obat')->where('id',$request->id)->update([
                'nama_obat' => $request->n_obat,
                'sediaan' => $request->sediaan,
                'dosis' => $request->dosis,
                'satuan' => $request->satuan,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'updated_time' => Carbon::now()
            ]);
     
            switch($request->simpan) {
                 case 'simpan': 
                    $buka='/obat/edit/' . $request->id;
                    $pesan='Data pasien berhasil disimpan!';
                break;           
                case 'simpan_baru': 
                    $buka='/obat/tambah';
                    $pesan='Data pasien berhasil disimpan!';
                break;
            }
        return redirect($buka)->with('pesan',$pesan);
    }
    
    public function edit_obat($id)
    {
        $metadatas = ambil_satudata('metadata',6);
        $datas= ambil_satudata('obat',$id);
        if ($datas->count() <= 0) {
            return abort(404, 'Halaman Tidak Ditemukan.');
        }
        return view('edit-obat',['metadatas'=>$metadatas],['datas'=>$datas]);
    }
    
    public function hapus_obat($id)
    {
        DB::table('obat')->where('id',$id)->update([
            'deleted' => 1,
        ]);
        $pesan="Data obat berhasil dihapus!";
        return redirect(route("obat"))->with('pesan',$pesan);
    }

    public function tambah_obat_stock(){
        $data['metadatas'] = ambil_satudata('metadata',4);
        $data['obat'] = DB::table('obat')->where('deleted',0)->orderBy('id','ASC')->get();

        return view('tambah_stock-obat')->with($data);
    }

    public function tambah_stock_update(Request $request){
        $total_stok = $request->total_stok;
        $count_items = count($request->ids);    

        for($i = 0; $i<$count_items; $i++)
        {
            $update = DB::table('obat')->where([
                ['id','=',[$i + 1]]
            ])->update([
                'stok' => $total_stok[$i]
            ]);
        }

        return redirect()->route('obat');
    }

    public function import_excel(Request $request){
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand().$file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_siswa',$nama_file);

        // import data
        Excel::import(new ObatImport, public_path('/file_siswa/'.$nama_file));

        // notifikasi dengan session
        $pesan='Data obat berhasil Diupload!';

        // alihkan halaman kembali
        return redirect()->back()->with('pesan',$pesan);
    }
}
