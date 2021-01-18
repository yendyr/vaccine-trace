<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SmartAircraft 2020</title>
    {{-- jika ada tambahan custom script pada header --}}
    @stack('header-scripts')
    @include('layouts.includes._header-script')
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

            {{-- membaca request http sesuai route --}}
            @if (Request::is('dashboard'))
                @yield('content')
            @else
                @yield('page-heading')

                @include('components.breadcrumb')
                <div class="wrapper wrapper-content animated fadeInRight">
                    @yield('content')
                </div>
            @endif

            <div class="footer">
                <div>
                    <strong>Copyright</strong> SmartAircraft.ID &copy; {{ date('Y') }}
                </div>
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
    {{-- jika ada tambahan custom script pada footer --}}
    @stack('footer-scripts')
</body>
</html>