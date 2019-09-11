@extends('layouts.app_ot')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">Approve Overtimes</h4>
    
    {{-- Search --}}

    {{-- Search END --}}
    
    <div class="row">
        <!-- Show All O.T Records List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <!-- Table that shows O.T Records List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>
                                <th>Date</th>
                                <th>Staff Name</th>
                                <th>Type</th>                                
                                <th>From</th>
                                <th>To</th>
                                <th>Minute</th>
                                <th>Reason</th>
                                <th>Verified</th>
                                <th>Approved</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($ot_records->count())
                                @foreach($ot_records as $ot_record)
                                    <tr>
                                        <td>{{date("d-M-Y", strtotime($ot_record->ot_date))}}</td>
                                        <td>{{$ot_record->staff_name}}</td>
                                        <td>{{$ot_record->ot_type}}</td>
                                        <td>{{$ot_record->time_from}}</td>
                                        <td>{{$ot_record->time_to}}</td>
                                        <td>{{$ot_record->ot_minute}} mn</td>
                                        <td>{{$ot_record->otReason->ot_reason}}</td>
                                        <td>{{$ot_record->verify_status}}</td>
                                        <td>{{$ot_record->approve_status}}</td> 
                                        <td>
                                            <div class="row mb-0">
                                                <div class="col">
                                                    <a href="{{route('overtime.show',$ot_record->id)}}" class="btn btn-small btn-floating waves=effect waves-light teal lighten-2"><i class="material-icons" title="Details">list</i></a>
                                                </div>
                                                @if(Auth::user()->user_type != "USER")
                                                <div class="col">
                                                    <form action="{{route('overtime.postapprove',$ot_record->id)}}" method="POST">
                                                        @csrf()
                                                        <input type="hidden" id="staff_id" name="staff_id" value="{{$ot_record->staff_id}}" />
                                                        <input type="hidden" id="status" name="status" value="Yes" />
                                                        <button type="submit" title="Approve" class="btn btn-floating btn-small waves=effect waves-light green"><i class="material-icons">done</i></button>
                                                       </form>
                                                </div>                                          
                                                <div class="col">
                                                    <form action="{{route('overtime.rejectapprove',$ot_record->id)}}" method="POST">
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
                                    {{-- if there are no O.T Records then show this message --}}
                                    <tr>
                                        <td colspan="10"><h6 class="grey-text text-darken-2 center">No O.T Records Found!</h6></td>
                                    </tr>
                                @endif
                        </tbody>
                    </table>
                    <!-- O.T Records Table END -->
                </div>
                <!-- Show Pagination Links -->
                <div class="center">
                  {{$ot_records->links('vendor.pagination.default',['paginator' => $ot_records])}}
                </div>
            </div>
        </div>
        <!-- Card END -->
    </div>
</div>
@endsection