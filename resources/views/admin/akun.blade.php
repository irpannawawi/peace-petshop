@extends('layouts.layout')
@section('content') 
<div class="d-sm-flex align-items-center justify-content-between mb-4">
 <h1 class="h3 mb-0 text-gray-800">Data Akun</h1>
</div><hr>
<div class="card-header py-3" align="right">
 <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-add"><i
     class="fa fa-plus"></i>Tambah</button>
 </div>
 @if (session('msg'))
 <div class="alert alert-success">
    {{ session('msg') }}
</div>
@endif 
@if (session('err-msg'))
<div class="alert alert-danger">
    {{ session('err-msg') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="d-sm-flex align-items-center justify-content-between mb-4">
 <div class="card-body">
     <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" cellspacing="0">
             <thead>
                 <tr align="center">
                     <th nowrap>No</th>
                     <th nowrap>Kode Akun</th>
                     <th>Nama Akun</th>
                     <th>Default</th>
                     <th>Aksi</th>
                 </tr>
             </thead>
             <tbody>
                @php
                $n=1;
                @endphp
                @foreach ($akun as $row)
                <tr>
                 <td>{{$n++}}</td>
                 <td>{{$row->kode_akun}}</td>
                 <td>{{$row->nama_akun}}</td>
                 <td>{{$row->default}}</td>
                 <td>
                    <button data-toggle="modal" data-target="#modal-edit" 
                    onclick="fill_edit('{{$row->id_akun}}', '{{$row->kode_akun}}', '{{$row->nama_akun}}', '{{$row->default}}')"
                    class="btn btn-sm btn-success shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i>Edit
                </button>
                <a href="/akun/delete/{{ $row->id_akun }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="btn btn-sm btn-danger shadow-sm">
                 <i class="fas fa-trash-alt fa-sm text-white-50"></i> Hapus</a>
             </td>
         </tr>
         @endforeach
     </tbody>
 </table>
</div>
</div>
</div>
<!-- modal add data-->
<div class="modal inmodal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
 <div class="modal-dialog modal-xs">
     <div class="modal-content">
         <form name="frm_add" id="frm_add" class="form-horizontal" action="/akun/insert" method="POST"
         enctype="multipart/form-data">
         @csrf
         <div class="modal-header">
             <h4 class="modal-title">Tambah Data Akun</h4>
         </div>
         <div class="modal-body">
             <div class="form-group">
                <label class="control-label">Kode Akun</label>
                <input type="text" name="kode_akun" required
                class="form-control" autocomplete="off" value="{{old('kode_akun')}}">
            </div>
            <div class="form-group">
                <label class="control-label">Nama Akun</label>
                <input type="text" name="nama_akun" required
                class="form-control" autocomplete="off" value="{{old('nama_akun')}}">
            </div>
            <div class="form-check">
              <input class="form-check-input" name="default" type="checkbox" value="Kas Masuk" id="kas-masuk">
              <label class="form-check-label" for="kas-masuk">
                Default Kas Masuk
              </label>
            </div>
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
         <button type="submit" class="btn btn-primary">Simpan</button>
     </div>
 </form>
</div>
</div>
</div>

<!-- modal edit data-->
<div class="modal inmodal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
 <div class="modal-dialog modal-xs">
  <div class="modal-content">
     <form name="frm_add" id="frm_add" class="form-horizontal" action="/akun/update" method="POST"
     enctype="multipart/form-data">
     @csrf
     <input type="text" name="id_akun" id="idEdit" hidden>
     <div class="modal-header">
        <h4 class="modal-title">Edit Data Akun</h4>
     </div>
     <div class="modal-body">
         <div class="form-group">
            <label class="control-label">Kode Akun</label>
            <input type="text" name="kode_akun" id="kode_akun" required
            class="form-control" autocomplete="off" value="{{old('kode_akun')}}">
        </div>
        <div class="form-group">
            <label class="control-label">Nama Akun</label>
            <input type="text" name="nama_akun" id="nama_akun" required
            class="form-control" autocomplete="off" value="{{old('nama_akun')}}">
        </div>

            <div class="form-check">
              <input class="form-check-input" name="default" type="checkbox" value="Kas Masuk" id="defKasMasuk">
              <label class="form-check-label" for="defKasMasuk">
                Default Kas Masuk
              </label>
            </div>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
     <button type="submit" class="btn btn-primary">Simpan</button>
 </div>
</form>
</div>
</div>
</div>
@endsection

<script>
    function fill_edit(id,  kode_akun, nama_akun, def){
        $('#idEdit').val(id)
        $('#nama_akun').val(nama_akun)
        $('#kode_akun').val(kode_akun)
        if(def != '')
        {
            $('#defKasMasuk').prop('checked', true);
        }else{
            $('#defKasMasuk').prop('checked', false);
        }
    }
</script>