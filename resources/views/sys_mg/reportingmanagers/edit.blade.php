@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2 card-mt-15">
                <h4 class="center grey-text text-darken-2 card-title">Update Reporting Manager</h4>
                <div class="card-content">
                    <div class="row">
                        <form action="{{route('reportingmanagers.update',$reportingmanager->id)}}" method="POST">
                            <div class="input-field">
                                <i class="material-icons prefix">person_pin</i>    
                                <input type="text" name="manager_name" id="manager_name" value="{{Request::old('manager_name') ? : $reportingmanager->manager_name}}">
                                <label for="manager_name">Manager Name</label>
                                <span class="{{$errors->has('manager_name') ? 'helper-text red-text' : ''}}">{{$errors->first('manager_name')}}</span>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">mail</i>
                                <input type="email" name="email" id="email" class="validate" value="{{Request::old('email') ? : $reportingmanager->email}}">
                                <label for="email">Email</label>
                                <span class="{{$errors->has('email') ? 'helper-text red-text' : '' }}">{{$errors->first('email')}}</span>
                            </div>
                            @method('PUT')
                            @csrf()
                            <button type="submit" class="btn waves-effect waves-light col s6 offset-s3 m4 offset-m4 l4 offset-l4 xl4-offset-xl4">Update</button>
                        </form>
                    </div>
                    <div class="card-action">
                        <a href="/reportingmanagers">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection