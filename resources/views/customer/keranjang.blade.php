@extends('layouts.public')
@section('content')
<div class="container p-5">
		<h1>Keranjang</h1>
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
						@if($row->produk->kategori == 'Makanan')
							<form action="{{route('update-qty-barang',['id'=>$row->kd_keranjang])}}" method="POST">
								@csrf
								<div class="form-group">
							<input type="number" name="qty" value="{{$row->qty}}" class="col-4 form-control d-inline"> <button type="submit" class="btn btn-sm btn-primary">Ubah</button>
								</div>
							</form>
						@else
							{{$row->qty}}
						@endif
					</td>
					<td><b>Rp. {{number_format($row->produk->harga*$row->qty, 0, '.',',')}},-</b> <small>({{$row->qty.'x'.number_format($row->produk->harga, 0, '.',',')}})</small> <a href="{{route('keranjang-delete-barang', ['id'=>$row->kd_keranjang])}}"><i class="fa fa-times"></i></a></td>
				</tr>
				@endforeach
				<tr>
					<th colspan="3">Jumlah</th>
					<th>Rp. {{number_format($total_bayar, 0, '.',',')}},-</th>
				</tr>
			</table>
			<a class="btn btn-primary float-right" href="{{route('checkout')}}">Checkout</a>
		</div>
	</div>
</div>
@endsection