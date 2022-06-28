@extends('layouts.layout')
@section('content') 
<div class="d-sm-flex align-items-center justify-content-between mb-4">
 <h1 class="h3 mb-0 text-gray-800">Jadwal Grooming</h1>
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
<div class="card">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <div class="card-body">
         <div class="table-responsive">
             <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                 <thead>
                    <!--                  -->
                     <tr align="center">
                         <th>No</th>
                         <th>Kode Transaksi</th>
                         <th>Kode Barang</th>
                         <th>nama_barang</th>
                         <th>jumlah</th>
                         <th>Harga Satuan</th>
                         <th>Total</th>
                         <th>Waktu</th>
                     </tr>
                 </thead>
                 <tbody>
                    @php
                    $n=1;
                    @endphp
                    @foreach ($transaksi as $row)
                    <tr>
                        <td>{{$n++}}</td>
                        <td>{{$row->kd_transaksi}}</td>
                        <td>{{$row->kd_produk}}</td>
                        <td>{{$row->produk->nama_produk}}</td>
                        <td>{{$row->qty}}</td>
                        <td>Rp. {{number_format($row->harga_satuan, 0, '.',',')}},-</td>
                        <td>Rp. {{number_format($row->harga_satuan*$row->qty, 0, '.',',')}},-</td>
                        <td>{{$row->tanggal}}</td>
                    </tr>
                 @endforeach
             </tbody>
         </table>
     </div>
 </div>
</div>
</div>
@endsection

<script>
    function fill_edit(id, nama, email, role){
        $('#idEdit').val(id)
        $('#namaEdit').val(nama)
        $('#emailEdit').val(email)
        $('#rolesEdit').val(role)
    }
</script>