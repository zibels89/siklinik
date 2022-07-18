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
<!--Modal Konfirmasi Delete-->
<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="{{ route ('obat.import_excel') }}" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
        </div>
        <div class="modal-body">

          {{ csrf_field() }}

          <label>Pilih file excel</label>
          <div class="form-group">
            <input type="file" name="file" required="required">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Import</button>
        </div>
      </div>
    </form>
  </div>
</div>
    <div id="DeleteModal" class="modal fade text-danger" role="dialog">
   <div class="modal-dialog modal-dialog modal-dialog-centered ">
     <!-- Modal content-->
     <form action="" id="deleteForm" method="post">
         <div class="modal-content">
             <div class="modal-header bg-danger">
                 <h4 class="modal-title text-center text-white" >Konfirmasi Penghapusan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 {{ csrf_field() }}
                 {{ method_field('DELETE') }}
                 <p class="text-center">Apakah anda yakin untuk menghapus obat? Data yang sudah dihapus tidak bisa kembali</p>
             </div>
             <div class="modal-footer">
                 <center>
                     <button type="button" class="btn btn-success" data-dismiss="modal">Tidak, Batal</button>
                     <button type="button" name="" class="btn btn-danger" data-dismiss="modal" onclick="formSubmit()">Ya, Hapus</button>
                 </center>
             </div>
         </div>
     </form>
   </div>
  </div>
<!--End Modal-->
    <div class="card shadow mb-4">
        <div class="card-header d-sm-flex align-items-center justify-content-between py-3">               
            <h6 class="m-0 font-weight-bold text-primary">Daftar Stok Obat</h6>
            <div class="btn-group">
              <button type="button" class="d-none d-sm-inline-block btn btn-success btn-sm shadow-sm" data-toggle="modal" data-target="#importExcel">
              <i class="fas fa-upload fa-sm"></i> Import Excel
              </button>
              <a href="{{route('obat.tambah')}}" class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm">
              <i class="fas fa-plus fa-sm"></i> Tambah Obat</a> 
            </div>
        </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nama Obat</th>
                      <!-- <th>Sediaan</th>
                      <th>Dosis</th> -->
                      <th>Stok</th>
                      <th>Harga</th>
                      <th>Tindakan</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nama Obat</th>
                      <!-- <th>Sediaan</th>
                      <th>Dosis</th> -->
                      <th>Stok</th>
                      <th>Harga</th>
                      <th>Tindakan</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  @foreach ($obats as $obat)
                    <tr>
                      <td>{{ $obat->nama_obat }}</td>
                      <!-- <td>{{ $obat->sediaan }}</td>
                      <td>{{ $obat->dosis }} {{$obat->satuan}}</td> -->
                      <td>{{ $obat->stok }}</td>
                      <td>{{ formatrupiah($obat->harga)}}</td>
                      <td>
                        <a href ="{{ route('obat.edit', $obat->id) }}" class="btn btn-sm btn-icon-split btn-warning">
                            <span class="icon"><i class="fa fa-pen" style="padding-top: 4px;"></i></span><span class="text">Edit</span>
                        </a>
                        <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$obat->id}})" data-target="#DeleteModal" class="btn btn-sm btn-icon-split btn-danger">
                            <span class="icon"><i class="fa  fa-trash" style="padding-top: 4px;"></i></span><span class="text">Hapus</span></a>

                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
  <script type="text/javascript">
     function deleteData(id)
     {
         var id = id;
         var url = '{{ route("obat.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteForm").attr('action', url);
     }

     function formSubmit()
     {
         $("#deleteForm").submit();
     }
  </script>
@endsection