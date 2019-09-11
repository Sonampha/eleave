<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/materialize.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <!-- materialize css icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" href="{{{ asset('uploads/favicon/favicon.ico') }}}">
    <title>HR Management System - O.T</title>
<script language="javascript">
    var win = null;
    function NewWindow(mypage,myname,w,h,scroll){
    LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
    TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
    settings =
    'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
    win = window.open(mypage,myname,settings)
    }
</script>
</head>
<body class="grey lighten-4">
    <!-- 
        This is the default layout that's going to be used in all views
        except for login because i want a login without a navbar
     -->
    <!-- Include Navbar with this layout -->
    @include('inc.navbar-ot')
    <main>
        @yield('content')
    </main>
    <!-- Include Footer -->
    @include('inc.footer')
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/materialize.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <!-- Include the Script after materialize.js is loaded -->
    @include('inc.message')
</body>
</html>