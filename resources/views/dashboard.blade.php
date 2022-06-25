@extends('layouts.layout')
@section('content')
<div class="container">
 <div class="row justify-content-center">
 <div class="col-md-12">
 <div class="card">
 <div class="card-header">Selamat Datang {{ Auth::user()->name }}</div>
 <div class="card-body">
 @if (session('status'))
 <div class="alert alert-success" role="alert">
 {{ session('status') }}
 </div>
 @endif
 <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon rotate-n-0">
                    <img src="{{asset('asset/img/toko.png')}}" width="350">
                    <img src="{{asset('asset/img/kucing.png')}}" width="300">
                    <img src="{{asset('asset/img/petshop.png')}}" width="250">
                    <img src="{{asset('asset/img/grooming.png')}}" width="350">  
                    <img src="{{asset('asset/img/produk.png')}}" width="350">  
                    <img src="{{asset('asset/img/produk2.png')}}" width="350">    
                    <img src="{{asset('asset/img/produk3.png')}}" width="350">        
</div>
 </div>
 </div>
 </div>
 </div>
</div>
@endsection
