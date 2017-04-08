<!DOCTYPE html>
<html lang="en">
    <head>
        <title>TUB-DMP</title>
        <meta charset="utf-8">

        <!-- Startup configuration -->
        <link rel="manifest" href="/manifest.webmanifest">
        <!-- Fallback application metadata for legacy browsers -->
        <meta name="application-name" content="TUB-DMP">

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta http-equiv="Cache-control" content="no-store">
        <meta name="Generator" content="Laravel 5.3" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">

        @section('header_assets')
            <!-- CSS
            ================================================== -->
            {!! HTML::style('css/app.css') !!}
            {!! HTML::style('css/vendor.css') !!}
            {!! HTML::style('css/my.style.css') !!}

                {!! HTML::script('js/jquery.js') !!}
        @show

<style>
* {
    outline: 0px #336699 solid;
}
</style>

</head>

<body>

@include('flash::message')
@include('amaran::javascript')

<!--<header class="navbar navbar-static-top">-->

<header>
    @section('header')
        @include('partials.header')
    @show
</header>

<main class="main">
    <div class="container">

    @section('headline')
        <div class="text-center">
            <h3>Create your Data Management Plan</h3>
        </div>
    @show

    @yield('body')

    </div>
</main>

<footer class="footer">
    <div class="container">
        <div class="text-center">
            &copy; {{ date("Y") }}
            <a href="http://www.szf.tu-berlin.de/" target="_blank">Servicezentrum Forschungsdaten und Publikationen</a>
        </div>
        <div class="text-center">
            <a href="http://www.szf.tu-berlin.de/menue/dienste_tools/datenmanagementplan_tub_dmp/" target="_blank">About TUB-DMP</a> |
            <!--Policy |-->
            <a href="http://www.szf.tu-berlin.de/menue/personen/ansprechpartnerinnen/" target="_blank">Contact</a> |
            <a href="http://www.szf.tu-berlin.de/servicemenue/impressum/" target="_blank">Imprint</a> |
            <a href="http://www.tu-berlin.de/allgemeine_seiten/datenschutz/" target="_blank">Privacy Statement</a>
        </div>
    </div>
</footer>

@if( Auth::check() )
    @include('partials.modal')
@endif


@section('footer_assets')

    <!-- Misc JS
    ================================================== -->

    {!! HTML::script('js/vendor.js') !!}
    {!! HTML::script('js/env.js') !!}
    {!! HTML::script('js/my.jquery.js') !!}


    {{-- HTML::script('https://unpkg.com/vue') --}}
    {{-- HTML::script('js/my.vue.js') --}}

</body>
</html>