<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <meta name="description" content="">
 <meta name="author" content="">
 <title>Peace Petshop & Grooming</title>
 <!-- Custom fonts for this template-->
 <link href="{{ asset('asset/vendor/fontawesomefree/css/all.min.css')}}" rel="stylesheet" type="text/css">
 <link
 href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,
 800,800i,900,900i"
 rel="stylesheet">
 <!-- Custom styles for this template-->
 <link href="{{ asset('asset/css/sb-admin-2.min.css')}}" rel="stylesheet">
</head>
<body class="bg-gradient-dark">
 <div class="container">
     <!-- Outer Row -->
     <div class="row justify-content-center">
         <div class="col-xl-5 col-lg-12 col-md-9">
             <div class="card o-hidden border-0 shadow-lg my-5">
                 <div class="card-body p-0">
                     <!-- Nested Row within Card Body -->
                     <div class="center">
                         <div class="col-lg-6 d-none d-lg-block "></div>
                         <div class="col-lg-20">
                             <div class="p-5">
                                 <div class="text-center">
                                     <h1 class="h4 text-gray-900 mb-4">Sign Up<br>
                                         <br><img src="{{ asset('asset/img/petshop.PNG')}}" width="160"></h1>
                                     </div>
                                     <form method="POST" action="{{ route('act-register') }}">
                                         @csrf
                                         <div class="form-group">
                                            <label class="control-label">Nama Customer</label>
                                            <input type="text" name="nama" required
                                            class="form-control" autocomplete="off" value="{{old('nama')}}">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Tempat/Tgl. Lahir</label>
                                            <input type="text" name="ttl" required
                                            class="form-control" autocomplete="off" value="{{old('ttl')}}" placeholder="Nama Kota, dd-mm-yyyy">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Jenis Kelamin</label>
                                            <select name="jk" class="form-control">
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Alamat</label>
                                            <input type="text" name="alamat" required
                                            class="form-control" autocomplete="off" value="{{old('alamat')}}">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Email User</label>
                                            <input type="email" name="email" required
                                            class="form-control" autocomplete="off" value="{{old('email')}}">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">No. Hp</label>
                                            <input type="text" name="tlp" required
                                            class="form-control" autocomplete="off" value="{{old('tlp')}}">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Password</label>
                                            <input type="password" name="password" required
                                            class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Konfirmasi Password</label>
                                            <input type="password" name="confirm_password" required
                                            class="form-control">
                                        </div>
                                        <div class="form-group row mb-0">
                                         <div class="col-md-6">
                                             <button type="submit" class="btn btn-primary">
                                                 {{ __('Register') }}
                                             </button>
                                             <a href="{{route('login')}}" class="btn btn-success">
                                                 {{ __('Login') }}
                                             </a>
                                         </div>
                                         </div>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Bootstrap core JavaScript-->
 <script src="{{ asset('asset/vendor/jquery/jquery.min.js')}}"></script>
 <script src="{{ asset('asset/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
 <!-- Core plugin JavaScript-->
 <script src="{{ asset('asset/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
 <!-- Custom scripts for all pages-->
 <script src="{{ asset('asset/js/sb-admin-2.min.js')}}"></script>
