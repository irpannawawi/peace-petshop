@extends('layouts.layout')
@section('content') 
<div class="d-sm-flex align-items-center justify-content-between mb-4">
 <h1 class="h3 mb-0 text-gray-800">Laporan Penjualan</h1>
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
        <div class="card-header d-sm-flex flex-row-reverse">
        <div class="p2">
        <button class="btn btn-info" data-toggle="modal" data-target="#modal-print"><i class="fa fa-print"></i> Cetak</button>
        </div>
    </div>
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <div class="card-body">
         <div class="table-responsive">
             <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                 <thead>
                    <!--                  -->
                     <tr align="center">
                         <th>No</th>
                         <th>Kode Barang</th>
                         <th>nama_barang</th>
                         <th>jumlah</th>
                         <th>Harga Satuan</th>
                         <th>Total</th>
                     </tr>
                 </thead>
                 <tbody>
                    @php
                    $n=1;
                    @endphp
                    @foreach ($dataTransaksi as $row)
                    <tr>
                        <td>{{$n++}}</td>
                        <td>{{$row['kd_produk']}}</td>
                        <td>{{$row['nama_produk']}}</td>
                        <td>{{$row['jumlah']}}</td>
                        <td>Rp. {{number_format($row['harga'], 0, '.',',')}},- <small>(+ PPN 11% Rp. {{number_format($row['harga']*11/100, 0, '.',',')}},- )</small> </td>
                        <td nowrap>Rp. {{number_format($row['total']+($row['total']*11/100), 0, '.',',')}},-</td>
                    </tr>
                 @endforeach
             </tbody>
         </table>
     </div>
 </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cetak Laporan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-borderless">
            <tr>
                <th nowrap>Cetak harian</th>
                <td class="form-inline">
                    <form action="{{route('print-laporan-penjualan')}}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="tipe" value="harian" hidden>
                            <select name="tgl" class="form-control">
                                @for ($n=1; $n<32; $n++)
                                <option value="{{strlen($n)<2?'0'.$n:$n}}" @if ($n == date('d')) selected @endif>{{strlen($n)<2?'0'.$n:$n}}</option>
                                @endfor
                            </select>
                            <select name="bln" class="form-control">
                                @foreach (['01'=>'Jan', '02'=>'Feb', '03'=>'Mar', '04'=>'Apr', '05'=>'Mei', '06'=>'Jun', '07'=>'Jul', '08'=>'Agu', '09'=>'Sep', '10'=>'Okt', '11'=>'Nov', '12'=>'Des'] as $key  => $value)
                                <option 
                                @if ($key == date('m')) 
                                selected 
                                @endif
                                value="{{$key}}" 
                                >{{$value}}</option>
                                @endforeach
                            </select>
                            <input type="number" class="form-control" name="thn" value="{{date('Y')}}">
                          <div class="input-group-append">
                            <button class="input-group-text btn btn-info" type="submit">Print</button>
                          </div>
                        </div>  
                    </form>
                </td>
            </tr>
            <tr>
                <th nowrap>Cetak Bulanan</th>
                <td class="form-inline">
                    <form action="{{route('print-laporan-penjualan')}}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="tipe" value="bulanan" hidden>                            <select name="bln" class="form-control">
                                @foreach (['01'=>'Jan', '02'=>'Feb', '03'=>'Mar', '04'=>'Apr', '05'=>'Mei', '06'=>'Jun', '07'=>'Jul', '08'=>'Agu', '09'=>'Sep', '10'=>'Okt', '11'=>'Nov', '12'=>'Des'] as $key  => $value)
                                <option 
                                @if ($key == date('m')) 
                                selected 
                                @endif
                                value="{{$key}}" 
                                >{{$value}}</option>
                                @endforeach
                            </select>
                            <input type="number" class="form-control" name="thn" value="{{date('Y')}}">
                          <div class="input-group-append">
                            <button class="input-group-text btn btn-info" type="submit">Print</button>
                          </div>
                        </div>  
                    </form>
                </td>
            </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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