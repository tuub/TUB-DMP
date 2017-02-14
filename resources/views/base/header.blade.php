@extends('layouts.bootstrap')

@section('header')

    @if( $layout == 'hybrid' )

        <header class="navbar navbar-inverse navbar-fixed-top">
            <div class="container" style="background-color: #fff; margin: 0; width: 100%; border-bottom: 1px #c50e1f solid;">
                <div class="topbar container">
                    <!-- LOGIN / USER -->
                    <span class="glyphicon glyphicon-user"></span>
                    <a href="/mydspace">Login</a>
                    &nbsp;|&nbsp;
                    <span class="glyphicon glyphicon-comment"></span>
                    <a href="/feedback" id="feedback" target="_blank" class="tooltipstered">
                        Feedback
                    </a>
                </div>
            </div>
        </header>

    @endif


    @if( $layout == 'tub-dmp' )
        <header class="navbar">
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        {!! link_to('/', 'TUB-DMP', array('class' => 'navbar-brand')) !!}
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="nav navbar-nav">
                            @section('navigation')
                                <li>
                                    @if( Auth::check() )
                                        {!! link_to('/my/dashboard', 'Home') !!}
                                    @else
                                        {!! link_to('/', 'Home') !!}
                                    @endif
                                </li>
                                <li><a href="http://www.szf.tu-berlin.de" target="_blank">About / Contact</a></li>
                            @show
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                @if( Auth::check() )
                                    {{-- Auth::user()->real_name --}}
                                    {!! link_to('/logout', 'Logout') !!}
                                @else
                                    {!! link_to('/auth/login', 'Login') !!}
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    @endif

    @if( $layout == 'depositonce' )
        <header class="navbar navbar-inverse navbar-fixed-top">
            <div class="container" style="background-color: #fff; margin: 0; width: 100%; border-bottom: 1px #c50e1f solid;">
                <div class="topbar container">
                    <!-- LOGIN / USER -->
                    <span class="glyphicon glyphicon-user"></span>
                    <a href="/mydspace">Login</a>
                    &nbsp;|&nbsp;
                    <span class="glyphicon glyphicon-comment"></span>
                    <a href="/feedback" id="feedback" target="_blank" class="tooltipstered">
                        Feedback
                    </a>
                </div>
            </div>

            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="http://www.tu-berlin.de/" target="_blank">
                        <img src="/image/logo-tu-nav.png" alt="TU Logo">
                        <!--<img style="height: 25px;" src="/image/logo-do-nav.png" alt="DepositOnce Logo" />-->
                    </a>
                </div>

                <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
                    <ul class="nav navbar-nav">

                        <!-- HOME -->
                        <li class="home text-center active">
                            <a href="/" class="text-center">
                                <span class="glyphicon glyphicon-home"></span><br>
                                Home
                            </a>
                        </li>

                        <!-- SEARCH -->
                        <li class="text-center ">
                            <a href="/simple-search">
                                <span class="glyphicon glyphicon-search"></span><br>Search
                            </a>
                        </li>

                        <!-- BROWSE -->
                        <li class="text-center dropdown ">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-list"></span><br>Browse
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/community-list">Communities<br>&amp;&nbsp;Collections</a></li>
                                <li><a href="/recent">Recent Submissions</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Browse Items by:</li>



                                <li><a href="/browse?type=dateissued">Issue Date</a></li>

                                <li><a href="/browse?type=author">Author</a></li>

                                <li><a href="/browse?type=title">Title</a></li>

                                <li><a href="/browse?type=subject">Subject</a></li>

                                <li><a href="/browse?type=series">Series</a></li>

                                <li><a href="/browse?type=type">Type</a></li>



                                <li class="divider"></li>
                                <li><a href="/subject-search">Subject Search</a></li>


                            </ul>
                        </li>

                        <!-- PUBLISH -->
                        <li class="text-center">
                            <a href="/mydspace">
                                <span class="glyphicon glyphicon-upload"></span><br>Publish
                            </a>
                        </li>

                        <!-- ADMINISTER -->



                    </ul>

                    <div class="nav navbar-nav navbar-right">
                        <ul class="nav navbar-nav navbar-right">



                        </ul>

                    </div>
                </nav>
            </div>

        </header>
    @endif



@stop