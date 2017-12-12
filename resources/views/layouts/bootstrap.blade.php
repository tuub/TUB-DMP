@section('header')
    @include('partials.layout.header')
@show

<body id="app">

<header>
    @section('navigation')
        @include('partials.layout.navigation')
    @show
</header>

<main class="main">
    <div class="container">
        @section('headline')
            <div class="text-center">
                <h1>{!! HTML::image('images/logo-dmp.png') !!}</h1>
            </div>
        @show
        @yield('body')
    </div>
</main>

@section('footer')
    @include('partials.layout.footer')
@show
