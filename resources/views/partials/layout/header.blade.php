@section('header')

    {{-- env('APP_ENV') --}}

    <nav class="navbar navbar-default navbar-fixed-top" id="main-navbar">
        <div class="container">
            <a href="/" class="navbar-brand navbar-right">{!! HTML::image('images/logo-dmp.png', 'TUB-DMP', array('class' => 'thumb', 'title' => 'TUB-DMP', 'style' => 'height: 38px; padding-top: 6px;')) !!}</a>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="http://www.tu-berlin.de" target="_blank" class="navbar-brand navbar-right">{!! HTML::image('images/logo-tu.png', 'TU Berlin', array('class' => 'thumb', 'title' => 'TU Berlin', 'style' => 'height: 45px')) !!}</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    @if( Auth::check() )
                        <li>
                            <a href="/"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
                        </li>
                    @endif
                    @if( Auth::check() )
                        <li>
                            <a href="/logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
                        </li>
                    @endif
                    @if( Auth::check() )
                        <li>
                            <a href="#" class="feedback" data-toggle="modal" data-target="#feedback" title="Feedback">
                                <i class="fa fa-comment" aria-hidden="true"></i>Feedback</a>
                            </a>
                        </li>
                    @endif
                    @if( Auth::check() and Auth::user()->is_admin )
                        <li>
                            <a href="/admin"><i class="fa fa-wrench" aria-hidden="true"></i>Admin</a>
                        </li>
                @endif
                </ul>
            </div>
        </div>
    </nav>

@stop