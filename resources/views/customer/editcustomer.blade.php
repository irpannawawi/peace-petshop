@extends('layouts.layout')
@section('content')
@include('sweetalert::alert')
<form action="{{route('customer.update', [$customer->kd_ctm])}}" method="POST">
 @csrf
 <input type="hidden" name="_method" value="PUT">
 <fieldset>
 <legend>Edit Data Customer</legend>
 <div class="form-group row">
 <div class="col-md-5">
 <label for="addkdctm">Kode Customer</label>
 <input class="form-control" type="text" name="addkdctm" value="{{$customer->kd_ctm}}" readonly>
 </div>
 <div class="col-md-5">
 <label for="addnmctm">Nama</label>
 <input id="addnmctm" type="text" name="addnmctm" class="form-control" value="{{$customer->nm_ctm}}">
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
 <input id="addalamat" type="text" name="addalamat" class="form-control" value="{{$customer->alamat}}">
 </div>
 <div class="col-md-5">
 <label for="addnotelp">Telepon</label>
 <input id="addnotelp" type="text" name="addnotelp" class="form-control" value="{{$customer->no_telp}}">
 </div>
 </fieldset>
 <div class="col-md-10">
 <input type="submit" class="btn btn-success btn-send" value="Update">
 <a href="{{ route('customer.index') }}"><input type="Button" class="btn btn-primary btn-send" value="Kembali"></a>
 </div>
 <hr>
</form>
@endsection