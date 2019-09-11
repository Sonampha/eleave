@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card-panel grey-text text-darken-2 mt-20">
            <h4 class="grey-text text-darken-1 center">Leave Details</h4>
            <div class="row">

                <div class="collection">
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Date :</span><span class="col m8 l8 xl9">{{$in_leu->inleu_date}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Staff Name :</span><span class="col m8 l8 xl9">{{$in_leu->staff_name}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Staff ID :</span><span class="col m8 l8 xl9">{{$in_leu->staff_id}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">In Leu Day :</span><span class="col m8 l8 xl9">{{$in_leu->inleu_day}}</span></p>
                    </div>
                    <div class="row">
                        <p class="pl-15"><span class="bold col s5 m4 l4 xl3">Reason :</span><span class="col m8 l8 xl9">{{$in_leu->reason}}</span></p>
                    </div>
                </div>
                @if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")
                <a class="btn orange col s3 offset-s2 m3 offset-m2 l3 offset-l2 xl3 offset-xl2" href="{{route('in_leu_records.edit',$in_leu->id)}}">Update</a>
                @endif
                @if(Auth::user()->user_type == "ADMIN")
                <form onsubmit="return confirm('Do you really want to DELETE?');" action="{{route('in_leu_records.destroy',$in_leu->id)}}" method="POST">
                    @method('DELETE')
                    @csrf()
                    <button class="btn red col s3 offset-s2 m3 offset-m2 l3 offset-l2 xl3 offset-xl2" type="submit">Delete</button>
                </form>
                @endif
            </div>
        </div>
    </div>
@endsection