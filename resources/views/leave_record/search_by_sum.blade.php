@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">Leave by Sum</h4>    
    {{-- Search --}}
    <div class="card-panel">
        <div class="row mb-0">
            <form action="leave_by_sum" method="POST">
            @csrf()
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <select name="department" id="department">
                        <option value="" disabled {{ old('department') ? '' : 'selected' }}>Choose ...</option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}" {{ $department->id == 1 ? 'selected' : '' }} >{{$department->dept_name}}
                        </option>
                        @endforeach
                    </select>
                    <label for="department">Department:</label>
                    <span class="{{$errors->has('department') ? 'helper-text red-text' : ''}}">{{$errors->has('department') ? $errors->first('department') : ''}}</span>
                </div>
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <select name="leave_type" id="leave_type">
                        <option value="" disabled {{ old('leave_type') ? '' : 'selected' }}>Choose ...</option>
                        @foreach($leave_types as $leave_type)
                            <option value="{{$leave_type->leave_type}}" {{ $leave_type->leave_field == 'ANN_L' ? 'selected' : '' }} >{{$leave_type->leave_type}}
                        </option>
                        @endforeach
                    </select>
                    <label for="leave_type">Leave Type:</label>
                    <span class="{{$errors->has('leave_type') ? 'helper-text red-text' : ''}}">{{$errors->has('leave_type') ? $errors->first('leave_type') : ''}}</span>
                </div>
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_from" id="date_from" class="datepicker" value="Jan 01, 2019">
                    <label for="date_from">Date From</label>
                    <span class="{{$errors->has('date_from') ? 'helper-text red-text' : ''}}">{{$errors->has('date_from') ? $errors->first('date_from') : ''}}</span>
                </div>
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_to" id="date_to" class="datepicker" value="{{ date("M d, Y") }}">
                    <label for="date_to">Date To</label>
                    <span class="{{$errors->has('date_to') ? 'helper-text red-text' : ''}}">{{$errors->has('date_to') ? $errors->first('date_to') : ''}}</span>
                </div>
                <br>
                <button type="submit" class="btn col s6 offset-s3 m3 l3 xl3">Search</button>
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
                                <th>Staff Name</th>
                                <th>Staff ID</th>
                                <th>Leave Type</th>
                                <th>Entitle Leave</th>
                                <th>Used</th>                                
                                <th>Remain</th>
                                <th>Department</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @if($leave_records->count())
                                @foreach($leave_records as $leave_record)
                                <?php
                                    if($leave_record->leave_type == 'Annual Leave'){
                                        $leave_entitle = $leave_record->ann_leave;
                                     }else{
                                        $leave_entitle = 0;
                                    }
                                ?>
                                    <tr>
                                        <td>
                                        <a href="/leaves/leave_by_id/detail?staff_id={{$leave_record->staff_id}}&type={{$leave_record->leave_type}}" onclick="NewWindow(this.href,'name','1000','500','yes');return false">
                                            {{$leave_record->staff_name}}
                                        </a>
                                        </td>
                                        <td>{{$leave_record->staff_id}}</td>
                                        <td>{{$leave_record->leave_type}}</td>
                                        <td>{{$leave_entitle}}</td>
                                        <td>{{$leave_record->day_off}}</td>       
                                        <td>{{$leave_record->ann_leave - $leave_record->day_off}}</td>
                                        <td>{{$leave_record->dept_name}}</td>    
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
                <div class="center">
                  {{$leave_records->links('vendor.pagination.default',['paginator' => $leave_records])}}
                </div>
            </div>
        </div>
        <!-- Card END -->
    </div>
</div>
@endsection