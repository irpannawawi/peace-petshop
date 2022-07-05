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

       background: #e3e3e3; 
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
   <h1 align="center">Jurnal<br><small>{{$tgl}}</small></h1>
<table class="table table-bordered" width="100%" cellspacing="0">
                    <!--                  -->
                     <tr align="center">
                         <th>No</th>
                         <th>Tanggal</th>
                         <th>Produk/Akun</th>
                         <th>Debit</th>
                         <th>Kredit</th>
                     </tr>
                    @php
                    $n=1;
                    @endphp
                    @foreach ($transaksi as $row)
                    <tr>
                        <th rowspan="3" >{{$n++}}</th>
                        <th rowspan="3" nowrap>{{Str::limit($row->tanggal, 10, $end='')}}</th>
                        <th colspan="3">{{$row->produk->nama_produk}}</th>
                    </tr>
                    @foreach($row->jurnal as $jr)
                    <tr>
                        <td style="padding-left:30px;">{{$jr->akun->nama_akun}}</td>
                        <td>Rp. {{number_format($jr->debit, 0, '.',',')}},-</td>
                        <td>Rp. {{number_format($jr->kredit, 0, '.',',')}},-</td>
                    </tr>
                 @endforeach
                 @endforeach
         </table>
</body>
</html> 