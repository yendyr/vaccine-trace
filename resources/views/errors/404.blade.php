<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SmartAircraft 2020</title>

    @include('layouts.includes._header-script')

    {{-- jika ada tambahan custom script pada header --}}
    @stack('header-scripts')
</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h1>404</h1>
        <h3 class="font-bold">Page Not Found</h3>

        <div class="error-desc">
            Sorry, but the page you are looking for has note been found. Try checking the URL for error, then hit the refresh button on your browser or try found something else in our app.
            <form class="form-inline m-t justify-content-center" role="form">
                {{-- <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search for page">
                </div> --}}
                {{-- <button type="submit" class="btn btn-primary">Search</button> --}}
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    {{-- <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script> --}}

</body>
@include('layouts.includes._footer-script')

{{-- jika ada tambahan custom script pada footer --}}
@stack('footer-scripts')
</html>