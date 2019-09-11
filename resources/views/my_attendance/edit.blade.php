@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card col s12 m12 l12 xl12 mt-20">
                <div>
                <h4 class="center grey-text text-darken-2 card-title">Update Leave Record</h4>
                </div>
                <hr>
                <div class="card-content">
                    <form action="{{route('my_attendances.update',$attendance_problem->id)}}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" name="staff_id" id="staff_id" value="{{Request::old('staff_id') ? : $attendance_problem->staff_id }}">
                                <label for="staff_id">Staff ID</label>
                                <span class="{{$errors->has('staff_id') ? 'helper-text red-text' : ''}}">{{$errors->first('staff_id')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <select name="leave_type">
                                    <option value="" disabled>Choose ...</option>
                                    @foreach($leave_types as $leave_type)
                                        <option value="{{$leave_type->leave_type}}" {{ old('leave_type') ? 'selected' : '' }} {{ $leave_type->leave_type == $attendance_problem->leave_type ? 'selected' : '' }} >{{$leave_type->leave_type}}</option>
                                    @endforeach
                                </select>
                                <label>Leave Types</label>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="date_from" id="date_from" class="datepicker" value="{{Request::old('date_from') ? : $attendance_problem->date_from}}">
                                <label for="date_from">From</label>
                                <span class="{{$errors->has('date_from') ? 'helper-text red-text' : ''}}">{{$errors->has('date_from') ? $errors->first('date_from') : '' }}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="reason" id="reason" value="{{Request::old('reason') ? : $attendance_problem->reason }}">
                                <label for="reason">Reason</label>
                                <span class="{{$errors->has('reason') ? 'helper-text red-text' : ''}}">{{$errors->first('reason')}}</span>
                            </div>
                           <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">person_pin</i>
                                <select name="reporting_manager">
                                    <option value="" disabled>Choose ...</option>
                                    @foreach($reporting_managers as $reporting_manager)
                                        <option value="{{$reporting_manager->manager_name}}" {{ old('reporting_manager') ? 'selected' : '' }} {{ $reporting_manager->manager_name == $attendance_problem->approver ? 'selected' : '' }} >{{$reporting_manager->manager_name}}</option>
                                    @endforeach
                                </select>
                                <label>Approver</label>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <select name="status">
                                    <option value="" disabled >Choose ...</option>
                                    <option value="Approved" {{ $attendance_problem->status=="Approved" ? 'selected' : '' }}>Approved</option>
                                    <option value="Pending" {{ $attendance_problem->status=="Pending" ? 'selected' : '' }}>Pending</option>
                                    <option value="Rejected" {{ $attendance_problem->status=="Rejected" ? 'selected' : '' }}>Rejected</option>                         
                                </select>
                                <label>Status</label>
                            </div>
                        </div>
                        @method('PUT')
                        @csrf()
                        <div class="row">
                            <button type="submit" class="btn waves-effect waves-light col s8 offset-s2 m4 offset-m4 l4 offset-l4 xl4 offset-xl4">Update</button>
                        </div>
                    </form>
                </div>
                <div class="card-action">
                    <a href="/my_attendances">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection