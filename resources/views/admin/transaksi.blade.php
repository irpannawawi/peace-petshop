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
<div class="d-flex flex-row-reverse">
<div class="search-box p-2 mx-3">
    <form action="{{route('admin-transaksi')}}" method="GET">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="search" name="keywords">
          <div class="input-group-append">
            <button type="submit" class="input-group-text" id="basic-addon2"><i class="fa fa-search"></i></button>
          </div>
        </div>
    </form>
</div> 
</div>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
 <div class="card-body">
                @php
                $total=0;
                @endphp
                @foreach ($invoices as $row)
                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        <h5 class="float-left">{{$row['invoice']}} @if ($row['status'] == 'pesanan terkirim')<span class="badge badge-danger">New</span>@endif</h5>

                    <div class="float-right my-auto row">
                        @switch ($row['status'])
                        @case ('pesanan terkirim')
                        <div class="dropdown">
                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Proses
                            </button>
                            <div class="dropdown-menu">
                                <a href="/terima_pesanan/{{$row['invoice']}}" class="dropdown-item">Proses Pesanan</a>
                                <button class="dropdown-item" data-toggle="modal" data-target="#bukti" onclick="fill_image('{{asset('bukti_pembayaran/'.$row['data'][0]->bukti_pembayaran)}}')">Lihat bukti pembayaran</button>
                                <div class="dropdown-divider"></div>
                                <a href="/batalkan_pesanan/{{$row['invoice']}}" onclick="return confirm('Batalkan pesanan?')" class="dropdown-item text-danger">Batalkan</a>
                            </div>
                        </div>
                            @break
                        @case ('pesanan diterima')
                            <a href="#" class="btn text-dark btn-warning ">Menunggu Konfirmasi Pelanggan</a>
                            @break
                        @case ('pesanan dibatalkan')
                            <button class="btn btn-danger col-sm-12">Dibatalkan</button>
                        @break
                        @default
                            <button class="btn btn-success">Selesai</button>
                        @endswitch
                    </div>
                    </div>
                    <div class="card-body">

                        <p class="float-right mb-2"><small>
                            Pengguna : {{$row['data'][0]->customer->nama_cust}} 
                            Tanggal : {{$row['data'][0]->tanggal}}</small> | 
                            @if ($row['status'] == 'pesanan terkirim' OR $row['status'] == 'pesanan diterima')
                            <button class="btn btn-default btn-md">
                                <i class="fa fa-print"> Print resi</i>
                            </button>
                            @endif
                        </p>
                            <br>
                        <ol class="mt-2">
                            <table class="table table-borderless">
                            @php
                                $n = 1;
                            @endphp
                            @foreach ($row['data'] as $prd) 
                                <tr>
                                    <th>{{$n++.'. '.$prd->produk->nama_produk}}</th>
                                    <td rowspan="2" nowrap class="text-right">{{$prd->qty}} x Rp. {{number_format($prd->harga_satuan, 0, '.',',')}},-</td>
                                </tr>
                                <tr>
                                    <td class="px-5">
                                        {{$prd->produk->deskripsi}}
                                    </td>
                                </tr>
                            @php
                            $total += $prd->qty*$prd->harga_satuan;
                            @endphp
                            @endforeach
                            </table>
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
             <h4 class="modal-title">Bukti pembayaran</h4>
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

@endsection

<script>
    function fill_image(foto){
        console.log(foto)
        $('#imgBukti').attr('src', foto);
    }
</script>