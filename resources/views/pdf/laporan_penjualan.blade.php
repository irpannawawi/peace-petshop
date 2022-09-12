<html>
<head>
  <style>
    h1{
       font-family: sans-serif;
    }

    table {
       font-family: Arial, Helvetica, sans-serif;
       color:black;
       background: #eaebec;
       border: black 2px solid;
       margin: 0px auto;
       font-size: 12px;
    }

    table th {
       padding: 8px;
       border-left:1px solid black;
       border-bottom: 1px solid black;

       background: #2C3639; 
    }

    table th:first-child{  
       border-left:none;  
    }

    table tr {
       text-align: center;
    }

    table td:first-child {
       text-align: left;
       border-left: 0;
    }

    table td {
       padding: 6px;
       border: 1px solid black;
       background: white;
    }

    table tr:last-child td {
       border-bottom: 0;
    }



 </style>
</head>
<body>
   <h1 align="center">Laporan Penjualan <br><small>{{$tgl}}</small></h1>
 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
       <!--                  -->
       <tr style="color:white;">
        <th>No</th>
        <th>Kode Produk</th>
        <th>Nama Produk</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Total</th>
     </tr>
  </thead>
  <tbody>
    @php
     $n=1;
     $total = 0;
    @endphp
    @foreach ($dataTransaksi as $row)
    <tr>
      <td>{{$n++}}</td>
      <td>{{$row['kd_produk']}}</td>
      <td>{{$row['nama_produk']}}</td>
      <td>{{$row['jumlah']}}</td>
      <td nowrap>Rp. {{number_format($row['harga'], 0, '.',',')}},- <br>(tidak termasuk Pajak, Perlu perhitungan manual)</td>
      <td nowrap>Rp. {{number_format($row['total'], 0, '.',',')}},-</td>
   </tr>
   @php 
   $total+=$row['total'];
   @endphp
   @endforeach
   <tr>
      <th colspan="5" style="color:white;">Total</th>
      <td  nowrap><b>Rp. {{number_format($total, 0, '.',',')}},-</b></td>
   </tr>
</tbody>
</table>
</body>
</html> 