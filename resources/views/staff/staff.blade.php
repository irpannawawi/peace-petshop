@extends('layouts.layout')
@section('content')
@include('sweetalert::alert')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
 <h1 class="h3 mb-0 text-gray-800">Data Staff Toko</h1>
</div>
<hr>
<div class="card-header py-3" align="right">
<button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#exampleModalScrollable">
<i class="fas fa-plus fa-sm text-white-50"></i> Tambah </button>
</div>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered table-striped" id="dataTable" width="150%" cellspacing="0">
 <thead class="thead-dark">
 <tr>
 <th>Kode Staff</th>
 <th>Nama</th>
 <th>Tempat,Tanggal Lahir</th>
 <th>Jenis Kelamin</th>
 <th>Alamat</th>
 <th>Telepon</th>
 </tr>
 </thead>
 <tbody>
 @foreach($staff as $stf)
 <tr>
 <td>{{ $stf->kd_st}}</td>
 <td>{{ $stf->nm_st}}</td>
 <td>{{ $stf->TTL}}</td>
 <td>{{ $stf->jk}}</td>
 <td>{{ $stf->alamat}}</td>
 <td>{{ $stf->no_telp}}</td>
 <td align="center"><a href="{{route('staff.edit',[$stf->kd_st])}}"class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
 <i class="fas fa-edit fa-sm text-white-50"></i> Edit</a>
 <a href="/staff/hapus/{{$stf->kd_st}}" onclick="return confirm('Yakin Ingin menghapus data?')" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
 <i class="fas fa-trash-alt fa-sm text-white-50"></i> Hapus</a>
 </td>
 </tr>
 @endforeach
 </tbody>
 </table>
</div>
</div>
</div>
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
 <div class="modal-dialog modal-dialog-scrollable" role="document">
 <div class="modal-content">
 <div class="modal-header">
 <h5 class="modal-title" id="exampleModalScrollableTitle">Tambah Data Staff Toko</h5>
 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
 <span aria-hidden="true">&times;</span>
 </button>
 </div>
 <form action="{{ action('staffController@store') }}" method="POST">
 @csrf
 <div class="modal-body">
 <div class="form-group">
 <label for="exampleFormControlInput1">Kode Staff</label>
 <input type="text" name="addkdst" id="addkdst" class="form-control" maxlegth="10" id="exampleFormControlInput1" >
 </div>
 <div class="form-group">
 <label for="exampleFormControlInput1">Nama</label>
 <input type="text" name="addnmst" id="addnmst" class="form-control" id="exampleFormControlInput1" >
 </div>
 <div class="form-group">
 <label for="exampleFormControlInput1">Tempat, Tgl Lahir</label>
 <input type="text" name="addTTL" id="addTTL" class="form-control" id="exampleFormControlInput1" >
 </div>
 <div class="form-group row">
 <div class="col-md-5">
 <label for="addjk">Jenis Kelamin</label>
 <select id="addjk" name="addjk" class="form-control" required>
 <option value="Laki-laki">Laki-laki</option>
 <option value="Perempuan">Perempuan</option>
 </select>
 </div>
 <div class="form-group">
 <label for="exampleFormControlInput1">Alamat</label>
 <input type="text" name="addalamat" id="addalamat" class="form-control" id="exampleFormControlInput1" >
 </div>
 <div class="form-group">
 <label for="exampleFormControlInput1">Telepon</label>
 <input type="text" name="addnotelp" id="addnotelp" class="form-control" id="exampleFormControlInput1" >
 </div>
 <div class="modal-footer">
 <button type="button" class="btn btn-secondary" data-dismiss="modal"> Batal</button>
 <input type="submit" class="btn btn-primary btn-send" value="Simpan">
 </div>
 </div>
 </form>
 </div>
</div>
@endsection