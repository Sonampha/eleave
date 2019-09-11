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
        <h6 class="grey-text text-darken-2 center">Inleu Details</h6> 
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
                                <th>Staff ID</th>
                                <th>Day</th>
                                <th>Reason</th> 
                            </tr>
                        </thead>
                        <tbody>
                        <?php $total = 0; ?>
                        @if($inleu_records->count())
                            @foreach($inleu_records as $inleu_record)
                                    <tr>
                                        <td>{{date('d-M-Y', strtotime($inleu_record->inleu_date))}}</td>
                                        <td>{{$inleu_record->staff_name}}</td>
                                        <td>{{$inleu_record->staff_id}}</td>
                                        <td>{{$inleu_record->inleu_day}}</td>
                                        <td>{{$inleu_record->reason}}</td> 
                                    </tr>
                                <?php $total += $inleu_record->inleu_day;?>       
                            @endforeach                        
                            @if($total != 0)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="right_bold">Total:</td>
                                    <td>{{ $total }}</td>
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