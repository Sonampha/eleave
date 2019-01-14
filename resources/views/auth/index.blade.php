@extends('layouts.auth')
@section('content')
<section>
    <div class="container row">
        <div class="col m6 offset-m3 l6 offset-l3 xl4 offset-xl4 s10 offset-s1 card card-login z-depth-4">
            <div class="card-title card-title-login gradient-bg lighten-2 black-text">
                <h5 class="center flow-text">Login to E-Leave</h5>
            </div>
            <div class="card-content">
                <form action="{{ route('auth.authenticate') }}" method="POST">
                    <div class="input-field">
                        <i class="material-icons prefix">mail</i>
                        <input type="text" name="username" id="username" class="validate" value="{{ old('username') ? : '' }}">
                        <label for="username">Username</label>
                        <span class="{{$errors->has('username') ? 'helper-text red-text' : '' }}">{{$errors->has('username') ? $errors->first('username') : '' }}</span>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">lock</i>
                        <input type="password" name="password" id="password">
                        <label for="password">Password</label>
                        <span class="{{$errors->has('password') ? 'helper-text red-text' : '' }}">{{$errors->has('password') ? $errors->first('password') : '' }}</span>
                    </div>
                    @csrf()
                    <p>
                        <label for="remember">
                            <input type="checkbox" id="remember" name="remember" />
                            <span>Remember Me</span>
                        </label>
                    </p>
                    <a href="{{route('password.request')}}" class="right">Forgot Password</a>
                    <br>
                    <div class="card-action">
                        <button class="btn col s12 m12 l12 xl12" type="submit" name="submit">Login</button>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection