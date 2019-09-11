@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card-panel grey-text text-darken-2 mt-20">
            <h4 class="grey-text text-darken-1 center">Leave Details</h4>
            <div class="row">

                <div class="collection">
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Requested Date :</span><span class="col m8 l8 xl9">{{$leave_record->request_date}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Staff ID :</span><span class="col m8 l8 xl9">{{$leave_record->staff_id}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Staff Name :</span><span class="col m8 l8 xl9">{{$leave_record->staff_name}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Leave Type :</span><span class="col m8 l8 xl9">{{$leave_record->leave_type}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">From :</span><span class="col m8 l8 xl9">{{date("d-M-Y", strtotime($leave_record->date_from))}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">To :</span><span class="col m8 l8 xl9">{{date("d-M-Y", strtotime($leave_record->date_to))}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Day-Off :</span><span class="col m8 l8 xl9">{{$leave_record->day_off}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Unit :</span><span class="col m8 l8 xl9">{{$leave_record->unit}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Reason :</span><span class="col m8 l8 xl9">{{$leave_record->reason}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Status :</span><span class="col m8 l8 xl9">{{$leave_record->status}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Reporting Manager :</span><span class="col m8 l8 xl9">{{$leave_record->approver}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Approved Date :</span>
                            <span class="col m8 l8 xl9">{{$leave_record->status_date}}</span></p>
                    </div>
                </div>
                @if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")
                <a class="btn orange col s3 offset-s2 m3 offset-m2 l3 offset-l2 xl3 offset-xl2" href="{{route('leave_records.edit',$leave_record->id)}}">Update</a>
                @endif
                @if(Auth::user()->user_type == "WEB")
                <form onsubmit="return confirm('Do you really want to delete this leave record?');" action="{{route('leave_records.destroy',$leave_record->id)}}" method="POST">
                    @method('DELETE')
                    @csrf()
                    <button class="btn red col s3 offset-s2 m3 offset-m2 l3 offset-l2 xl3 offset-xl2" type="submit">Delete</button>
                </form>
                @endif
            </div>
        </div>
    </div>
@endsection