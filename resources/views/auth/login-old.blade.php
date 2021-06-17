<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('gate.name', 'Laravel') }} | Dashboard</title>

    <link href="{{URL::asset('theme/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('theme/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{URL::asset('theme/css/animate.css')}}" rel="stylesheet">
    <link href="{{URL::asset('theme/css/style.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/custom.css')}}" rel="stylesheet">


</head>
<body class="bg-plane">
    <img class="absolute" src="{{URL::asset('theme/img/yems/smartaircraft logo putih.png')}}" alt="">

    <div class="loginColumns animated fadeInUp">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-welcome">Welcome!</h2>
                <p class="text-left">Your Aircraft Reliability, Starts Here! One Stop Solutions and Services for Aviation System
                </p>
                <p class="text-left">We offer customizability for every aviation industry needs, and every uniqueness processessin your organization. Some country has some different aviation industry regulation
                </p>
            </div>

            <div class="col-md-6">
                <div class="ibox-content">
                    <form class="m-t" role="form" method="POST" action="{{ route('login') }}">
                        @csrf

{{--                        <div class="form-group">--}}
{{--                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="email / username">--}}

{{--                            @error('email')--}}
{{--                            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

                        <div class="form-group">
                            <input type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autofocus placeholder="username / email">
                            @error('login')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

{{--                            <input id="login" type="text" class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"--}}
{{--                                   name="login" value="{{ old('username') ?: old('email') }}" required autofocus placeholder="username / password">--}}

{{--                            @if ($errors->has('username') || $errors->has('email'))--}}
{{--                                <span class="invalid-feedback">--}}
{{--                                        <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>--}}
{{--                                    </span>--}}
{{--                            @endif--}}
                        </div>

                        <div class="form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary block full-width m-b">
                                {{ __('Login') }}
                            </button>
{{--                            @if (Route::has('password.request'))--}}
{{--                                <a href="{{ route('password.request') }}">--}}
{{--                                    <small>Forgot Your Password?</small>--}}
{{--                                </a>--}}
{{--                            @endif--}}
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <hr/>
        <div class="row">
            <div class="col-md-6">
                <a href="#">
                    <small>Term and Conditions</small>
                </a>
            </div>
            <div class="col-md-6 text-right">
                <a href="#">
                    <small>© {{date('Y')}} Smartaircraft.id</small>
                </a>
            </div>
        </div>

    </div>

</body>

</html>

