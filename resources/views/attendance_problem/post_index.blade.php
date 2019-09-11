@extends('layouts.app_att')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">Attendance Editor</h4>    
    {{-- Search --}}
    <div class="card-panel">
        <div class="row mb-0">
            <form action="/attendances/attendance_problems" method="POST">
            @csrf()
                <div class="input-field col s10 offset-s1 m4 l4 xl3 offset-xl1">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_from" id="date_from" class="datepicker" value="{{date('M d, Y', strtotime($date_from))}}">
                    <label for="date_from">From</label>
                    <span class="{{$errors->has('date_from') ? 'helper-text red-text' : ''}}">{{$errors->has('date_from') ? $errors->first('date_from') : ''}}</span>
                </div>
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_to" id="date_to" class="datepicker" value="{{date('M d, Y', strtotime($date_to))}}">
                    <label for="date_to">Date To</label>
                    <span class="{{$errors->has('date_to') ? 'helper-text red-text' : ''}}">{{$errors->has('date_to') ? $errors->first('date_to') : ''}}</span>
                </div>
                <br>
                <button type="submit" class="btn col s6 offset-s3 m3 l3 xl3 offset-xl1">Search</button>
            </form>
        </div>
    </div>
    {{-- Search END --}}
    
    <div class="row">
        <!-- Show All Attendance Records List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <!-- Table that shows Attendance Records List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>                                
                                <th>Date</th>                                
                                <th>Staff Name</th>
                                <th>Att Status</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($attendance_problems->count())
                                @foreach($attendance_problems as $attendance_problem)
                                    <tr>                                        
                                        <td>{{date("d-M-Y", strtotime($attendance_problem->att_date))}}</td>
                                        <td>{{$attendance_problem->staff_name}}</td>
                                        <td>{{$attendance_problem->att_status}}</td>
                                        <td>{{$attendance_problem->status}}</td> 
                                        <td>
                                            <div class="row mb-0">
                                                <div class="col">
                                                    <a href="{{route('attendance_problems.show',$attendance_problem->id)}}" class="btn btn-small btn-floating waves=effect waves-light teal lighten-2"><i class="material-icons" title="Details">list</i></a>
                                                </div>
                                                @if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")
                                                <div class="col">
                                                    <a href="{{route('attendance_problems.edit',$attendance_problem->id)}}" class="btn btn-floating btn-small waves=effect waves-light orange" title="Edit"><i class="material-icons">mode_edit</i></a>
                                                </div>
                                                @endif
                                                @if(Auth::user()->user_type == "WEB")                                               
                                                <div class="col">
                                                    <form onsubmit="return confirm('Do you really want to DELETE?');" action="{{route('attendance_problems.destroy',$attendance_problem->id)}}" method="POST">
                                                        @method('DELETE')
                                                        @csrf()
                                                        <button type="submit" class="btn btn-floating btn-small waves=effect waves-light red" title="Delete"><i class="material-icons">delete</i></button>
                                                       </form>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>                            
                                @endforeach
                                @else
                                    {{-- if there are no Attendance Records then show this message --}}
                                    <tr>
                                        <td colspan="5"><h6 class="grey-text text-darken-2 center">No Attendance Records Found!</h6></td>
                                    </tr>
                                @endif
                                {{-- If we are searching then show this link --}}
                        </tbody>
                    </table>
                    <!-- Attendance Records Table END -->
                </div>
                <!-- Show Pagination Links -->

            </div>
        </div>
        <!-- Card END -->
    </div>
</div>


<!-- This is the button that is located at the right bottom, that navigates us to attendance_problems.create view -->
@if(Auth::user()->user_type == "WEB")
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves=effect waves-light red" href="{{route('attendance_problems.create')}}">
        <i class="large material-icons">add</i>
    </a>
</div> 
@endif

@endsection