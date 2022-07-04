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
      width: 100%;
    }

    table th {
      padding: 4px;
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

    table td {
      text-align: left;
      border-left: 0;
      padding: 4px;
      border: 1px solid black;
      background: white;
    }




  </style>
</head>
<body>
  <h3>Invoice : <small>{{$dataTransaksi[0]->invoice}}</small></h3>
  <table cellspacing="0">
    <!--                  -->
    <tr style="color: white;">
     <th>Data Pengirim</th>
     <th>Data Penerima</th>
   </tr>
   <tr>
     <td>
       <b>Peace Petshop</b><br>
       <b> Alamat :</b> Jl. Galuh Mas Raya IV No.15 Ruko Grand Plaza Barat, Sukaharja, Kec. Karawang Tim., Karawang, Jawa Barat 41361 <br>
       <b>Telepon: </b>(0267) 8407444
     </td>
     <td>
       <b>{{Str::upper($dataTransaksi[0]->customer->nama_cust)}}</b><br>
       <b> Alamat :</b> {{$dataTransaksi[0]->customer->alamat}}<br>
       <b>Telepon: </b>{{$dataTransaksi[0]->customer->no_tlp}}
     </td>
   </tr>
   <tr style="color: white;">
     <th colspan="2">Data Produk</th>
   </tr>
   <tr>
     <td colspan="2">
       <table cellspacing="0">
        @php
        $total=0;
        @endphp
        @foreach ($dataTransaksi as $row)
        <tr>
          <td>{{$row->produk->nama_produk}}</td>
          <td style="text-align:right">{{$row->qty.' x Rp. '.number_format($row->harga_satuan, 0, '.',',')}},-</td>
        </tr>
        @php
        $total += ($row->qty*$row->harga_satuan);
        @endphp
        @endforeach

        <tr>
         <td style="text-align:center"><b>TOTAL</b></td>
         <td style="text-align:right"><b>{{'Rp. '.number_format($total, 0, '.',',')}}</b></td>
         @php
        $total =0;
        @endphp
       </tr>
     </table>
   </td>
 </tr>
</table>
<table cellspacing="0">
   <tr>
   <th colspan="3" style="color:white">Data Pengiriman</th>
 </tr>
 <tr>
   <td width="30%" style="text-align: center;"><b>Kurir</b></td>
   <td width="30%" style="text-align: center;"><b>Jenis</b></td>
   <td width="30%" style="text-align: center;"><b>Biaya Pengiriman</b></td>
 </tr>
 <tr>
   <td style="text-align:center">{{$dataTransaksi[0]->pengiriman}}</td>
   <td></td>
   <td></td>
 </tr>
</table>
</body>
</html> 