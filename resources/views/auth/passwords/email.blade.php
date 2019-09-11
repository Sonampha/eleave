@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="card"> 
            <div class="col m6 offset-m3 l6 offset-l3 xl4 offset-xl4 s10 offset-s1 card card-login z-depth-4">
                <div class="card-title card-title-login gradient-bg lighten-2 black-text">
                    <h5 class="center flow-text">Enter Email</h5>
                </div>
                <div class="card-content">
                    @if(session('status'))
                        <div class="card-panel green lighten-4 green-text text-darken-4">{{session('status')}}</div>
                    @endif
                    <form method="post" action="{{route('password.email')}}">
                        @csrf
                        <div class="input-field">
                            <input type="text" name="email" id="email">
                            <label for="email">Email</label>
                            @if($errors->has('email'))
                                <span class="helper-text red-text">{{$errors->first('email')}}</span>
                            @endif
                        </div>

                        <div class="card-action">
                            <button style="background-color: #FFCC00;" class="btn col s12 m12 l12 xl12 waves-effect waves-light gradient-bg black-text" type="submit" name="submit">Send Link</button>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
