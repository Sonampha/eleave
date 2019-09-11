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
		<h6 class="grey-text text-darken-2 center">O.T Report Details</h6> 
        <!-- Show All O.T Records List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                  <div class="col s3"><b>Staff Name:</b> {{$ot_person->staff_name}}</div>
                  <div class="col s2"><b>ID:</b> {{$ot_person->staff_id}}</div>
                  <div class="col s5"><b>Function:</b> {{$ot_person->function_name}}</div>
                  <div class="col s2"><b>Location:</b> {{$ot_person->location_name}}</div>
                </div>
                <div class="row">
                    <!-- Table that shows O.T Records List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>
                                <th>O.T Date</th>
                                <th>O.T Type</th>
                                <th>Reason</th>
                                <th>Remark</th> 
                                <th>From</th>
                                <th>To</th>                                
                                <th>Minute</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $total = 0; ?>
                        @if($ot_records->count())
                            @foreach($ot_records as $ot_record)
                                    <tr>
                                        <td>{{date('d-M-Y', strtotime($ot_record->ot_date))}}</td>
										<td>{{$ot_record->ot_type}}</td>
                                        <td>{{$ot_record->OtReason->ot_reason}}</td>
                                        <td>{{$ot_record->ot_remark}}</td>
                                        <td>{{$ot_record->time_from}}</td>
                                        <td>{{$ot_record->time_to}}</td>    
                                        <td>{{$ot_record->ot_minute}}</td> 
                                    </tr>
                                <?php $total += $ot_record->ot_minute;?>       
                            @endforeach                        
                            @if($total != 0)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="right_bold">Total:</td>
                                    <td>{{ $total }}</td>
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
    <a href="/overtime/report/xlsx?staff_id={{$ot_person->staff_id}}&funct={{$ot_person->functional_id}}&loc={{$ot_person->location_id}}&from={{$date_from}}&to={{$date_to}}" class="btn cyan darken-4" style="text-transform: capitalize;">Export Excel</a>
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