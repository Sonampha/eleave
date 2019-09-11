@extends('layouts.app')
@section('content')
<style>
    .bigcase{text-transform:uppercase;}
</style>
<div class="container">
    <h4 class="grey-text text-darken-2 center">My Pending Leaves</h4>
    
    {{-- Search --}}

    {{-- Search END --}}
    
    <div class="row">
        <!-- Show All Leave Records List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <h5 class="pl-15 grey-text text-darken-2">List of Pending Leaves</h5>
                    <!-- Table that shows Leave Records List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>
                                <th>From</th>
                                <th>To</th>
                                <th>Day-Off</th>
                                <th>Unit</th>
                                <th>Staff Name</th>
                                <th>Leave Type</th>
                                <th>Status</th>
                                <th>Attached</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($leave_records->count())
                                @foreach($leave_records as $leave_record)
                                    <tr>
                                        <td>{{date("d-M-Y", strtotime($leave_record->date_from))}}</td>
                                        <td>{{date("d-M-Y", strtotime($leave_record->date_to))}}</td>
                                        <td>{{$leave_record->day_off}}</td>
                                        <td>{{$leave_record->unit}}</td>
                                        <td>{{$leave_record->staff_name}}</td>
                                        <td>{{$leave_record->leave_type}}</td> 
                                        <td>{{$leave_record->status}}</td>
                                        @if($leave_record->attach_ext == '')
                                        <td>None</td>
                                        @elseif($leave_record->attach_ext == 'pdf')
                                        <td>
                                            <a target="_blank" href="/pdf_attach/attach?file_name={{$leave_record->attach_name}}" class="bigcase">{{$leave_record->attach_ext}}</a>
                                        </td>
                                        @else
                                        <td>
                                            <a target="_blank" href="/image_attach/attach?file_name={{$leave_record->attach_name}}" class="bigcase">{{$leave_record->attach_ext}}</a>
                                        </td>
                                        @endif
                                        <td>
                                            <div class="row mb-0">
                                                <div class="col">
                                                    <a href="{{route('my_leave_tasks.show',$leave_record->id)}}" class="btn btn-small btn-floating waves=effect waves-light teal lighten-2"><i class="material-icons" title="Details">list</i></a>
                                                </div>
                                                @if(Auth::user()->user_type != "USER")
                                                <div class="col">
                                                    <form action="{{route('my_leave_tasks.approve',$leave_record->id)}}" method="POST">
                                                        @csrf()
                                                        <input type="hidden" id="status" name="status" value="Approved" />
                                                        <button type="submit" title="Approve" class="btn btn-floating btn-small waves=effect waves-light green"><i class="material-icons">done</i></button>
                                                       </form>
                                                </div>                                          
                                                <div class="col">
                                                    <form action="{{route('my_leave_tasks.reject',$leave_record->id)}}" method="POST">
                                                        @csrf()
                                                        <input type="hidden" id="status" name="status" value="Rejected" />
                                                        <button type="submit" class="btn btn-floating btn-small waves=effect waves-light red" title="Reject"><i class="material-icons">not_interested</i></button>
                                                       </form>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>                             
                                @endforeach
                                @else
                                    {{-- if there are no Leave Records then show this message --}}
                                    <tr>
                                        <td colspan="8"><h6 class="grey-text text-darken-2 center">No Leave Records Found!</h6></td>
                                    </tr>
                                @endif
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