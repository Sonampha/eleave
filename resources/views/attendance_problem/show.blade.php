@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card-panel grey-text text-darken-2 mt-20">
            <h4 class="grey-text text-darken-1 center">Attendance Details</h4>
            <div class="row">

                <div class="collection">
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Requested Date :</span><span class="col m8 l8 xl9">{{$attendance_problem->request_date}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Staff ID :</span><span class="col m8 l8 xl9">{{$attendance_problem->staff_id}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Staff Name :</span><span class="col m8 l8 xl9">{{$attendance_problem->staff_name}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Att Status :</span><span class="col m8 l8 xl9">{{$attendance_problem->att_status}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Date :</span><span class="col m8 l8 xl9">{{date("d-M-Y", strtotime($attendance_problem->att_date))}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Reason :</span><span class="col m8 l8 xl9">{{$attendance_problem->att_reason}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Status :</span><span class="col m8 l8 xl9">{{$attendance_problem->status}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Reporting Manager :</span><span class="col m8 l8 xl9">{{$attendance_problem->approver}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Approved Date :</span>
                            <span class="col m8 l8 xl9">{{$attendance_problem->status_date}}</span></p>
                    </div>
                </div>
                @if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")
                <a class="btn orange col s3 offset-s2 m3 offset-m2 l3 offset-l2 xl3 offset-xl2" href="{{route('attendance_problems.edit',$attendance_problem->id)}}">Update</a>
                @endif
                @if(Auth::user()->user_type == "WEB")
                <form onsubmit="return confirm('Do you really want to delete this attendance record?');" action="{{route('attendance_problems.destroy',$attendance_problem->id)}}" method="POST">
                    @method('DELETE')
                    @csrf()
                    <button class="btn red col s3 offset-s2 m3 offset-m2 l3 offset-l2 xl3 offset-xl2" type="submit">Delete</button>
                </form>
                @endif
            </div>
        </div>
    </div>
@endsection