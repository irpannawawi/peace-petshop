@extends('layouts.layout')
@section('content') 
<div class="d-sm-flex align-items-center justify-content-between mb-4">
 <h1 class="h3 mb-0 text-gray-800">Data Staf</h1>
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
                     <th nowrap>User Id</th>
                     <th>Nama</th>
                     <th>Alamat</th>
                     <th>Jenis Kelamin</th>
                     <th>Tempat/Tgl. Lahir</th>
                     <th>Email</th>
                     <th>Telepon</th>
                     <th>Aksi</th>
                 </tr>
             </thead>
             <tbody>
                @php
                $n=1;
                @endphp
                @foreach ($stafs as $row)
                <tr>
                 <td>{{$n++}}</td>
                 <td>{{$row->id_user}}</td>
                 <td>{{$row->nama}}</td>
                 <td>{{$row->staf->alamat}}</td>
                 <td>{{$row->staf->jk}}</td>
                 <td>{{$row->staf->ttl}}</td>
                 <td>{{$row->email}}</td>
                 <td>{{$row->staf->no_tlp}}</td>
                 <td>
                    <button data-toggle="modal" data-target="#modal-edit" 
                    onclick="fill_edit('{{$row->id_user}}', '{{$row->nama}}', '{{$row->staf->ttl}}', '{{$row->staf->jk}}', '{{$row->staf->alamat}}', '{{$row->email}}', '{{$row->staf->no_tlp}}')"
                    class="btn btn-sm btn-success shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i>Edit Akses
                </button>
                <a href="/staf/delete/{{ $row->id_user }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="btn btn-sm btn-danger shadow-sm">
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
         <form name="frm_add" id="frm_add" class="form-horizontal" action="/staf/insert" method="POST"
         enctype="multipart/form-data">
         @csrf
         <div class="modal-header">
             <h4 class="modal-title">Tambah Data Staf</h4>
         </div>
         <div class="modal-body">
             <div class="form-group">
                <label class="control-label">Nama Staf</label>
                <input type="text" name="nama" required
                class="form-control" autocomplete="off" value="{{old('nama')}}">
            </div>
            <div class="form-group">
                <label class="control-label">Tempat/Tgl. Lahir</label>
                <input type="text" name="ttl" required
                class="form-control" autocomplete="off" value="{{old('ttl')}}" placeholder="Nama Kota, dd-mm-yyyy">
            </div>
            <div class="form-group">
                <label class="control-label">Jenis Kelamin</label>
                <select name="jk" class="form-control">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Alamat</label>
                <input type="text" name="alamat" required
                class="form-control" autocomplete="off" value="{{old('alamat')}}">
            </div>
            <div class="form-group">
                <label class="control-label">Email User</label>
                <input type="email" name="email" required
                class="form-control" autocomplete="off" value="{{old('email')}}">
            </div>
            <div class="form-group">
                <label class="control-label">No. Hp</label>
                <input type="text" name="tlp" required
                class="form-control" autocomplete="off" value="{{old('tlp')}}">
            </div>
            <div class="form-group">
                <label class="control-label">Password</label>
                <input type="password" name="password" required
                class="form-control">
            </div>
            <div class="form-group">
                <label class="control-label">Konfirmasi Password</label>
                <input type="password" name="confirm_password" required
                class="form-control">
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
     <form name="frm_add" id="frm_add" class="form-horizontal" action="/staf/update" method="POST"
     enctype="multipart/form-data">
     @csrf
     <input type="text" name="id_user" id="idEdit" hidden>
     <div class="modal-header">
        <h4 class="modal-title">Edit Data Staf</h4>
     </div>
     <div class="modal-body">
         <div class="form-group">
            <label class="control-label">Nama Staf</label>
            <input type="text" name="nama" id="nama" required
            class="form-control" autocomplete="off" value="{{old('nama')}}">
        </div>
        <div class="form-group">
            <label class="control-label">Tempat/Tgl. Lahir</label>
            <input type="text" name="ttl" id="ttl" required
            class="form-control" autocomplete="off" value="{{old('ttl')}}" placeholder="Nama Kota, dd-mm-yyyy">
        </div>
        <div class="form-group">
            <label class="control-label">Jenis Kelamin</label>
            <select name="jk" id="jk" class="form-control">
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Alamat</label>
            <input type="text" name="alamat" id="alamat" required
            class="form-control" autocomplete="off" value="{{old('alamat')}}">
        </div>
        <div class="form-group">
            <label class="control-label">Email User</label>
            <input type="email" name="email" id="email" required
            class="form-control" autocomplete="off" value="{{old('email')}}">
        </div>
        <div class="form-group">
            <label class="control-label">No. Hp</label>
            <input type="text" name="tlp" id="tlp" required
            class="form-control" autocomplete="off" value="{{old('tlp')}}">
        </div>
        <div class="form-group">
            <label class="control-label">Password</label>
            <input type="password" name="password" id="password"
            class="form-control">
        </div>
        <div class="form-group">
            <label class="control-label">Konfirmasi Password</label>
            <input type="password" name="confirm_password" id="confirm_password"
            class="form-control">
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
    function fill_edit(id, nama, ttl, jk, alamat, email, tlp){
        $('#idEdit').val(id)
        $('#nama').val(nama)
        $('#ttl').val(ttl)
        $('#jk').val(jk)
        $('#alamat').val(alamat)
        $('#email').val(email)
        $('#tlp').val(tlp)
    }
</script>