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
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/csDelivery.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
</head>
<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>

    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link"
               href="{{ route('logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();"
            >Выйти</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
</nav>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    @role('root')
                    <li class="nav-item">
                        <a class="nav-link @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'adminUsers') active @endif" href="{{ route('adminUsers') }}">
                            Управление пользователями
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'catalogs.branches') active @endif" href="{{ route('catalogs.branches') }}">
                            Справочники филиалов
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'catalogs.cities') active @endif" href="{{ route('catalogs.cities') }}">
                            Справочники городов
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'catalogs.counties') active @endif" href="{{ route('catalogs.counties') }}">
                            Справочники районов
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'adminUsersRoles') active @endif" href="{{ route('adminUsersRoles') }}">
                            Управление ролями
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'products') active @endif" href="{{ route('products') }}">
                            Продукты
                        </a>
                    </li>
                    <hr>
                    @endrole
                    <li class="nav-item">
                        <a class="nav-link @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'deliveryCompanies') active @endif" href="{{ route('deliveryCompanies') }}">
                            Курьерские компании
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'deliveryUsers') active @endif" href="{{ route('deliveryUsers') }}">
                            Курьеры
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item">
                        <a class="nav-link @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'deliveryOrders.setCourier') active @endif" href="{{ route('deliveryOrders.setCourier') }}">
                            Досье принято
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(\Illuminate\Support\Facades\Route::currentRouteName() == 'deliveryOrders') active @endif" href="{{ route('deliveryOrders') }}">
                            Заявки
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            @yield('content')
        </main>
    </div>
</div>
    {{--<div id="app">--}}
        {{--<nav class="navbar navbar-default navbar-static-top">--}}
            {{--<div class="container">--}}
                {{--<div class="navbar-header">--}}

                    {{--<!-- Collapsed Hamburger -->--}}
                    {{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">--}}
                        {{--<span class="sr-only">Toggle Navigation</span>--}}
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                    {{--</button>--}}

                    {{--<!-- Branding Image -->--}}
                    {{--<a class="navbar-brand" href="{{ url('/') }}">--}}
                        {{--{{ config('app.name', 'Laravel') }}--}}
                    {{--</a>--}}
                {{--</div>--}}

                {{--<div class="collapse navbar-collapse" id="app-navbar-collapse">--}}
                    {{--<!-- Left Side Of Navbar -->--}}
                    {{--<ul class="nav navbar-nav">--}}
                        {{--&nbsp;--}}
                    {{--</ul>--}}

                    {{--<!-- Right Side Of Navbar -->--}}
                    {{--<ul class="nav navbar-nav navbar-right">--}}
                        {{--<!-- Authentication Links -->--}}
                        {{--@if (Auth::guest())--}}
                            {{--<li><a href="{{ route('login') }}">Login</a></li>--}}
                            {{--<li><a href="{{ route('register') }}">Register</a></li>--}}
                        {{--@else--}}
                            {{--<li class="dropdown">--}}
                                {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
                                    {{--{{ (Auth::user()->name) ? Auth::user()->name : Auth::user()->login }} <span class="caret"></span>--}}
                                {{--</a>--}}

                                {{--<ul class="dropdown-menu" role="menu">--}}
                                    {{--<li>--}}
                                        {{--<a href="{{ route('logout') }}"--}}
                                            {{--onclick="event.preventDefault();--}}
                                                     {{--document.getElementById('logout-form').submit();">--}}
                                            {{--Logout--}}
                                        {{--</a>--}}

                                        {{--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
                                            {{--{{ csrf_field() }}--}}
                                        {{--</form>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                        {{--@endif--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</nav>--}}

        {{--@yield('content')--}}
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
