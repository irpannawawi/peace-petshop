@extends('layouts.layout')
@section('content')
@include('sweetalert::alert')
<form action="{{route('produk.update', [$produk->kd_prd])}}" method="POST">
 @csrf
 <input type="hidden" name="_method" value="PUT">
 <fieldset>
 <legend>Edit Data Produk</legend>
 <div class="form-group row">
 <div class="col-md-5">
 <label for="addkdprd">Kode Produk</label>
 <input class="form-control" type="text" name="addkdprd" value="{{$produk->kd_prd}}" readonly>
 </div>
 <div class="col-md-5">
 <label for="addfotoprd">Foto</label>
 <input id="addfotoprd" type="file" name="addfotoprd" class="form-control" value="{{$produk->foto_prd}}">
 </div>
 <div class="col-md-5">
 <label for="addnmprd">Nama Produk</label>
 <input id="addnmprd" type="text" name="addnmprd" class="form-control" value="{{$produk->nm_prd}}">
 </div>
 <div class="col-md-5">
 <label for="addjnprd">Jenis Produk</label>
 <input id="addjnprd" type="text" name="addjnprd" class="form-control" value="{{$produk->jn_prd}}">
 </div>
 <div class="col-md-5">
 <label for="addhrprd">Harga</label>
 <input id="addhrprd" type="text" name="addhrprd" class="form-control" value="{{$produk->no_telp}}">
 </div>
 </fieldset>
 <div class="col-md-10">
 <input type="submit" class="btn btn-success btn-send" value="Update">
 <a href="{{ route('produk.index') }}"><input type="Button" class="btn btn-primary btn-send" value="Kembali"></a>
 </div>
 <hr>
</form>
@endsection