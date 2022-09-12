@extends('layouts.public')
@section('content')
@php
$total_bayar=0;
@endphp
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

					@php
						$disc=0;
						$disc_type=null;
						$has_disc = false;
						$harga_pcs = $row->produk->harga;
						foreach($diskon as $ds ){
							if($row->qty >= $ds->min_belanja){
								$disc = $ds->nominal==null?$ds->persen:$ds->nominal;
								$disc_type = $ds->nominal==null?'persen':'nominal';
								$has_disc = true;

								$harga_pcs = $disc_type=='persen'?$harga_pcs-($harga_pcs*$ds->persen/100):$harga_pcs-$ds->nominal;
								if($harga_pcs <1 )$harga_pcs=0;
								break;
							}
						}
						$total_harga_produk = $harga_pcs*$row->qty;
						$total_bayar += $total_harga_produk;
					@endphp
					<td><b>Rp. {{number_format($total_harga_produk, 0, '.',',')}},-</b> 
						<small>
							(
								{{$row->qty}} x 
						@if($has_disc == true)
						<s>
						@endif 
								{{number_format($row->produk->harga, 0, '.',',')}}
						@if($has_disc == true)
						</s>
						@endif
						@if($has_disc == true)
								{{number_format($harga_pcs, 0, '.',',')}}
						@endif
							)
						</small> 
						<a href="{{route('keranjang-delete-barang', ['id'=>$row->kd_keranjang])}}"><i class="fa fa-times"></i></a></td>
				</tr>
				@endforeach
				<tr>
					<th colspan="3">Jumlah</th>
					<th>Rp. {{number_format($total_bayar+($total_bayar*$tax/100), 0, '.',',')}},- <small>(PPN {{$tax}}%)</small> 

					</th>
				</tr>
			</table>
			<a class="btn btn-primary float-right" href="{{route('checkout')}}">Checkout</a>
		</div>
	</div>
</div>
@endsection