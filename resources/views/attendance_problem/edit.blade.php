@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card col s12 m12 l12 xl12 mt-20">
                <div>
                <h4 class="center grey-text text-darken-2 card-title">Update Attendance Record</h4>
                </div>
                <hr>
                <div class="card-content">
                    <form action="{{route('attendance_problems.update',$attendance_problem->id)}}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" name="staff_id" id="staff_id" value="{{Request::old('staff_id') ? : $attendance_problem->staff_id }}">
                                <label for="staff_id">Staff ID</label>
                                <span class="{{$errors->has('staff_id') ? 'helper-text red-text' : ''}}">{{$errors->first('staff_id')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" disabled name="staff_name" id="staff_name" value="{{Request::old('staff_name') ? : $attendance_problem->staff_name }}">
                                <label for="staff_name">Staff Name</label>
                                <span class="{{$errors->has('staff_name') ? 'helper-text red-text' : ''}}">{{$errors->first('staff_name')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <select name="att_status">
                                    <option value="" disabled>Choose ...</option>
                                    @foreach($att_statuses as $att_status)
                                        <option value="{{$att_status->att_status}}" {{ old('att_status') ? 'selected' : '' }} {{ $att_status->att_status == $attendance_problem->att_status ? 'selected' : '' }} >{{$att_status->att_status}}</option>
                                    @endforeach
                                </select>
                                <label>Att Status</label>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="att_date" id="att_date" class="datepicker" value="{{Request::old('att_date') ? : $attendance_problem->att_date}}">
                                <label for="att_date">Date</label>
                                <span class="{{$errors->has('att_date') ? 'helper-text red-text' : ''}}">{{$errors->has('att_date') ? $errors->first('att_date') : '' }}</span>
                            </div>                           
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="att_reason" id="att_reason" value="{{Request::old('att_reason') ? : $attendance_problem->att_reason }}">
                                <label for="att_reason">Reason</label>
                                <span class="{{$errors->has('att_reason') ? 'helper-text red-text' : ''}}">{{$errors->first('att_reason')}}</span>
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
                    <a href="/reports/attendance_problems">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection