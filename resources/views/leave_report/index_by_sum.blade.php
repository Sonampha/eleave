@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">Leave by Sum</h4>    
    {{-- Search --}}
    <div class="card-panel">
        <div class="row mb-0">
            <form action="report_by_sum" method="POST">
            @csrf()
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <select name="leave_type">
                        <option value="" disabled>Choose ...</option>
                        @foreach($leave_types as $leave_type)
                            <option value="{{$leave_type->leave_type}}" {{ $leave_type->leave_type == $leftype ? 'selected' : '' }}>{{$leave_type->leave_type}}</option>
                        @endforeach
                    </select>
                    <label for="leave_type">Leave Type:</label>
                    <span class="{{$errors->has('leave_type') ? 'helper-text red-text' : ''}}">{{$errors->has('leave_type') ? $errors->first('leave_type') : ''}}</span>
                </div>
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_from" id="date_from" class="datepicker" value="{{$date_from}}">
                    <label for="date_from">Date From</label>
                    <span class="{{$errors->has('date_from') ? 'helper-text red-text' : ''}}">{{$errors->has('date_from') ? $errors->first('date_from') : ''}}</span>
                </div>
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_to" id="date_to" class="datepicker" value="{{$date_to}}">
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
                                <th>Leave Entitle</th>
                                <th>Used</th>                                
                                <th>Remain</th> 
                                <th>Department</th>                               
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($leave_records->count())
                            @foreach($leave_records as $leave_record)
                            <?php
                                if($leave_record->leave_type == 'Annual Leave'){
                                    $leave_entitle = $leave_record->ann_leave;
                                }elseif($leave_record->leave_type == 'Sick Leave'){
                                    $leave_entitle = $leave_record->sick_leave;
                                }elseif($leave_record->leave_type == 'Carry Forward'){
                                    $leave_entitle = $leave_record->carry_leave;
                                }elseif($leave_record->leave_type == 'Special Leave'){
                                    $leave_entitle = $leave_record->spec_leave;
                                }elseif($leave_record->leave_type == 'Unpaid Leave'){
                                    $leave_entitle = $leave_record->unp_leave;
                                }elseif($leave_record->leave_type == 'Maternity Leave'){
                                    $leave_entitle = $leave_record->mat_leave;
                                }elseif($leave_record->leave_type == 'Hospitalization Leave'){
                                    $leave_entitle = $leave_record->hop_leave;
                                }elseif($leave_record->leave_type == 'Leave in Leu'){
                                    $leave_entitle = 0;
                                }else{
                                    $leave_entitle = 0;
                                }
                                ?>
                                    <tr>
                                        <td>
                                        <a href="/my_reports/report_by_id/detail?staff_id={{$leave_record->staff_id}}&type={{$leave_record->leave_type}}" onclick="NewWindow(this.href,'name','1000','500','yes');return false">
                                            {{$leave_record->staff_name}}
                                        </a>
                                        </td>
                                        <td>{{$leave_record->staff_id}}</td>
                                        <td>{{$leave_record->leave_type}}</td>
                                        <td>{{$leave_entitle}}</td>
                                        <td>{{$leave_record->day_off}}</td> 
										<td>{{$leave_entitle - $leave_record->day_off}}</td>
                                        <td>{{$leave_record->dept_name}}</td>    
                                        <td>{{$leave_record->status}}</td> 
                                    </tr>                            
                            @endforeach
                            @else
                                {{-- if there are no Leave Records then show this message --}}
                                <tr>
                                    <td colspan="8"><h6 class="grey-text text-darken-2 center">No Leave Records Found!</h6></td>
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
@endsection