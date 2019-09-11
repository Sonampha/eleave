@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card col s12 m12 l12 xl12 mt-20">
                <div>
                <h4 class="center grey-text text-darken-2 card-title">Create New Holiday</h4>
                </div>
                <hr>
                <div class="card-content">
                    <form action="{{route('holidays.store')}}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="year" id="year" value="{{Request::old('year') ? : ''}}">
                                <label for="year">Year</label>
                                <span class="{{$errors->has('year') ? 'helper-text red-text' : ''}}">{{$errors->first('year')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="hol_name" id="hol_name" value="{{Request::old('hol_name') ? : ''}}">
                                <label for="hol_name">Holiday Name</label>
                                <span class="{{$errors->has('hol_name') ? 'helper-text red-text' : ''}}">{{$errors->first('hol_name')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <input type="number" name="day_off" id="day_off" value="{{Request::old('day_off') ? : ''}}">
                                <label for="day_off">Day Off</label>
                                <span class="{{$errors->has('day_off') ? 'helper-text red-text' : ''}}">{{$errors->first('day_off')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="date_from" id="date_from" class="datepicker" value="{{Request::old('date_from') ? : ''}}">
                                <label for="date_from">From</label>
                                <span class="{{$errors->has('date_from') ? 'helper-text red-text' : ''}}">{{$errors->has('date_from') ? $errors->first('date_from') : '' }}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="date_to" id="date_to" class="datepicker" value="{{Request::old('date_to') ? : ''}}">
                                <label for="date_to">To</label>
                                <span class="{{$errors->has('date_to') ? 'helper-text red-text' : ''}}">{{$errors->has('date_to') ? $errors->first('date_to') : '' }}</span>
                            </div>
                        </div>
                        @csrf()
                        <div class="row">
                            <button type="submit" class="btn waves-effect waves-light col s8 offset-s2 m4 offset-m4 l4 offset-l4 xl4 offset-xl4">Add</button>
                        </div>
                    </form>
                </div>
                <div class="card-action">
                    <a href="/holidays">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection