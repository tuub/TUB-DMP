@extends('layouts.home')

@section('body')

    <style type="text/css">
        body {
            font-family: sans-serif;
        }
        form {
            color: grey;
        }
        div.login-box {
            background-color: #fff;
            margin: 10px auto;
            width: 100%;
            border: 1px solid grey;
            border-radius: 5px;
            padding: 10px;
            max-width: 400px;
            min-width: 300px;
        }
        .title {
            text-align: center;
            font-weight: 200;
            color: grey;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #cdcdcd;
        }
        input[type="submit"] {
            padding: 10px;
            border: 1px solid #cdcdcd;
            border-radius: 5px;
            background-color: #fff;
            min-width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #cdcdcd;
            cursor: pointer;
        }
    </style>

    <div class="login-box">
        <h2 class="title">Demo-Login</h2>
        <form action="" method="post" id="demo-login-form">
            <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
            <strong class="text-danger">{{ $error or '' }}</strong>
            <p>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" />
            </p>
            <p>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" />
            </p>
            <p>
                <input type="submit" value="Login">
            </p>
        </form>
    </div>

    @if (env('DEMO_MODE'))
        @include('partials.layout.demosystem.login-info')
    @endif

@stop
