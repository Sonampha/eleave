@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card col s12 m12 l12 xl12 mt-20">
                <div>
                <h4 class="center grey-text text-darken-2 card-title">New Leave Record</h4>
                </div>
                <hr>
                <div class="card-content">
                    <form action="{{route(my_leaves.store')}}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" name="staff_id" id="staff_id" value="{{Request::old('staff_id') ? : ''}}">
                                <label for="staff_id">Staff ID</label>
                                <span class="{{$errors->has('staff_id') ? 'helper-text red-text' : ''}}">{{$errors->first('staff_id')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" name="staff_name" id="staff_name" value="{{Request::old('staff_name') ? : ''}}">
                                <label for="staff_name">Staff Name</label>
                                <span class="{{$errors->has('staff_name') ? 'helper-text red-text' : ''}}">{{$errors->first('staff_name')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <select class="validate" id="leave_type" name="leave_type">
                                    <option value="" disabled {{ old('leave_type') ? '' : 'selected' }}>Choose ...</option>
                                    @foreach($leave_types as $leave_type)
                                    <option value="{{ $leave_type->leave_type }}">{{ $leave_type->leave_type }}</option>
                                    @endforeach
                                </select>
                                <label>Leave Type</label>
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
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <input type="number" name="day_off" id="day_off" min="0" max="90" step="0.5" value="{{Request::old('day_off') ? : ''}}">
                                <label for="day_off">Day Off</label>
                                <span class="{{$errors->has('day_off') ? 'helper-text red-text' : ''}}">{{$errors->first('day_off')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <select name="unit">
                                    <option value="" disabled {{ old('unit') ? '' : 'selected' }}>Choose ...</option>                
                                    <option value="AM" {{ old('unit') ? 'selected' : '' }}>AM</option>
                                    <option value="PM" {{ old('unit') ? 'selected' : '' }}>PM</option>
                                    <option value="Full Day" {{ old('unit') ? 'selected' : '' }}>Full Day</option>         
                                </select>
                                <label>Unit</label>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="reason" id="reason" value="{{Request::old('reason') ? : ''}}">
                                <label for="reason">Reason</label>
                                <span class="{{$errors->has('reason') ? 'helper-text red-text' : ''}}">{{$errors->first('reason')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">person_pin</i>
                                <select name="reporting_manager">
                                    <option value="" disabled {{ old('reporting_manager') ? '' : 'selected' }}>Choose ...</option>
                                    @foreach($reporting_managers as $reporting_manager)
                                        <option value="{{$reporting_manager->manager_name}}" {{ old('reporting_manager') ? 'selected' : '' }}>{{$reporting_manager->manager_name}}</option>
                                    @endforeach
                                </select>
                                <label>Reporting Manager</label>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <select name="status">
                                    <option value="" disabled {{ old('status') ? '' : 'selected' }}>Choose ...</option>                
                                    <option value="Approved" {{ old('status') ? 'selected' : '' }}>Approved</option>
                                    <option value="Pending" {{ old('status') ? 'selected' : '' }}>Pending</option>  
                                    <option value="Rejected" {{ old('status') ? 'selected' : '' }}>Rejected</option>      
                                </select>
                                <label>Status</label>
                            </div>                     
                        </div>
                        @csrf()
                        <div class="row">
                            <button type="submit" class="btn waves-effect waves-light col s8 offset-s2 m4 offset-m4 l4 offset-l4 xl4 offset-xl4">Add</button>
                        </div>
                    </form>
                </div>
                <div class="card-action">
                    <a href="/my_leaves">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection