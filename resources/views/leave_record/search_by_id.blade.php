@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">Leave by ID</h4>    
    {{-- Search --}}
    <div class="card-panel">
        <div class="row mb-0">
            <form action="leave_by_id" method="POST">
            @csrf()
                <div class="input-field col s6 offset-s1 m6 l6 xl6 offset-xl1">
                    <i class="material-icons prefix">person</i>
                    <input type="text" name="staff_id" id="staff_id" value="{{$staff_id}}">
                    <label for="staff_id">Staff ID</label>
                    <span class="{{$errors->has('staff_id') ? 'helper-text red-text' : ''}}">{{$errors->has('staff_id') ? $errors->first('staff_id') : ''}}</span>
                </div>
                <br>
                <button type="submit" class="btn col s6 offset-s3 m3 l3 xl3 offset-xl1">Search</button>
            </form>
        </div>
    </div>
    {{-- Search END --}}
    
    <div class="row">
        <!-- Show All Leave Records List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <h5 class="pl-15 grey-text text-darken-2">List of Leave Records</h5>
                    <!-- Table that shows Leave Records List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>                                
                                <th>From</th>
                                <th>To</th>
                                <th>Staff Name</th>
                                <th>Staff ID</th>
                                <th>Day-Off</th>
                                <th>Leave Type</th>
                                <th>Status</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($leave_records->count())
                                @foreach($leave_records as $leave_record)
                                    <tr>                                        
                                        <td>{{date("d-M-Y", strtotime($leave_record->date_from))}}</td>
                                        <td>{{date("d-M-Y", strtotime($leave_record->date_to))}}</td>
                                        <td>{{$leave_record->staff_name}}</td>
                                        <td>{{$leave_record->staff_id}}</td>
                                        <td>{{$leave_record->day_off}} {{$leave_record->unit}}</td>
                                        <td>{{$leave_record->leave_type}}</td>
                                        <td>{{$leave_record->status}}</td>
                                        <td>
                                            <div class="row mb-0">
                                                <div class="col">
                                                    <a href="{{route('leave_records.show',$leave_record->id)}}" class="btn btn-small btn-floating waves=effect waves-light teal lighten-2"><i class="material-icons" title="Details">list</i></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>                            
                                @endforeach
                                @else
                                    {{-- if there are no Leave Records then show this message --}}
                                    <tr>
                                        <td colspan="5"><h6 class="grey-text text-darken-2 center">No Leave Records Found!</h6></td>
                                    </tr>
                                @endif
                                {{-- If we are searching then show this link --}}
                        </tbody>
                    </table>
                    <!-- Leave Records Table END -->
                </div>
                <!-- Show Pagination Links -->

            </div>
        </div>
        <!-- Card END -->
    </div>
</div>


<!-- This is the button that is located at the right bottom, that navigates us to leave_records.create view -->
@if(Auth::user()->user_type == "WEB")
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves=effect waves-light red" href="{{route('leave_records.create')}}">
        <i class="large material-icons">add</i>
    </a>
</div> 
@endif

@endsection