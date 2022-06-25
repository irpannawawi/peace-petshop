@extends('layouts.layout')
@section('content')
@include('sweetalert::alert')
<form action="{{route('staff.update', [$staff->kd_st])}}" method="POST">
 @csrf
 <input type="hidden" name="_method" value="PUT">
 <fieldset>
 <legend>Edit Data Staff Toko</legend>
 <div class="form-group row">
 <div class="col-md-5">
 <label for="addkdst">Kode Staff</label>
 <input class="form-control" type="text" name="addkdst" value="{{$staff->kd_st}}" readonly>
 </div>
 <div class="col-md-5">
 <label for="addnmst">Nama Lengkap</label>
 <input id="addnmst" type="text" name="addnmst" class="form-control" value="{{$staff->nm_st}}">
 </div>
 <div class="col-md-5">
 <label for="addTTL">Tempat, Tanggal Lahir</label>
 <input id="addTTL" type="text" name="addTTL" class="form-control" value="{{$staff->TTL}}">
 </div>
 <div class="col-md-5">
 <label for="addjk">Jenis Kelamin</label>
 <select id="addjk" name="addjk" class="form-control" required>
 <option value="--Pilihan--">--Pilihan--</option>
 <option value="Laki-laki">Laki-laki</option>
 <option value="Perempuan">Perempuan</option>
 </select>
 </div>
 <div class="col-md-5">
 <label for="addalamat">Alamat</label>
 <input id="addalamat" type="text" name="addalamat" class="form-control" value="{{$staff->alamat}}">
 </div>
 <div class="col-md-5">
 <label for="addnotelp">Telepon</label>
 <input id="addnotelp" type="text" name="addnotelp" class="form-control" value="{{$staff->no_telp}}">
 </div>
 </fieldset>
 <div class="col-md-10">
 <input type="submit" class="btn btn-success btn-send" value="Update">
 <a href="{{ route('staff.index') }}"><input type="Button" class="btn btn-primary btn-send" value="Kembali"></a>
 </div>
 <hr>
</form>
@endsection