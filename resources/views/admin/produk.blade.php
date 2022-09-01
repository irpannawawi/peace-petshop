@extends('layouts.layout')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
 <h1 class="h3 mb-0 text-gray-800">Data Produk</h1>
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
 <div class="card-body table-responsive">
         <table class="table table-bordered" id="dataTable" cellspacing="0">
             <thead>
                 <tr align="center">
                     <th nowrap>No</th>
                     <th nowrap> Id Produk</th>
                     <th>Nama barang/Jasa</th>
                     <th>deskripsi</th>
                     <th>foto</th>
                     <th>Kategori</th>
                     <th>Harga</th>
                     <th>Akun</th>
                     <th>Aksi</th>
                 </tr>
             </thead>
             <tbody>
                @php
                $n=1;
                @endphp
                @foreach ($dataProduk as $row)
                <tr>
                 <td>{{$n++}}</td>
                 <td>{{$row->id_produk}}</td>
                 <td>{{$row->nama_produk}}</td>
                 <td>@php echo $row->deskripsi @endphp</td>
                 <td class="text-center">
                     <img src="{{asset('foto_produk/'.$row->foto)}}" class="img" width="200">
                 </td>
                 <td>{{$row->kategori}}</td>
                 <td>{{$row->harga}}</td>
                 <td>{{$row->akun->nama_akun}}</td>
                 <td class="btn-group">
                    <button data-toggle="modal" data-target="#modal-edit" 
                    onclick="fill_edit('{{$row->id_produk}}', '{{$row->nama_produk}}', '@php echo $row->deskripsi @endphp', '{{$row->kategori}}', '{{$row->harga}}', '{{$row->kode_akun}}')"
                    class="btn btn-sm btn-success shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i>Edit Akses
                </button>
                <a href="/produk/delete/{{ $row->id_produk }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="btn btn-sm btn-danger shadow-sm">
                 <i class="fas fa-trash-alt fa-sm text-white-50"></i> Hapus</a>
             </td>
         </tr>
         @endforeach
     </tbody>
 </table>
</div>
</div>
<!-- modal add data-->
<div class="modal inmodal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
 <div class="modal-dialog modal-xs">
     <div class="modal-content">
         <form name="frm_add" id="frm_add" class="form-horizontal" action="/produk/insert" method="POST"
         enctype="multipart/form-data">
         @csrf
         <div class="modal-header">
             <h4 class="modal-title">Tambah Data Staf</h4>
         </div>
         <div class="modal-body">
            <div class="form-group">
                <label class="control-label">Nama Produk</label>
                <input type="text" name="nama_produk" required
                class="form-control" autocomplete="off" value="{{old('nama_produk')}}">
            </div>
            <div class="form-group">
                <label class="control-label">Deskripsi</label>
                <textarea name="deskripsi"  id="editor2">{{old('deskripsi')}}</textarea>
            </div>

            <div class="form-group">
                <label class="control-label">Foto</label>
                <input type="file" name="foto" 
                class="form-control" value="{{old('foto')}}">
            </div>
            <div class="form-group">
                <label class="control-label">Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="" disabled>--Pilih Kategori--</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Perawatan Hewan">Perawatan Hewan</option>
                </select>
            </div>
            <div class="row">
                <div class="form-group col">
                    <label class="control-label">Harga</label>
                    <input type="number" name="harga" 
                    class="form-control" value="{{old('harga')}}">
                </div>
                <div class="form-group col">
                    <label class="control-label">Akun</label>
                    <select name="kode_akun" class="form-control">
                        <option value="" disabled>--Pilih Kategori--</option>
                        @foreach ($dataAkun as $ak)
                        <option value="{{$ak->kode_akun}}">{{$ak->nama_akun}}</option>
                        @endforeach
                    </select>
                </div>
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
     <form name="frm_add" id="frm_add" class="form-horizontal" action="/produk/update" method="POST"
     enctype="multipart/form-data">
     @csrf
     <input type="text" name="id_produk" id="idEdit" hidden>
     <div class="modal-header">
        <h4 class="modal-title">Edit Data Produk</h4>
     </div>
     <div class="modal-body">
         <div class="form-group">
                <label class="control-label">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" required
                class="form-control" autocomplete="off" value="{{old('nama_produk')}}">
            </div>
            <div class="form-group">
                <label class="control-label">Deskripsi</label>
                <textarea name="deskripsi" id="editor" >{{old('deskripsi')}}</textarea>
            </div>

            <div class="form-group">
                <label class="control-label">Foto</label>
                <input type="file" name="foto" id="foto" 
                class="form-control" value="{{old('foto')}}">
            </div>
            <div class="form-group">
                <label class="control-label">Kategori</label>
                <select name="kategori" id="kategori" class="form-control">
                    <option value="" disabled>--Pilih Kategori--</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Perawatan Hewan">Perawatan Hewan</option>
                </select>
            </div>
            <div class="row">
                <div class="form-group col">
                    <label class="control-label">Harga</label>
                    <input type="number" name="harga" id="harga" 
                    class="form-control" value="{{old('harga')}}">
                </div>
                <div class="form-group col">
                    <label class="control-label">Akun</label>
                    <select name="kode_akun" class="form-control" id="kode-akun">
                        <option value="" disabled>--Pilih Kategori--</option>
                        @foreach ($dataAkun as $ak)
                        <option value="{{$ak->kode_akun}}">{{$ak->nama_akun}}</option>
                        @endforeach
                    </select>
                </div>
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
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>

<script>
    let descEditor;
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .then(editor => {
            window.editor = editor;
            descEditor = editor;
        })
        .catch( error => {
            console.error( error );
        } );
    let descEditor2;
    ClassicEditor
        .create( document.querySelector( '#editor2' ) )
        .then(editor => {
            window.editor = editor;
            descEditor2 = editor;
        })
        .catch( error => {
            console.error( error );
        } );
    function fill_edit(id, nama, deskripsi, kategori, harga, kode_akun){
        console.log('ok')
        $('#idEdit').val(id)
        $('#nama_produk').val(nama)
        descEditor.setData(deskripsi)
        $('#deskripsi').val(deskripsi)
        $('#kategori').val(kategori)
        $('#harga').val(harga)
        $('#kode-akun').val(kode_akun)
    }
</script>
        @endsection