@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2 card-mt-15">
                <h4 class="center grey-text text-darken-2 card-title">Update Location</h4>
                <div class="card-content">
                    <div class="row">
                        <form action="{{route('locations.update',$location->id)}}" method="POST">
                            <div class="input-field no-margin">
                                <i class="material-icons prefix">place</i>
                                <input type="text" name="location_name" id="location_name" value="{{Request::old('location_name') ? : $location->location_name}}">
                                <label for="location_name">Location Code</label>
                                <span class="{{$errors->has('location_name') ? 'helper-text red-text' : ''}}">{{$errors->first('location_name')}}</span>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">place</i>
                                <input type="text" name="nick_name" id="nick_name" value="{{Request::old('nick_name') ? : $location->nick_name}}">
                                <label for="nick_name">Nick Name</label>
                                <span class="{{$errors->has('nick_name') ? 'helper-text red-text' : ''}}">{{$errors->first('nick_name')}}</span>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">account_balance</i>
                                <input type="text" name="location_address" id="location_address" value="{{Request::old('location_address') ? : $location->location_address}}">
                                <label for="location_address">Location Address</label>
                                <span class="{{$errors->has('location_address') ? 'helper-text red-text' : ''}}">{{$errors->first('location_address')}}</span>
                            </div>
                            @method('PUT')
                            @csrf()
                            <button type="submit" class="btn waves-effect waves-light mt-15 col s6 offset-s3 m4 offset-m4 l4 offset-l4 xl4-offset-xl4">Update</button>
                        </form>
                    </div>
                    <div class="card-action">
                        <a href="/locations">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection