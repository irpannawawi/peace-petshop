@extends('layouts.layout')
@section('content') 
<div class="d-sm-flex align-items-center justify-content-between mb-4">
 <h1 class="h3 mb-0 text-gray-800">Data Transaksi</h1>
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

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="d-sm-flex align-items-center justify-content-between mb-4">
 <div class="card-body">
     
                @php
                $total=0;
                @endphp
                @foreach ($invoices as $row)
                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        <p class="float-left">{{$row['invoice']}}</p>

                    <div class="btn-group float-right my-auto">
                        @switch ($row['status'])
                        @case ('pesanan terkirim')
                            <a href="/terima_pesanan/{{$row['invoice']}}" class="btn btn-primary ">Proses Pesanan</a>
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#bukti" onclick="fill_image('{{asset('bukti_pembayaran/'.$row['data'][0]->bukti_pembayaran)}}')">Lihat bukti pembayaran</button>
                            <a href="/batalkan_pesanan/{{$row['invoice']}}" class="btn  btn-danger">Batalkan</a>
                            @break
                        @case ('pesanan diterima')
                            <a href="#" class="btn text-dark btn-warning ">Menunggu Konfirmasi Pelanggan</a>
                            @break
                        @case ('pesanan dibatalkan')
                            <button class="btn btn-danger">Dibatalkan</button>
                        @break
                        @default
                            <button class="btn btn-success">Selesai</button>

                        @endswitch
                    </div>
                    </div>
                    <div class="card-body">
                        <span class="float-right"><small>
                            Pengguna : {{$row['data'][0]->customer->nama_cust}} 
                            Tanggal : {{$row['data'][0]->tanggal}}</small></span>
                        <ol class="mt-2">
                            @foreach ($row['data'] as $prd) 
                            <li>
                                <b>{{$prd->produk->nama_produk}}</b>
                                <p>{{$prd->produk->deskripsi}}
                                <span class="float-right">{{$prd->qty}} x Rp. {{number_format($prd->harga_satuan, 0, '.',',')}},-</span>
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
                </div>
                @endforeach
</div>
</div>
<!-- modal add data-->
<div class="modal inmodal fade" id="bukti" tabindex="-1" role="dialog" aria-hidden="true">
 <div class="modal-dialog modal-xs">
     <div class="modal-content">
         <div class="modal-header">
             <h4 class="modal-title">Tambah Data Staf</h4>
         </div>
         <div class="modal-body">
            <img src="" alt="" id="imgBukti" class="img img-fluid">
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
     </div>
</div>
</div>
</div>

<!-- modal edit data-->
<div class="modal inmodal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
 <div class="modal-dialog modal-xs">
  <div class="modal-content">
     <form name="frm_add" id="frm_add" class="form-horizontal" action="/produk/update" method="POST"
     enctype="multipart/form-data">
     @csrf
     <input type="text" name="id_produk" id="idEdit" hidden>
     <div class="modal-header">
        <h4 class="modal-title">Edit Data Produk</h4>
     </div>
     <div class="modal-body">
         <div class="form-group">
                <label class="control-label">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" required
                class="form-control" autocomplete="off" value="{{old('nama_produk')}}">
            </div>
            <div class="form-group">
                <label class="control-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control">{{old('deskripsi')}}</textarea>
            </div>

            <div class="form-group">
                <label class="control-label">Foto</label>
                <input type="file" name="foto" id="foto" 
                class="form-control" value="{{old('foto')}}">
            </div>
            <div class="form-group">
                <label class="control-label">Kategori</label>
                <select name="kategori" id="kategori" class="form-control">
                    <option value="" disabled>--Pilih Kategori--</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Perawatan Hewan">Perawatan Hewan</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Harga</label>
                <input type="number" name="harga" id="harga" 
                class="form-control" value="{{old('harga')}}">
            </div>
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
     <button type="submit" class="btn btn-primary">Simpan</button>
 </div>
</form>
</div>
</div>
</div>
@endsection

<script>
    function fill_image(foto){
        console.log(foto)
        $('#imgBukti').attr('src', foto);
    }
</script>