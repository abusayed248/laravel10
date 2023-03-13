<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.components.style')
</head>

    <body>
        <div class="sb-nav-fixed">
            @guest

            @else
            @include('layouts.components.topbar')
            <div id="layoutSidenav">
                @include('layouts.components.sidebar')
                @endguest
                <div id="layoutSidenav_content">
                    <main>
                        <div class="container-fluid px-4">
                            @yield('admin_content')
                        </div>
                    </main>
                    
                </div>
            </div>

            @include('layouts.components.script')
        </div>
    </body>
</html>
