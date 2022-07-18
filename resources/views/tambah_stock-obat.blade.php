@extends('master')
@foreach ($metadatas as $metadata)
    @section('judul_halaman')
        {{ $metadata->Judul }}
    @endsection
    @section('deskripsi_halaman')
        {{ $metadata->Deskripsi }}
    @endsection
@endforeach
@section('konten')
<!-- Import Excel -->
<div class="card shadow mb-4">
    <form action="{{ route ('tambah_stock.update') }}" method="post">
        @csrf
    <div class="card-header d-sm-flex align-items-center justify-content-between py-3">               
        <h6 class="m-0 font-weight-bold text-primary">Tambah Stok Obat</h6>
       
        <button type="submit" class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm"></i> Simpan Perubahan</button> 
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered table-striped" id="obat" width="100%" cellspacing="0">
            <thead>
               <tr>
                    <th style="width:300px;">Nama Obat</th>
                    <th style="width:300px;">Stok</th>
                    <th style="width:300px;">Stok IN</th>
                    <th style="width:300px;">Totol Stok</th>
               </tr>
            </thead>
            <tbody>
                @foreach($obat as $key => $row)
                <tr>
                    <td>{{$row->nama_obat}} <input type="hidden" name="ids[]" value="{{$row->id}}"></td>
                   
                    <td>
                        <input type="number" readonly name="stok[]" id="stok-{{$key}}" value="{{$row->stok}}" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="stok_in[]" id="stok_in-{{$key}}" class="form-control">
                    </td>
                    <td>
                        <input type="number" readonly name="total_stok[]" id="total_stok-{{$key}}" value="{{$row->stok + 0}}" class="form-control">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    </form>
</div>
                              
@endsection
@section('scripts')
    <script>
        $(document).ready( function () {

            $("#obat tbody").on("change", "tr", function(e){    
                $('td', $(this).closest('tr')).each(function()
                {
                    var row_index = $(this).parent().index();
                    let a = parseInt($('#stok-'+row_index).val(), 10);
                    let b = parseInt($('#stok_in-'+row_index).val(), 10)
                    let c = a + b;
                    let d = $('#total_stok-'+row_index).val(c);
                });
            });

            $("#obat tbody").on("keyup", "tr", function(e){    
                $('td', $(this).closest('tr')).each(function()
                {
                    var row_index = $(this).parent().index();
                    let a = parseInt($('#stok-'+row_index).val(), 10);
                    let b = parseInt($('#stok_in-'+row_index).val(), 10)
                    let c = a + b;
                    let d = $('#total_stok-'+row_index).val(c);
                });
            });
            
        });
    </script>
@endsection