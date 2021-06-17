<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('gate.name', 'Laravel') }} | Dashboard</title>

    <link rel="icon" type="image/png" href="{{ URL::asset('/ico.png') }}">
    <link href="{{ URL::asset('theme/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('theme/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('theme/css/animate.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('theme/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/custom.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('theme/css/login-style.css') }}" rel="stylesheet">
</head>

<body class="img js-fullheight bg-plane">
    <img class="absolute" src="{{URL::asset('theme/img/yems/smartaircraft logo putih.png')}}" alt="">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Welcome to SmartAircraft!</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">Have an account?</h3>
		      	<form action="{{ route('login') }}" class="signin-form" role="form" method="POST">
                    @csrf
		      		<div class="form-group">
                        <input type="text" class="form-control @error('login') is-invalid @enderror" name="login" required autofocus placeholder="username / email">
                        @error('login')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
		      		</div>
                    <div class="form-group">
                        <input id="password-field" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span toggle="#password-field" class="fa fa-fw fa-2x fa-eye field-icon toggle-password"></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
                    </div>

                    <div class="form-group d-md-flex">
                        <div class="w-50">
                            <label class="checkbox-wrap checkbox-primary">Remember Me
                                <input type="checkbox" checked>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="w-50 text-md-right">
                            <a href="#" style="color: #fff">Forgot Password</a>
                        </div>
                    </div>
	          </form>

	          {{-- <p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p>
	          <div class="social d-flex text-center">
	          	<a href="#" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span> Facebook</a>
	          	<a href="#" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span> Twitter</a>
	          </div>
		      </div>
				</div> --}}
			</div>
		</div>
	</section>
    <br>
    <p class="w-100 text-center text-white">Your Aircraft Reliability, Starts Here! One Stop Solutions and Services for Aviation System. <br><a href="https://smartaircraft.id">© {{date('Y')}} Smartaircraft.id</a></p>

    <!-- jQuery -->
    <script src="{{URL::asset('theme/js/jquery.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{URL::asset('theme/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- Main Bootstrap & Theme Engine -->
    <script src="{{URL::asset('theme/js/popper.min.js')}}"></script>
    <script src="{{URL::asset('theme/js/bootstrap.min.js')}}"></script>
    <script src="{{ URL::asset('theme/js/login.js') }}"></script>
</body>
</html>