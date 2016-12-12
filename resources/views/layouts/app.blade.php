<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body>
    <div id="app">
        <div class="navbar navbar-default navbar-fixed-top">
            @include('partials.navbar')
        </div>

        @yield('map')

        <div class="container">
            @section('content')
                {{--Default value--}}
            @show

            <footer>
                @include('partials.footer')
            </footer>
        </div>
    </div>
    @include('partials.scripts')
</body>
</html>