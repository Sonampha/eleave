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
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Leave Type :</span><span class="col m8 l8 xl9">{{$attendance_problem->att_status}}</span></p>
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
                @if(Auth::user()->user_type == "WEB")
                <form action="{{route('my_attendances.approve',$attendance_problem->id)}}" method="POST">
                    @csrf()
                    <input type="hidden" id="status" name="status" value="Approved" />
                    <button class="btn green col s3 offset-s2 m3 offset-m2 l3 offset-l2 xl3 offset-xl2" type="submit">Approve</button>
                </form>
                <form action="{{route('my_attendances.reject',$attendance_problem->id)}}" method="POST">
                    @csrf()
                    <input type="hidden" id="status" name="status" value="Rejected" />
                    <button class="btn red col s3 offset-s2 m3 offset-m2 l3 offset-l2 xl3 offset-xl2" type="submit">Reject</button>
                </form>
                @endif
            </div>
        </div>
    </div>
@endsection