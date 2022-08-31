@extends('layouts.layout')
@section('content') 
<div class="d-sm-flex align-items-center justify-content-between mb-4">
 <h1 class="h3 mb-0 text-gray-800">Data Dikson</h1>
</div><hr>
<div class="card-header py-3" align="right">
 <button class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#modal-add"><i
     class="fa fa-plus"></i>Tambah</button>
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
     <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" cellspacing="0">
             <thead>
                 <tr align="center">
                     <th nowrap>No</th>
                     <th nowrap>Keterangan</th>
                     <th nowrap>Min. Belanja</th>
                     <th>Jumlah</th>
                     <th>Aksi</th>
                 </tr>
             </thead>
             <tbody>
                @php
                $n=1;
                @endphp
                @foreach ($diskon as $row)
                <tr>
                 <td>{{$n++}}</td>
                 <td>{{$row->keterangan}}</td>
                 <td>{{$row->min_belanja}}</td>
                 <td>{{$row->nominal==0?$row->persen.'%':'Rp. '.number_format($row->nominal, 0, '.',',')}}</td>
                 <td>
                    <button data-toggle="modal" data-target="#modal-edit" 
                    onclick="fill_edit('{{$row->id_diskon}}', '{{$row->keterangan}}', '{{$row->min_belanja}}', '{{$row->nominal}}', '{{$row->persen}}')"
                    class="btn btn-sm btn-success shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i>Edit
                </button>
                <a href="/diskon/delete/{{ $row->id_diskon }}" onclick="return confirm('Yakin Ingin menghapus data?')" class="btn btn-sm btn-danger shadow-sm">
                 <i class="fas fa-trash-alt fa-sm text-white-50"></i> Hapus</a>
             </td>
         </tr>
         @endforeach
     </tbody>
 </table>
</div>
</div>
</div>
<!-- modal add data-->
<div class="modal inmodal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
 <div class="modal-dialog modal-xs">
     <div class="modal-content">
         <form name="frm_add" id="frm_add" class="form-horizontal" action="/diskon/insert" method="POST"
         enctype="multipart/form-data">
         @csrf
         <div class="modal-header">
             <h4 class="modal-title">Tambah Data Diskon</h4>
         </div>
         <div class="modal-body">
             <div class="form-group">
                <label class="control-label">Keterangan</label>
                <input type="text" name="keterangan" required
                class="form-control" autocomplete="off" value="{{old('keterangan')}}">
            </div>
            <div class="form-group">
                <label class="control-label">Min. Belanja</label>
                <input type="number" name="min_belanja" required
                class="form-control" autocomplete="off" value="{{old('min_belanja')}}">
            </div>
            <div class="form-group">
                <label class="control-label">Tipe</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="tipe" value="persen" id="tipePersen">
                  <label class="form-check-label" for="tipePersen" required>
                    Persen (%)
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="tipe" value="nominal" id="tipeNominal">
                  <label class="form-check-label" for="tipeNominal" required>
                    Nominal (Rp.)
                  </label>
                </div>
            </div>

        <div class="form-group">
            <input type="number" name="nominal" id="input-add-nominal" 
            class="form-control" style="display: none;" autocomplete="off" value="{{old('nominal')}}">
            <input type="number" name="persen" id="input-add-persen" 
            class="form-control" style="display: none;" autocomplete="off" value="{{old('persen')}}" >
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

<!-- modal edit data-->
<div class="modal inmodal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
 <div class="modal-dialog modal-xs">
  <div class="modal-content">
     <form  id="form-edit" class="form-horizontal" action="/diskon/update" method="POST"
     enctype="multipart/form-data">
     @csrf
     <div class="modal-header">
        <h4 class="modal-title">Edit Data Diskon</h4>
     </div>
    <div class="modal-body">
        <div class="form-group">
                <label class="control-label">Keterangan</label>
                <input type="text" name="keterangan" id="inputKeterangan" required
                class="form-control" autocomplete="off" value="{{old('keterangan')}}">
                <input type="text" name="id_diskon" id="idEdit" hidden>
            </div>
            <div class="form-group">
                <label class="control-label">Min. Belanja</label>
                <input type="number" name="min_belanja" required
                class="form-control" autocomplete="off" id="inputMin_belanja" value="{{old('min_belanja')}}">
            </div>
            <div class="form-group">
                <label class="control-label">Tipe</label>
                <div class="form-check">
                  <input class="form-check-input " type="radio"  name="tipe" id="tipePersenEdit" value="persen" >
                  <label class="form-check-label" for="tipePersenEdit" required>
                    Persen (%)
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input " type="radio" name="tipe" id="tipeNominalEdit" value="nominal" >
                  <label class="form-check-label" for="tipeNominalEdit" required>
                    Nominal (Rp.)
                  </label>
                </div>
            </div>

        <div class="form-group">
            <input type="number" id="inputNominal" name="nominal" 
            class="form-control" style="display: none;" autocomplete="off" value="{{old('nominal')}}">
            <input type="number" id="inputPersen" name="persen"  
            class="form-control" style="display: none;" autocomplete="off" value="{{old('persen')}}" >
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
@section('extra-js')
<script>
    function fill_edit(id,  keterangan, min_belanja, nominal, persen){
        $('#idEdit').val(id)
        $('#inputKeterangan').val(keterangan)
        $('#inputMin_belanja').val(min_belanja)
        $('#inputNominal').val(nominal)
        $('#inputPersen').val(persen)

        if(nominal == null || nominal== 0){
            $('#inputNominal').hide();
            $('#inputPersen').show();
            $('#tipePersenEdit').prop('checked', true)
        }else{
            $('#inputPersen').hide();
            $('#inputNominal').show();
            $('#tipeNominalEdit').prop('checked', true)
        }
        
    }

    $('.form-check-input').on('checked click', function(){
        var tipe = $("[name='tipe']:checked").val()
        console.log(tipe)
        if(tipe=='nominal'){
            $('#input-add-persen').val('').hide();
            $('#input-add-nominal').show();
            $('#inputPersen').val('').hide();
            $('#inputNominal').show();
        }else{
            $('#input-add-nominal').val('').hide();
            $('#input-add-persen').show();
            $('#inputNominal').val('').hide();
            $('#inputPersen').show();
        }
    })

    $('#form-edit').on('submit', function(event){
        var nominal = $('#inputNominal').val()
        var persen = $('#inputPersen').val();
        console.log(nominal == '')
        console.log(persen == '' && nominal == '')
        if(nominal == 0 || nominal == ''){
            if(persen == 0 || persen == '' ){
                event.preventDefault();
                alert(' Persen tidak boleh kosong')
            }
                alert('Nominal  tidak boleh kosong')
        }
    })
</script>
@endsection