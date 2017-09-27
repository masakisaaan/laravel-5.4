<html>
<head>
    <title>@yield('title')</title>
</head>
<body>
    <h1>@yield('title')</title>
    @section('menubar')
    <ul>
        <p class="menutitle">Menu</p>
        <li>@show</li>
    </ul>
    <hr size="1">
    <div class="content">
    @yield('contents')
    </div>
    <div class="footer">
    @yield('footer')
    </div>
</body>
</html>