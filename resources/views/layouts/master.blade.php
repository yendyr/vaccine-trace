<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SmartAircraft 2021</title>
    
    @include('layouts.includes._header-script')
    @stack('header-scripts')
</head>
<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            @include('layouts.includes.sidebar')
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    @include('layouts.includes.navbar')
                </nav>
            </div>


            @if (Request::is('dashboard'))
                @yield('content')
            @else
                @yield('page-heading')

                @include('components.breadcrumb')
                <div class="wrapper wrapper-content animated fadeInRight">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            @endif

            <div class="footer d-print-none">
                <strong>Copyright</strong> SmartAircraft.ID &copy; {{ date('Y') }}
            </div>            

            @include('components.toast.toast')
        </div>
    </div>

<script>
    function isJson(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }
</script>
@include('layouts.includes._footer-script')
@stack('footer-scripts')
</body>
</html>