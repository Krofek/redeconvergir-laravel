<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body>
    <div id="app">
        @include('partials.logo')
        @include('partials.navbar')

        @yield('map')

        <div class="container main-container affixer">
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
