@extends('layouts.app_no_side')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">Report Details</h4>   
    <div class="row">
        <!-- Show All O.T Records List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <!-- Table that shows O.T Records List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>
                                <th>O.T Date</th>
                                <th>Staff Name</th>            
                                <th>From</th>                                
                                <th>To</th> 
                                <th>Minute</th>
                                <th>Reason</th>
                                <th>Remark</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($ot_records->count())
                            @foreach($ot_records as $ot_record)
                                    <tr>
                                        <td>{{$ot_record->ot_date}}</td>
                                        <td>{{$ot_record->staff_name}}</td>
                                        <td>{{$ot_record->time_from}}</td>                
                                        <td>{{$ot_record->time_to}}</td>
                                        <td>{{$ot_record->ot_minute}}</td>
                                        <td>{{$ot_record->otReason->ot_reason}}</td>
                                        <td>{{$ot_record->ot_remark}}</td>
                                        <td>{{$ot_record->ot_type}}</td>
                                    </tr>                            
                            @endforeach
                            @else
                                {{-- if there are no O.T Records then show this message --}}
                                <tr>
                                    <td colspan="5"><h6 class="grey-text text-darken-2 center">No O.T Records Found!</h6></td>
                                </tr>
                            @endif
                            {{-- If we are searching then show this link --}}
                        </tbody>
                    </table>
                    <!-- O.T Records Table END -->
                </div>
                <!-- Show Pagination Links -->

            </div>
        </div>
        <!-- Card END -->
    </div>
</div>
@endsection