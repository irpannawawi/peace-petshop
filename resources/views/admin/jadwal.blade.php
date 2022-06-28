@extends('layouts.layout')
@section('content') 
<div class="d-sm-flex align-items-center justify-content-between mb-4">
 <h1 class="h3 mb-0 text-gray-800">Jadwal Grooming</h1>
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
<div class="card">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <div class="card-body">
         <div class="table-responsive">
             <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                 <thead>
                     <tr align="center">
                         <th width="5%" nowrap>No</th>
                         <th width="5%" nowrap>Invoice</th>
                         <th width="25%">Nama</th>
                         <th width="20%">Tanggal</th>
                         <th width="15%">Status</th>
                     </tr>
                 </thead>
                 <tbody>
                    @php
                    $n=1;
                    @endphp
                    @foreach ($jadwal as $row)
                    <tr>
                        <td>{{$n++}}</td>
                        <td>{{$row->transaksi->invoice}}</td>
                        <td>{{$row->customer->nama_cust}}</td>
                        <td>{{$row->tanggal}}</td>
                        <td>@if ($row->status == 'selesai')
                            <span class="badge badge-success">
                        {{$row->status}}
                            </span>
                            @else
                        Dalam antrian
                            @endif
                        </td>
                    </tr>
                 @endforeach
             </tbody>
         </table>
     </div>
 </div>
</div>
</div>

<!-- modal add data-->
<div class="modal inmodal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
 <div class="modal-dialog modal-xs">
     <form name="frm_add" id="frm_add" class="form-horizontal" action="/admin/pengguna/insert" method="POST"
     enctype="multipart/form-data">
     @csrf
     <div class="modal-content">
         <div class="modal-header">
             <h4 class="modal-title">Tambah Data User</h4>
         </div>
         <div class="modal-body">
             <div class="form-group">
                <label class="col-lg-20 control-label">Nama User</label>
                <div class="col-lg-10">
                    <input type="text" name="nama" required
                    class="form-control" autocomplete="off" value="{{old('nama')}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-20 control-label">Email User</label>
                <div class="col-lg-10">
                    <input type="email" name="email" required
                    class="form-control" autocomplete="off" value="{{old('email')}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-20 control-label">Password</label>
                <div class="col-lg-10">
                    <input type="password" name="password" required
                    class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-20 control-label">Konfirmasi Password</label>
                <div class="col-lg-10">
                    <input type="password" name="confirm_password" required
                    class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-20 control-label">Roles/Akses</label>
                <div class="col-lg-10">
                    <select id="roles" name="role" class="form-control" required>
                     <option value="">--Pilih Roles--</option>
                     <option value="admin" value="{{ old('role')=='admin'?'selected':'' }}">Admin</option>
                     <option value="owner" value="{{ old('role')=='owner'?'selected':'' }}">Owner</option>
                 </select>
             </div>
         </div>
     </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
         <button type="submit" class="btn btn-primary">Simpan</button>
     </div>
 </div>
</form>
</div>
</div>

<!-- modal edit data-->
<div class="modal inmodal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
 <div class="modal-dialog modal-xs">
     <form  class="form-horizontal" action="/admin/pengguna/edit" method="POST"
     enctype="multipart/form-data">
     @csrf
     <input type="text" name="id_user" id="idEdit" hidden>
     <div class="modal-content">
         <div class="modal-header">
             <h4 class="modal-title">Edit Data User</h4>
         </div>
         <div class="modal-body">
             <div class="form-group">
                <label class="col-lg-20 control-label">Nama User</label>
                <div class="col-lg-10">
                    <input type="text" name="nama" required
                    class="form-control" id="namaEdit" autocomplete="off" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-20 control-label">Email User</label>
                <div class="col-lg-10">
                    <input type="email" name="email" required id="emailEdit"
                    class="form-control" autocomplete="off" >
                </div>
            </div>
            <div class="form-group">
                <span>Kosongkan jika tidak ingin merubah password</span>
                <label class="col-lg-20 control-label">Password</label>
                <div class="col-lg-10">
                    <input type="password" name="password"
                    class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-20 control-label">Konfirmasi Password</label>
                <div class="col-lg-10">
                    <input type="password" name="confirm_password"
                    class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-20 control-label">Roles/Akses</label>
                <div class="col-lg-10">
                    <select id="rolesEdit" name="role" class="form-control" required>
                     <option value="">--Pilih Roles--</option>
                     <option value="admin">Admin</option>
                     <option value="owner">Owner</option>
                 </select>
             </div>
         </div>
     </div>
     <div class="modal-footer">
         <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
         <button type="submit" class="btn btn-primary">Simpan</button>
     </div>
     @endsection
 </div>
</form>
</div>
</div>

<script>
    function fill_edit(id, nama, email, role){
        $('#idEdit').val(id)
        $('#namaEdit').val(nama)
        $('#emailEdit').val(email)
        $('#rolesEdit').val(role)
    }
</script>