@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card col s12 m12 l12 xl12 mt-20">
                <div>
                <h4 class="center grey-text text-darken-2 card-title">New In Leu Record</h4>
                </div>
                <hr>
                <div class="card-content">
                    <form action="{{route('in_leu_records.store')}}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="inleu_date" id="inleu_date" class="datepicker" value="{{Request::old('inleu_date') ? : ''}}">
                                <label for="inleu_date">Date</label>
                                <span class="{{$errors->has('inleu_date') ? 'helper-text red-text' : ''}}">{{$errors->has('inleu_date') ? $errors->first('inleu_date') : '' }}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" name="staff_id" id="staff_id" value="{{Request::old('staff_id') ? : ''}}">
                                <label for="staff_id">Staff ID</label>
                                <span class="{{$errors->has('staff_id') ? 'helper-text red-text' : ''}}">{{$errors->first('staff_id')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="inleu_day" id="inleu_day" min="0" max="90" step="0.5" value="{{Request::old('inleu_day') ? : ''}}">
                                <label for="inleu_day">In Leu Day</label>
                                <span class="{{$errors->has('inleu_day') ? 'helper-text red-text' : ''}}">{{$errors->first('inleu_day')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">edit</i>
                                <input type="text" name="reason" id="reason" value="{{Request::old('reason') ? : ''}}">
                                <label for="reason">Reason</label>
                                <span class="{{$errors->has('reason') ? 'helper-text red-text' : ''}}">{{$errors->first('reason')}}</span>
                            </div>                   
                        </div>
                        @csrf()
                        <div class="row">
                            <button type="submit" class="btn waves-effect waves-light col s8 offset-s2 m4 offset-m4 l4 offset-l4 xl4 offset-xl4">Add</button>
                        </div>
                    </form>
                </div>
                <div class="card-action">
                    <a href="/in_leu_records">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection