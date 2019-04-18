@extends('layouts.blank')

@section('content')
<div class="text-center">
    <form class="form-signin" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <h1 class="h3 mb-3 font-weight-normal">
            Вход в систему
        </h1>

        <label for="inputEmail" class="sr-only">Логин</label>
        <input type="text" id="login" class="form-control" name="login" value="{{ old('login') }}" placeholder="Логин" required="" autofocus="">

        <label for="inputPassword" class="sr-only">Пароль</label>
        <input type="password" id="password" class="form-control" name="password" placeholder="Пароль" required="">

        <button class="btn btn-lg btn-primary btn-block" type="submit">
            Войти
        </button>

        <p class="mt-5 mb-3 text-muted">© {{ date('Y') }}</p>
    </form>
</div>
{{--<div class="container">--}}
    {{--<div class="row">--}}
        {{--<div class="col-md-8 col-md-offset-2">--}}
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading">Login</div>--}}

                {{--<div class="panel-body">--}}
                    {{--<form class="form-horizontal" method="POST" action="{{ route('login') }}">--}}
                        {{--{{ csrf_field() }}--}}

                        {{--<div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">--}}
                            {{--<label for="login" class="col-md-4 control-label">Login</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required autofocus>--}}

                                {{--@if ($errors->has('login'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('login') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">--}}
                            {{--<label for="password" class="col-md-4 control-label">Password</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="password" type="password" class="form-control" name="password" required>--}}

                                {{--@if ($errors->has('password'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<div class="col-md-8 col-md-offset-4">--}}
                                {{--<button type="submit" class="btn btn-primary">--}}
                                    {{--Login--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            @if ($errors->has('login'))
            csDeliveryNotify('{{ $errors->first('login') }}', 'danger');
            @endif
            @if ($errors->has('password'))
            csDeliveryNotify('{{ $errors->first('password') }}', 'danger');
            @endif
        })
    </script>
@endsection
