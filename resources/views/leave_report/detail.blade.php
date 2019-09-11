@extends('layouts.app_no_side')
@section('content')
<style>
    .right_bold{
        text-align: right; 
        font-weight: bold;
    }
    td, th {
        padding: 7px 5px;
    }
</style>
<div class="container">      
    <div class="row" id="printArea">
        <h6 class="grey-text text-darken-2 center">Leave Details</h6> 
        <!-- Show All O.T Records List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                  <div class="col s4"><b>Staff Name:</b> {{$staff_info->staff_name}}</div>
                  <div class="col s2"><b>ID:</b> {{$staff_info->staff_id}}</div>
                  <div class="col s4"><b>Function:</b> {{$staff_info->function_name}}</div>
                  <div class="col s2"><b>Location:</b> {{$staff_info->location_name}}</div>
                </div>
                <div class="row">
                    <!-- Table that shows O.T Records List -->
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
                        <?php $total = 0; ?>
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
                                <?php $total += $leave_record->day_off;?>       
                            @endforeach                        
                            @if($total != 0)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="right_bold">Total:</td>
                                    <td>{{ $total }}</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endif
                        @endif
                        </tbody>
                    </table>
                    <!-- O.T Records Table END -->
                </div>
                <!-- Show Pagination Links -->

            </div>
        </div>
        <!-- Card END -->        
    </div>
    <a href="/my_reports/report/xlsx?staff_id={{$leave_record->staff_id}}&type={{$leave_record->leave_type}}" class="btn cyan darken-4" style="text-transform: capitalize;">Export Excel</a>
    <a class="btn cyan darken-4" style="text-transform: capitalize;" onclick="printDiv('printArea')">Print</a>
</div>


<script>
  function printDiv(divName) {
       var printContents = document.getElementById(divName).innerHTML;
       var originalContents = document.body.innerHTML;

       document.body.innerHTML = printContents;
       window.print();
       document.body.innerHTML = originalContents;
  }
</script>
@endsection