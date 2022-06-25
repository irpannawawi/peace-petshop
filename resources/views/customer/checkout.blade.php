@extends('layouts.public')
@section('content')
<div class="container p-5">
		<h1 align="center">Checkout</h1>
	<div class="row">
		<div class="col">
			<table class="table">
				<tr>
					<th>No</th>
					<th>Barang</th>
					<th width="30%">Jumlah</th>
					<th>Harga</th>
				</tr>
				@php
				$n=1;
				@endphp
				@foreach ($keranjang as $row)
				<tr>
					<td>{{$n++}}</td>
					<td>{{$row->produk->nama_produk}}</td>
					<td>
							{{$row->qty}}
					</td>
					<td><b>Rp. {{number_format($row->produk->harga*$row->qty, 0, '.',',')}},-</b> <small>({{$row->qty.'x'.number_format($row->produk->harga, 0, '.',',')}})</small> <a href="{{route('keranjang-delete-barang', ['id'=>$row->kd_keranjang])}}"><i class="fa fa-times"></i></a></td>
				</tr>
				@endforeach
			</table>
			<form action="{{route('do_checkout')}}" method="POST">
				@csrf
				<div class="form-group">
					<label for="">Jasa Pengiriman</label>
					<select name="pengiriman" class="form-control">
						<option value="-">Pilih Pengriman</option>
						<option value="JNE">JNE</option>
						<option value="J&T">J&T</option>
					</select>
				</div>
				<div class="form-group">
				Alamat :
				<textarea disabled class="form-control">{{$user->customer->alamat}}</textarea>
				</div>
				<div class="form-group">
					<label for="">Opsi Pembayaran</label>
					<select name="pembayaran" class="form-control">
						<option value="Bank BCA">BCA</option>
						<option value="Bank Mandiri">Bank Mandiri</option>
					</select>
				</div>
				<button type="submit" class="btn btn-primary float-right">Konfirmasi</button>
			</form>
		</div>
	</div>
</div>
@endsection