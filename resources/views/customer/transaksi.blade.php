@extends('layouts.public')
@section('content')
<div class="container p-5">
	<h1>Daftar Transaksi Anda</h1>
	<div class="row">
		<div class="col-12">
			@foreach ($invoices as $row)
			@php
			$total =0;
			@endphp
			<div class="card mb-3">
				<div class="card-header">
					<small>Invoice: </small>
					<b class="text-dark">{{$row['invoice']}}</b>

					<div class="btn-group float-right my-auto">
						@switch ($row['status'])
							@case ('menunggu pembayaran')
								<button class="btn btn-secondary"  data-toggle="modal" data-target="#bayar-modal" onclick="fill_id('{{$row['invoice']}}', 'Rp. {{number_format($row['total'], 0, '.',',')}},-', '{{$row['data'][0]->pembayaran}}')">Bayar</button>
								<a href="#" class="btn  btn-danger">Batalkan Pesanan</a>
							@break
							@case ('pesanan terkirim')
								<button class="btn btn-success">Pesanan Terkirim, Menunggu konfirmasi oleh toko</button>
							@break
							@case ('pesanan diterima')
							<button class="btn btn-secondary" disabled>Pesanan diterima dan dalam proses pengiriman</button>
								<a href="/konfirmasi_penerimaan/{{$row['invoice']}}" onclick="return confirm('pastikan anda telah menerima pesanan')" class="btn btn-success ">Konfirmasi Pesanan</a>
							@break
							@case ('pesanan dibatalkan')
								<button class="btn btn-danger">Dibatalkan</button>
							@break

							@default
								<button class="btn btn-success">Selesai</button>
								@break
						@endswitch
					<hr>
					</div>

				</div>
				<div class="card-body">
					<ol>
						@foreach ($row['data'] as $prd) 
						<li>
							<b>{{$prd->produk->nama_produk}}</b>
								<span class="float-right">{{$prd->qty}} x Rp. {{number_format($prd->harga_satuan, 0, '.',',')}},-</span>
							<p>{{$prd->produk->deskripsi}}</p>
								<hr/>
							</li>
							@php
							$total += $prd->qty*$prd->harga_satuan;
							@endphp
							@endforeach
						</ol>
						<table class="table table-no-border">
							<tr>
								<th>Total</th>
								<th class="text-right">Rp. {{number_format($total, 0, '.', '.')}},-</th>
							</tr>
						</table>
					</div>
					<div class="card-footer">
						<div class="col">
						<small>Jika anda memesan layanan grooming, kunjungi gerai dan tunjukan invoice untuk transaksi ini setelah upload bukti pembayaran.</small>
					</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="bayar-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="{{route('bayar-transaksi')}}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Silahkan transfer sejumlah <b><span id="nominalBayar"></span></b> ke nomor rekening berikut <b><span id="norek"> </span></b></p>
						<div class="form-group">
							<label for="">Upload Bukti Pembayaran</label>
							<input type="file" class="form-control" name="bukti_pembayaran">
							<input type="text" id="idTrx" name="id" hidden>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Kirim</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		function fill_id(id, total, metode)
		{
			$('#idTrx').val(id)
			$('#nominalBayar').html(total)
			if(metode == 'Bank BCA'){
				metode += " 11654383 An. Peace Petshop"
			}else{
				metode += " 6647867742311 An. Peace Petshop"
			}
			console.log(metode)
			$('#norek').html(metode)
		}
	</script>
	@endsection