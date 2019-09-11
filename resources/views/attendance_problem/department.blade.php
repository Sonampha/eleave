@extends('layouts.app_att')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">Report by Department</h4>    
    {{-- Search --}}
    <div class="card-panel">
        <div class="row mb-0">
            <form action="/attendances/att_by_department" method="POST">
            @csrf()
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <select name="department" id="department">
                        <option value="" disabled {{ old('department') ? '' : 'selected' }}>Choose ...</option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}" {{ old('department') ? 'selected' : '' }} >{{$department->dept_name}}
                        </option>
                        @endforeach
                    </select>
                    <label for="department">Department:</label>
                    <span class="{{$errors->has('department') ? 'helper-text red-text' : ''}}">{{$errors->has('department') ? $errors->first('department') : ''}}</span>
                </div>
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <select name="att_status" id="att_status">
                        <option value="" disabled {{ old('att_status') ? '' : 'selected' }}>Choose ...</option>
                        @foreach($att_statuses as $att_status)
                            <option value="{{$att_status->att_status}}" {{ old('att_status') ? 'selected' : '' }} >{{$att_status->att_status}}
                        </option>
                        @endforeach
                    </select>
                    <label for="att_status">Attendance Status:</label>
                    <span class="{{$errors->has('att_status') ? 'helper-text red-text' : ''}}">{{$errors->has('att_status') ? $errors->first('att_status') : ''}}</span>
                </div>
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_from" id="date_from" class="datepicker" value="{{old('date_from') ? : ''}}">
                    <label for="date_from">From</label>
                    <span class="{{$errors->has('date_from') ? 'helper-text red-text' : ''}}">{{$errors->has('date_from') ? $errors->first('date_from') : ''}}</span>
                </div>
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_to" id="date_to" class="datepicker" value="{{old('date_to') ? : ''}}">
                    <label for="date_to">To</label>
                    <span class="{{$errors->has('date_to') ? 'helper-text red-text' : ''}}">{{$errors->has('date_to') ? $errors->first('date_to') : ''}}</span>
                </div>
                <br>
                <button type="submit" class="btn col s6 offset-s3 m3 l3 xl3">Search</button>
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
                                <th>From</th>
                                <th>Staff Name</th>
                                <th>Department</th>
                                <th>Att Status</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($attendance_problems->count())
                                @foreach($attendance_problems as $attendance_problem)
                                    <tr>                                        
                                        <td>{{date("d-M-Y", strtotime($attendance_problem->att_date))}}</td>
                                        <td>{{$attendance_problem->staff_name}}</td>
                                        <td>{{$attendance_problem->dept_name}}</td>
                                        <td>{{$attendance_problem->att_status}}</td>
                                        <td>{{$attendance_problem->status}}</td> 
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
                <div class="center">
                  {{$attendance_problems->links('vendor.pagination.default',['paginator' => $attendance_problems])}}
                </div>
            </div>
        </div>
        <!-- Card END -->
    </div>
</div>
@endsection