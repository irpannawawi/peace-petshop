@extends('layouts.public')
@section('content')
<div class="container p-5">
		<h1>Produk kami</h1>
	<div class="row">
		@foreach ($produk as $row)
		<div class="col-md-6 col-sm-12 mb-2 col-lg-4">
			<div class="card">
				<img class="card-img" src="{{asset('foto_produk/'.$row->foto)}}" alt="{{$row->nama_produk}}">
				<div class="card-body">
					<h4 class="card-title">{{$row->nama_produk}}</h4>
					<h6 class="card-subtitle mb-2 text-muted">Kategori: {{$row->kategori}}</h6>
					<p class="card-text">{{$row->deskripsi}}</p>
					<div class="buy d-flex justify-content-between align-items-center">
						<div class="price text-success"><h5 class="mt-4">Rp. {{number_format($row->harga, 0, '.', ',')}},- <small>{{$row->kategori=='Makanan'?'/pcs':''}}</small></h5></div>
						@if (!Auth::check())
						<a href="{{ route('login') }}" class="btn btn-danger mt-3"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
						@else
						<a href="{{ route('add_keranjang', ['id' => $row->id_produk]) }}" class="btn btn-danger mt-3"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
						@endif
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endsection