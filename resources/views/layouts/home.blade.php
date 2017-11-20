@section('header')
    @include('partials.layout.header')
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

<body>

<style>
    body {
        background: url({!! '/images/bg/' . $bg['file'] !!}) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
</style>

<header>
    @section('navigation')
        @include('partials.layout.navigation')
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
    {!! HTML::script('js/vendor.js') !!}
    {!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js') !!}
    {!! HTML::script('js/my.jquery.js') !!}
@show

</body>
</html>
