@php $versionForStylesAndScripts = '040420191' @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset2('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset2('css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset2('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset2('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset2('css/csDelivery.css') }}?v={{$versionForStylesAndScripts}}" rel="stylesheet">
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
</head>
<body>
@yield('content')

{{--<div class="container-fluid">--}}
    {{--<div class="row">--}}
        {{--<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">--}}
        {{--</main>--}}
    {{--</div>--}}
{{--</div>--}}

<!-- Scripts -->
<script src="{{ asset2('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset2('js/datatables.min.js') }}"></script>
<script src="{{ asset2('js/bootstrap.min.js') }}"></script>
<script src="{{ asset2('js/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset2('js/csDelivery.js') }}"></script>
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
@yield('scripts')
</body>
</html>
