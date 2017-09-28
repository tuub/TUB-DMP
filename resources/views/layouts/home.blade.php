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
            {!! HTML::script('js/jquery.min.js') !!}
            {!! HTML::script('js/toastr.min.js') !!}

        @show

        @php
            $bgs = [
                [
                    'file' => 'calculator-scientific.opt.jpg',
                    'source' => 'https://www.pexels.com/photo/scientific-calculator-ii-5775/',
                ],
                [
                    'file' => 'pexels-photo-209137.opt.jpg',
                    'source' => 'https://pixabay.com/en/lost-places-office-broken-1730892/',
                ],
                [
                    'file' => 'survey-opinion-research-voting-fill-159353.opt.jpg',
                    'source' => 'https://pixabay.com/en/survey-opinion-research-voting-fill-1594962/',
                ],
                [
                    'file' => 'pexels-photo-442574.opt.jpg',
                    'source' => 'https://www.pexels.com/photo/apple-blank-business-computer-442574/',
                ],
                [
                    'file' => 'pexels-photo-267582.opt.jpg',
                    'source' => 'https://pixabay.com/en/tax-paperwork-accounting-business-739107/',
                ],
                [
                    'file' => 'study-pen-school-notebook-80378.opt.jpg',
                    'source' => 'https://stock.tookapic.com/photos/27607',
                ],
            ];

            $bg = $bgs[array_rand($bgs, 1)];
        @endphp

<style>

body {
    background: url({!! '/images/bg/' . $bg['file'] !!}) no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}

* {
    outline: 0px #336699 solid;
}

h1.page-header {
    padding: 5px;
    background-color: #fff;
    display: inline-block;
    border-radius: 2px;
}

h1.page-header * { display: block }

.toast {
    opacity: 1 !important;
    margin-top: 55px !important;
}
</style>

<script>
$(document).ready(function(){

    toastr.options = {
        'positionClass': 'toast-top-right',
        'preventDuplicates': true,
        'timeOut': 2000,
        'fadeOut': 1500,
        'fadeIn': 1500
    };

    @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch (type) {
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;

            default:
                toastr.info("{{ Session::get('message') }}");
                break;
        }
    @endif
});
</script>

</head>

<body>

@include('flash::message')
<!--<header class="navbar navbar-static-top">-->

<header>
    @section('header')
        @include('partials.header')
    @show
</header>

<main class="main">
    <div class="container">
        <!--<div class="row" style="background-color: #fff; padding: 10px; border-radius: 5px;">-->
            @section('headline')
                <div class="text-center">
                    <h1>{!! HTML::image('images/logo-dmp.png') !!}</h1>
                </div>
            @show
            @yield('body')
        <!--</div>-->
    </div>
</main>

<footer class="footer">
    <div class="container">
        <div class="text-center">
            &copy; {{ date("Y") }}
            {{ HTML::link('http://www.szf.tu-berlin.de/', trans('general.footer.link-01'), ['target' => '_blank']) }}
        </div>
        <div class="text-center">
            {{ HTML::link('http://www.szf.tu-berlin.de/menue/dienste_tools/datenmanagementplan_tub_dmp/', trans('general.footer.link-02'), ['target' => '_blank']) }}
            |
            {{ HTML::link('http://www.szf.tu-berlin.de/menue/personen/ansprechpartnerinnen/', trans('general.footer.link-03'), ['target' => '_blank']) }}
            |
            {{ HTML::link('http://www.szf.tu-berlin.de/servicemenue/impressum/', trans('general.footer.link-04'), ['target' => '_blank']) }}
            |
            {{ HTML::link('http://www.tu-berlin.de/allgemeine_seiten/datenschutz/', trans('general.footer.link-05'), ['target' => '_blank']) }}
            |
            {{ HTML::link($bg['source'], trans('general.footer.link-06'), ['target' => '_blank']) }}
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
    {!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js') !!}
    {!! HTML::script('js/my.jquery.js') !!}


    {{-- HTML::script('https://unpkg.com/vue') --}}
    {{-- HTML::script('js/my.vue.js') --}}

</body>
</html>