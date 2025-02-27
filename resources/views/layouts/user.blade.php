
<!DOCTYPE html>
<html lang="en">

<head>

    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="gf7BpFRsO6rkfYMrxgI87twzNaKiwOkdXY8JsIDO">

    
    <title> @yield('title') </title>

    
    
    
                            <link rel="stylesheet" href="/adminlte/fontawesome-free/css/all.min.css">
                <link rel="stylesheet" href="/adminlte/overlayScrollbars/css/OverlayScrollbars.min.css">
                <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">

                                    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
                            
    
    
  @yield('css')

    
</head>

<body class="sidebar-mini" >

    
        <div class="wrapper">

        
                    <div class="preloader flex-column justify-content-center align-items-center" style="">

    
        
        <img src="/adminlte/dist/img/AdminLTELogo.png"
             class="img-circle animation__shake"
             alt="AdminLTE Preloader Image"
             width="60"
             height="60"
             style="animation-iteration-count:infinite;">

    
</div>
        
        
                    <nav class="main-header navbar
    navbar-expand
    navbar-white navbar-light">

    
    <ul class="navbar-nav">
        
        <li class="nav-item">
    <a class="nav-link" data-widget="pushmenu" href="#"
                        >
        <i class="fas fa-bars"></i>
        <span class="sr-only">Toggle navigation</span>
    </a>
</li>
        
        
        
            </ul>

    
    <ul class="navbar-nav ml-auto">
        
        
        
        
        
                                    <li class="nav-item dropdown user-menu">

    
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <span >
            {{ \Auth::user()->name }}
        </span>
    </a>

    
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        
                            
        
        
        
        
        
        <li class="user-footer">
                        <a class="btn btn-default btn-flat float-right  btn-block"
               href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-fw fa-power-off text-red"></i>
                Log Out
            </a>
            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                @csrf

            </form>
        </li>

    </ul>

</li>
                    
        
            </ul>

</nav>
        
        
                    <aside class="main-sidebar sidebar-dark-primary elevation-4">

    
            <a href="/dashboard"
            class="brand-link "
    >

    
    {{-- <img src="/adminlte/dist/img/AdminLTELogo.png"
         alt="Admin Logo"
         class="brand-image img-circle elevation-3"
         style="opacity:.8"> --}}
      
    
    <span class="brand-text font-weight-light ">
        <b>Thulasi</b>
    </span>

</a>
    
    
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column "
                data-widget="treeview" role="menu"
                                >
                
                                <li  class="nav-header ">

                                    SETTINGS
       
                               </li>
                               <li  class="nav-item">
                                   <a class="nav-link  " href="/orders"        >
                                       <i class="fas fa-fw fa-store "></i>
                                       <p> Orders </p>
                                   </a>
       
                               </li>
                               <li  class="nav-item">
                                   <a class="nav-link  " href="/shops"        >
                                       <i class="fas fa-fw fa-store "></i>
                                       <p> Shops </p>
                                   </a>
       
                               </li>
            </ul>
        </nav>
    </div>

</aside>
        
        
<div class="content-wrapper">

    
        <div class="content-header">
            <div class="container-fluid">
                @yield('content_header')
            </div>
        </div>
    
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

</div>
        
        
        
        
        
    </div>

    
                            <script src="/adminlte/jquery/jquery.min.js"></script>
                <script src="/adminlte/bootstrap/js/bootstrap.bundle.min.js"></script>
                <script src="/adminlte/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
                <script src="/adminlte/dist/js/adminlte.min.js"></script>
            
    
                @yield('js')


</body>

</html>
