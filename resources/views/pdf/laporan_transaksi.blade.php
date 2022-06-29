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
    <h1 align="center">Laporan Transaksi <br><small>{{$tgl}}</small></h1>
    <table cellspacing="0">
        <!--                  -->
        <tr style="color: white;">
           <th>No</th>
           <th>Kode Transaksi</th>
           <th>Kode Produk</th>
           <th>Nama Produk</th>
           <th>Jumlah</th>
           <th>Harga Satuan</th>
           <th>Total</th>
           <th>Waktu</th>
       </tr>
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
</table>
</body>
</html> 