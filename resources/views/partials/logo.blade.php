@if(ViewHelper::showWideNavbar())
    <div class="logo-wrapper affixer">
        <div class="logo-wrapper-overlay">
            <a href="/" class="container">
                <div class="logo-circle-wrapper">
                    <span class="logo-curved-brace"></span>
                    {{--<span class="logo-circle">--}}
                    {{--<span class="logo"></span>--}}
                    {{--</span>--}}
                </div>
                <div class="logo-title-wrapper">
                    <h1>{{ config('website.name') }}</h1>
                </div>
            </a>
        </div>
    </div>
@endif